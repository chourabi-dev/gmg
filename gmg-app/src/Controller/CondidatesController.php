<?php

namespace App\Controller;
use DateTime;
use App\Entity\Condidates;
use App\Form\CondidatesType;
use App\Repository\CondidatesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Entity\CandidateDocuments;
use App\Entity\CandidateLocations;
use App\Entity\CandidateSkills;
use App\Entity\CandidatesLanguages;
use App\Entity\CandidatesPayment;
use App\Entity\Emails;
use App\Entity\Files;
use App\Entity\Locations;
use App\Entity\PaymentHistory;
use App\Entity\Phones;
use App\Entity\PrivateNotes;
use App\Entity\SocialMedia;
use App\Entity\Status;
use App\Entity\StatusContract;
use App\Entity\User;
use App\Repository\AgenciesRepository;
use App\Repository\CandidateDocumentsRepository;
use App\Repository\CandidateLocationsRepository;
use App\Repository\CandidateSkillsRepository;
use App\Repository\CandidatesLanguagesRepository;
use App\Repository\CandidatesPaymentRepository;
use App\Repository\ContractStatusTypesRepository;
use App\Repository\ContractTypesRepository;
use App\Repository\DepartmentsRepository;
use App\Repository\DocumentTypesRepository;
use App\Repository\EmailsRepository;
use App\Repository\EmailTypesRepository;
use App\Repository\FamilyStatusTypesRepository;
use App\Repository\LanguagesRepository;
use App\Repository\LocationTypesRepository;
use App\Repository\PackTypesRepository;
use App\Repository\PaymentModesRepository;
use App\Repository\PhonesRepository;
use App\Repository\PhoneTypesRepository;
use App\Repository\PrivateNotesRepository;
use App\Repository\RelativeTypesRepository;
use App\Repository\SkillsRepository;
use App\Repository\SocialMediaRepository;
use App\Repository\SocialMediaTypesRepository;
use App\Repository\SourceTypesRepository;
use App\Repository\StaffTypesRepository;
use App\Repository\StatusTypesRepository;
use App\Repository\SubjectsRepository;
use App\Repository\SubSkillsRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class CondidatesController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    private $encoder;
 
    public function __construct(UserPasswordEncoderInterface $encoder, Security $security)
    {
        $this->encoder = $encoder;
        $this->security = $security;
    }



    
    private function lanChooser($lng){
        $tmp = strtolower($lng);
        switch ($tmp) {
            case 'en':
                return 'en_EN';
                break;
            case 'fr':
                return 'fr_FR';
                break;
            case 'ge':
                return 'ge_GE';
                break;   
            case 'ar':
                return 'ar_AR';
                break;            
            
            default:
                return 'en_EN';
                break;
        }
    }

    


    /**
      * @Route("/{lng}/condidates/update_state/{id}", name="update_state")
     */

    public function update_state($id, CondidatesRepository $condidatesRepository ):JsonResponse {

        $candidate = $condidatesRepository->findOneBy(array('id'=>$id));

        $candidate->setIsActive(! $candidate->getIsActive());
        $this->getDoctrine()->getManager()->flush();

        return $this->json(array("newSatate"=>$candidate->getIsActive()));
    }






     /**
      * @Route("/{lng}/condidates/new", name="condidates_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Candidates", "route" = "condidates_route" },
      *   { "label" = "New" }
      * })
     */

    public function new(Request $request, $lng,
    
    FamilyStatusTypesRepository $familyStatusTypesRepository,
    DepartmentsRepository $departmentsRepository,
    AgenciesRepository $agenciesRepository,
    ContractTypesRepository $contractTypesRepository,
    DocumentTypesRepository $documentTypesRepository,
    StaffTypesRepository $staffTypesRepository,
    RelativeTypesRepository $relativeTypesRepository,
    LocationTypesRepository $locationTypesRepository,
    SocialMediaTypesRepository $socialMediaTypesRepository,
    EmailTypesRepository $emailTypesRepository,
    PhoneTypesRepository $phoneTypesRepository,
    SkillsRepository $skillsRepository,
    LanguagesRepository $languagesRepository,
    PackTypesRepository $packTypesRepository,
    SourceTypesRepository $sourceTypesRepository,
    PaymentModesRepository $paymentModesRepository,
    CandidateLocationsRepository $candidateLocationsRepository,
    SubSkillsRepository $subSkillsRepository,
    StatusTypesRepository $statusTypesRepository,
    CondidatesRepository $condidatesRepository,
    PhonesRepository $phonesRepository,
    ContractStatusTypesRepository $contractStatusTypesRepository,
    
    SubjectsRepository $subjectsRepository,
    SluggerInterface $slugger

    ): Response
    {
        
        
        //dump($request);

        $parameters = $request->request;
        $files = $request->files;
        $method = $request->getMethod();

        //dump($parameters);
        //dump($parameters);

        $condidate = new Condidates();
        if ($method == 'POST') {
            
            // start with condidate personal data
            
            $condidate->setGender($parameters->get('Gender')); 
            $condidate->setFirstname(trim($parameters->get('firstname')));
            $condidate->setLastname(trim($parameters->get('lastname')));
            $condidate->setDOB($parameters->get('dob'));
            $condidate->setNationality($parameters->get('nationality'));
            $condidate->setAffilationDate(new DateTime());

            $fst = $familyStatusTypesRepository->findOneBy(array('id'=>$parameters->get('FST')));
            $condidate->setFamilyStatusType($fst);
            $condidate->setOtherExperience($parameters->get('otherExperience'));
            $isActive = $parameters->get('isActiveStaff') == 'true' ? true : false;
            $condidate->setIsActive($isActive);


            $reffBy = trim($parameters->get('reffBy'));

            try {
                if ($reffBy != '') {
                    $refCondi = $condidatesRepository->findOneBy(array('id'=>$reffBy));
                    $condidate->setReferredBy($refCondi);
                }
            } catch (\Throwable $th) {
                //throw $th;
            }

            
            // photo part
            
            /** @var UploadedFile $image */
            $image = $files->get('profile_avatar');
    
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {

                    
                    $image->move('assets/img/condidates',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $condidate->setAvatar($newFilename);
            }else{
                $condidate->setAvatar("null.jpg");
            }

            $agency = $agenciesRepository->findOneBy(array('id'=>$parameters->get('agencyCompany')));
            $condidate->setAgency($agency);

            $source = $sourceTypesRepository->findOneBy(array('id'=>$parameters->get('sourceType')));
            $condidate->setSource($source);


            

            // application file part
            
            /** @var UploadedFile $image */
            $applicationFile = $files->get('applicationFile');
    
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($applicationFile) {
                $newFilename = uniqid().'.'.$applicationFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {

                    
                    $applicationFile->move('assets/candidates/application-files',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $condidate->setApplicationFile($newFilename);
            }else{
                $condidate->setApplicationFile("null");
            }

            // save the condidate
            $user = $this->security->getUser();

            $condidate->setCreatedAt(new Datetime());
            $condidate->setCreatedBy($user->getStaff());
            


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($condidate);
            $entityManager->flush();

            /***** end add condidate **********/


            /************** start with locations **************/
            $locationsLengths = sizeof($parameters->get('address1'));

            for ($i=0; $i < $locationsLengths ; $i++) { 
                
                // build the location
                $location = new Locations();

                $location->setAddresse1($parameters->get('address1')[$i]);
                $location->setAddresse2($parameters->get('address2')[$i]);
                $location->setZipCode($parameters->get('zipcode')[$i]);
                $location->setCity($parameters->get('city')[$i]);
                $location->setState($parameters->get('state')[$i]);
                $location->setCountry($parameters->get('country')[$i]);

                $locationType = $locationTypesRepository->findOneBy(array('id'=>$parameters->get('locationType')[$i]));

                if( $locationType ){
                    // first we save the location
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($location);
                    $entityManager->flush();

                    $candidateLocation = new CandidateLocations();
                    $candidateLocation->setLocation($location);
                    $candidateLocation->setCandidate($condidate);
                    $candidateLocation->setLocationType($locationType);

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($candidateLocation);
                    $entityManager->flush();
                }
                
                
                
            }

            /**************** end with the locations ****************/


            /*********************** start with the phones *********************/
            $Lengths = sizeof($parameters->get('tel'));

            for ($i=0; $i < $Lengths ; $i++) { 
                
                // build the location
                $phone = new Phones();

                $tel = trim($parameters->get('tel')[$i]);
                $tel = str_replace(" ","",$tel);
                $code = $parameters->get('tel1Code')[$i];
    
                $tel = '('.$code.')'.' '.$tel;

                $phoneType = $phoneTypesRepository->findOneBy(array('id'=>$parameters->get('phoneType')[$i]));
                if($phoneType){
                    $phone->setPhoneNumber($tel);
                    $phone->setCandidate($condidate);
                    $phone->setDisplayOrder(($i+1));
                    $phone->setPhoneType($phoneType);
                    $phone->setExtension(trim($parameters->get('extension')[$i] ));

                    // now we save it
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($phone);
                    $entityManager->flush();
                }
            }
            /*********************** end with the phones *********************/

            /*********************** start with the emails *********************/
            $Lengths = sizeof($parameters->get('email'));

            for ($i=0; $i < $Lengths ; $i++) { 
                
                // build the location
                $email = new Emails();

                $emailType = $emailTypesRepository->findOneBy(array('id'=>$parameters->get('emailType')[$i]));
                if($emailType){
                    $email->setEmailType($emailType);
                    $email->setEmail( trim($parameters->get('email')[$i]) );
                    $email->setCandiate($condidate);
    
                    // now we save it
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($email);
                    $entityManager->flush();
                }
            }

            /*********************** end with the emails *********************/


            /*********************** start with the social medias *********************/
            $Lengths = sizeof($parameters->get('socialurl'));

            for ($i=0; $i < $Lengths ; $i++) { 
                
                // build the location
                $socialMedia = new SocialMedia();

                $socialMediaType = $socialMediaTypesRepository->findOneBy(array('id'=>$parameters->get('socialMediaType')[$i]));
                
                if($socialMediaType){
                    $socialMedia->setSocialMediaType($socialMediaType);
                    $socialMedia->setSocialMedia( trim($parameters->get('socialurl')[$i]) );
                    $socialMedia->setCandidate($condidate);

                    // now we save it
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($socialMedia);
                    $entityManager->flush();
                }
            }
            /*********************** end with the social medias *********************/


            /*********************** start with the private note medias *********************/
            $privateNote = new PrivateNotes();
            $privateNote->setSubject( $subjectsRepository->findOneBy(array('id'=>0)) );
            $privateNote->setStaff(null);
            $privateNote->setCandidate($condidate);
            
            $privateNote->setDateAddNote(new DateTime());
            $privateNote->setNote(trim($parameters->get('noteSTaff')));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($privateNote);
            $entityManager->flush();
            /*********************** end with the private note medias *********************/


            /*********************** start with the skills *********************/
            $Lengths = sizeof($parameters->get('skill'));

            for ($i=0; $i < $Lengths ; $i++) { 
                
                try {
                    // build the location
                    $candidateSkill = new CandidateSkills();

                    $subSkill = $subSkillsRepository->findOneBy(array('id'=>$parameters->get('subskill')[$i]));

                    if($subSkill){
                        $candidateSkill->setSkill($subSkill);
                        $candidateSkill->setDisplayOrder( trim($parameters->get('orderskill')[$i]) );
                        $candidateSkill->setYearsExperience(trim($parameters->get('yearsSkill')[$i]));
                        $candidateSkill->setCandidate($condidate);

                        // now we save it
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($candidateSkill);
                        $entityManager->flush();
                    }
                } catch (\Throwable $th) {
                    
                }
            }
            /*********************** end with the skills *********************/
            


            /*********************** start with the languages *********************/
            $Lengths = sizeof($parameters->get('language'));

            for ($i=0; $i < $Lengths ; $i++) { 
                
                // build the location
                $candidateLanguage = new CandidatesLanguages();
                $language = $languagesRepository->findOneBy(array('id'=>$parameters->get('language')[$i]));

                if($language){
                    
                $candidateLanguage->setLanguage($language);
                $candidateLanguage->setDisplayOrder(0);
                $candidateLanguage->setCandidate($condidate);
                $candidateLanguage->setLevel($parameters->get('levelLng')[$i]);
                $candidateLanguage->setStatus($parameters->get('statusLng')[$i]);
                



                // now we save it
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($candidateLanguage);
                $entityManager->flush();
                }
            }
            /*********************** end with the languages *********************/




            /*********************** start with the payment *********************/
            $paymentHistory = new PaymentHistory();
            $paymentMode = $paymentModesRepository->findOneBy(array('id'=>$parameters->get('paymentMode')));

            $paymentHistory->setPaymentDate(trim($parameters->get('datePayment')));
            $paymentHistory->setAmount(trim($parameters->get('amountPayment')));
            $paymentHistory->setPaymentMode($paymentMode);


            if($paymentMode){
                // hundle receipt
                        // application file part
                
                /** @var UploadedFile $image */
                $receiptFile = $files->get('receiptFile');
        
                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($receiptFile) {
                    $newFilename = uniqid().'.'.$receiptFile->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {

                        
                        $receiptFile->move('assets/candidates/payments/receipts',
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // updates the 'imagename' property to store the PDF file name
                    // instead of its contents
                    $paymentHistory->setReceipt($newFilename);
                }else{
                    $paymentHistory->setReceipt("null");
                }


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($paymentHistory);
                $entityManager->flush();

                $candiatePayment = new CandidatesPayment();
                $candiatePayment->setCandidate($condidate);
                $candiatePayment->setNote($parameters->get('notePayment'));
                $candiatePayment->setPaymentHistory($paymentHistory);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($candiatePayment);
                $entityManager->flush();
            }

            /*********************** end with the payment *********************/


            /*********************** start with the status *********************/
            $status = new Status();
            $packType = $packTypesRepository->findOneBy(array('id'=>$parameters->get('packType')));
            $statusType = $statusTypesRepository->findOneBy(array('id'=>0));

            if($packType and $statusType){
                $status->setCandidate($condidate);
                $status->setPackType($packType);
                $status->setStatusType($statusType);
                $status->setNote("New added");
                $status->setAddDate(new datetime());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($status);
                $entityManager->flush();

            }


            /*********************** end with the status contracts *********************/


                        /*********************** start with the status *********************/
                        $status = new StatusContract();
                        $contractStatusType = $contractStatusTypesRepository->findOneBy(array('id'=>1));
                        
                        if($contractStatusType){
                            $status->setCandidate($condidate);
                        $status->setCandidate($condidate);
                        $status->setContractStatusType($contractStatusType);
                        $status->setNote("New added");
                        $status->setAddDate(new datetime());
            
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($status);
                        $entityManager->flush();
                        }
            
            
            
                        /*********************** end with the status contracts *********************/
            


            /*********************** start with the acount *********************/

            /*********************** end with the acount *********************/

            $user = new User();
            $user->setUsername(trim($parameters->get('usernameSTaff')));
            $user->setRoles(array('ROLE_CANDIDATE'));
            
            $entityManager = $this->getDoctrine()->getManager();

            $user->setPassword($this->encoder->encodePassword($user,$parameters->get('passwordSTaff')));


            $entityManager->persist($user);
            $entityManager->flush();

            $condidate->setUser($user);
            $this->getDoctrine()->getManager()->flush();


            // now redirect to staff index ( HR )

            return $this->redirectToRoute('condidates_route',['lng' => $lng,]);


        }



        // generate condidates references
        $refs = array();

        // get all condidates
        $condidatesList = $condidatesRepository->findAll();

        // for each candidate get gis phones numbers
        for ($i=0; $i < sizeof($condidatesList) ; $i++) { 
            $id = $condidatesList[$i]->getId();

            $phonesList = $phonesRepository->findBy(array('candidate'=>$condidatesList[$i]));

            // generate list option
            $label = $condidatesList[$i]->getFirstName().' '.$condidatesList[$i]->getLastName();
            for ($j=0; $j < sizeof($phonesList); $j++) { 
                $label.=' / '.$phonesList[$j]->getPhoneNumber();
            }

            array_push($refs,array('id'=>$id,'label'=>$label));
        }

        



        //dump($refs);
        return $this->render('condidates/new.html.twig', [
            'condidate' => $condidate,
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            'family_status_types' => $familyStatusTypesRepository->findAll(),
            'departments' => $departmentsRepository->findAll(),
            'agencies' => $agenciesRepository->findAll(),
            'contract_types' => $contractTypesRepository->findAll(),
            'document_types' => $documentTypesRepository->findAll(),
            'staff_types' => $staffTypesRepository->findAll(),
            'relative_types' => $relativeTypesRepository->findAll(),
            'location_types' => $locationTypesRepository->findAll(),
            'email_types' => $emailTypesRepository->findAll(),
            'social_media_types' => $socialMediaTypesRepository->findAll(),
            'phone_types' => $phoneTypesRepository->findAll(),
            'skills' => $skillsRepository->findAll(),
            'languages'=>$languagesRepository->findAll(),
            'pack_types'=>$packTypesRepository->findAll(),
            'source_types'=>$sourceTypesRepository->findAll(),
            'payment_modes'=>$paymentModesRepository->findAll(),
            'refs'=>$refs
            
            
            
            
        ]);
    }

    /**
     * @Route("/{lng}/condidates/get-subskill/{id}", name="condidates_get_sub_skills", methods={"GET"})
     */
    public function getSubSkillById($id): Response
    {
        $conn = $this->getDoctrine()->getConnection();

        $sql = 'SELECT * FROM `sub_skills` WHERE `skill_id` = ?';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($id));

        // returns an array of arrays (i.e. a raw data set)
        $subSkills =  $stmt->fetchAllAssociative();

        return $this->json($subSkills);
    }


     /**
     * @Route("/{lng}/candidates/details/{id}", name="condidates_show", methods={"GET","POST","DELETE"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Candidates", "route" = "condidates_route" },
      *   { "label" = "Details"}
      * })
     */
    public function show(Condidates $condidate,$lng,
    Request $request,
    SubjectsRepository $subjectsRepository,
    PrivateNotesRepository $privateNotesRepository,
    SkillsRepository $skillsRepository,
    SubSkillsRepository $subSkillsRepository,
    CandidateSkillsRepository $candidateSkillsRepository,
    PaymentModesRepository $paymentModesRepository,
    DocumentTypesRepository $documentTypesRepository,
    FamilyStatusTypesRepository $familyStatusTypesRepository,
    LocationTypesRepository $locationTypesRepository,
    CandidateLocationsRepository $candidateLocationsRepository,
    LanguagesRepository $languagesRepository,
    CandidatesLanguagesRepository $condidateLanguageRepository,
    PhoneTypesRepository $phoneTypesRepository,
    PhonesRepository $phonesRepository,
    EmailsRepository $emailsRepository,
    EmailTypesRepository $emailTypesRepository,
    SocialMediaTypesRepository $socialMediaTypesRepository,
    SocialMediaRepository $socialMediaRepository,
    CandidatesPaymentRepository $CandidatePaymentRepository,
    CondidatesRepository $condidatesRepository,
    CandidateDocumentsRepository $candidateDocumentsRepository
    

    ): Response
    {
        $formEditCandidate = $this->createForm(CondidatesType::class, $condidate);
        $formEditCandidate->handleRequest($request);

        if ($formEditCandidate->isSubmitted() && $formEditCandidate->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        $parameters = $request->request;
        $files = $request->files;
        $method = $request->getMethod();

        if ($method == 'POST') {
            $user = $this->security->getUser();

            $condidate->setUpdatedAt(new Datetime());
            $condidate->setUpdatedBy($user->getStaff());
            $this->getDoctrine()->getManager()->flush();
        }

                    

        //*****************avatar***************** */
        if ($method == 'POST') {

            if ($parameters->get('photoupdate') != null) {

                            // photo part
            
            /** @var UploadedFile $image */
            $image = $files->get('profile_avatar');
    
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $newFilename =uniqid().'.'.$image->guessExtension();
                try {
                    $image->move('assets/img/condidates',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $condidate->setAvatar($newFilename);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($condidate);
                $entityManager->flush();
            }
            
            }
        }

        /* ******************end avatar***************/

        /*new note*/

        if ($method == 'POST') {

            if ($parameters->get('noteToAdd') != null) {
                $privateNote = new PrivateNotes();
                $privateNote->setCandidate( $condidate );
                $privateNote->setDateAddNote(new DateTime());
                $privateNote->setNote( trim($parameters->get('noteToAdd')));
                $privateNote->setSubject( $subjectsRepository->findOneBy(array('id'=>$parameters->get('subjectID'))));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($privateNote);
                $entityManager->flush();

            }
        }
        /*end new note*/
        // update note 

        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('noteEdit')) {
                $id = $parameters->get('id');
                $noteTxt = trim($parameters->get('editNote'));
                $note = $privateNotesRepository->findOneBy(array('id'=>$id));
                $note->setNote($noteTxt);
                $this->getDoctrine()->getManager()->flush();
            }

        }


        // end update note

        //add skill
        
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('skill')) {
                //dump($parameters);
                $subSkill = $subSkillsRepository->findOneBy(array('id'=>$parameters->get('subskill')));

                $candidateSkills = new CandidateSkills();

                $candidateSkills->setCandidate($condidate);
                $candidateSkills->setSkill($subSkill);
                $candidateSkills->setDisplayOrder($parameters->get('orderskill'));
                $candidateSkills->setYearsExperience($parameters->get('expYears'));
                

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($candidateSkills);
                $entityManager->flush();

            }

        }

        //end add skill


        // delete candidate skill
        
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('deleteSkill')) {
                
                $candidateSkill = $candidateSkillsRepository->findOneBy(array('id'=>$parameters->get('idCandidateSkillDelete')));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($candidateSkill);
                $entityManager->flush();

            }

        }
        //end delete candidate skill

        
        // start with add payment
                
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('addNeWpAYMENT')) {

            $paymentHistory = new PaymentHistory();
            $paymentMode = $paymentModesRepository->findOneBy(array('id'=>$parameters->get('paymentMode')));

            $paymentHistory->setPaymentDate(trim($parameters->get('datePayment')));
            $paymentHistory->setAmount(trim($parameters->get('amountPayment')));
            $paymentHistory->setPaymentMode($paymentMode);
            

            // hundle receipt
                        // application file part
            
            /** @var UploadedFile $image */
            $receiptFile = $files->get('receiptFile');
    
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($receiptFile) {
                $newFilename = uniqid().'.'.$receiptFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {

                    
                    $receiptFile->move('assets/candidates/payments/receipts',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $paymentHistory->setReceipt($newFilename);
            }else{
                $paymentHistory->setReceipt("null");
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($paymentHistory);
            $entityManager->flush();

            $candiatePayment = new CandidatesPayment();
            $candiatePayment->setCandidate($condidate);
            $candiatePayment->setPaymentHistory($paymentHistory);
            $candiatePayment->setNote( trim($parameters->get('notePayment')) );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candiatePayment);
            $entityManager->flush();

            

            }
        }
    
        //end with add payment



        // add documents

        // delete payment

        

        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('idDeletePayment')) {
            $candiatePayment = $CandidatePaymentRepository->findOneBy(array('id'=>$parameters->get('idDeletePayment')));

            $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($candiatePayment);
                $entityManager->flush();

            }
        }

        // end delete payment

        //edit payment

        if ($method == 'POST') {

        if ($parameters->get('editPaymentId')) {

            $idPayment = $parameters->get('editPaymentId');

            $paymentHistory = $CandidatePaymentRepository->findOneBy(array('id'=>$idPayment))->getPaymentHistory();

            $paymentMode = $paymentModesRepository->findOneBy(array('id'=>$parameters->get('paymentMode')));

            $paymentHistory->setPaymentDate(trim($parameters->get('datePayment')));
            $paymentHistory->setAmount(trim($parameters->get('amountPayment')));
            $paymentHistory->setPaymentMode($paymentMode);
            

            // hundle receipt
                        // application file part
            
            /** @var UploadedFile $image */
            $receiptFile = $files->get('receiptFile');
    
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($receiptFile) {
                $newFilename = uniqid().'.'.$receiptFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {

                    
                    $receiptFile->move('assets/candidates/payments/receipts',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $paymentHistory->setReceipt($newFilename);
            }


            

            $candiatePayment = $CandidatePaymentRepository->findOneBy(array('id'=>$idPayment));
            $candiatePayment->setNote( trim($parameters->get('notePayment')) );

            $this->getDoctrine()->getManager()->flush();

            }
        }

        //end delete payemnt








        //first add the candidateDocuments
        

        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('docTypeId')) {

                //dump($parameters);

                $documentType = $documentTypesRepository->findOneBy(array('id'=>$parameters->get('docTypeId')));
                $candidateDocuemnt = new CandidateDocuments();
                $candidateDocuemnt->setCandidate($condidate);
                $candidateDocuemnt->setDocumentType($documentType);
                $candidateDocuemnt->setIdNumber(trim($parameters->get('docIDNumber')));
                $candidateDocuemnt->setIssueDate(new DateTime(trim($parameters->get('docIssueDate'))));
                $candidateDocuemnt->setExpiryDate(trim($parameters->get('docExpiryDate')));

                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($candidateDocuemnt);
                $entityManager->flush();


                // now add files


                for ($i=0; $i < sizeof($files->get('docFile')); $i++) { 
                    $file  = new Files();
                    $receiptFile = $files->get('docFile')[$i];
                    $newFilename = uniqid().'.'.$receiptFile->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
    
                        
                        $receiptFile->move('assets/candidates/files',
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
    
                    // updates the 'imagename' property to store the PDF file name
                    // instead of its contents
                    $file->setFile($newFilename);
                    $file->setCandidateDocument($candidateDocuemnt);

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($file);
                    $entityManager->flush();

                }

                

                
                
            }
        }

        //end add documents

        // delete document
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('idDocumentDelete')) {

                $candidateDocument = $candidateDocumentsRepository ->findOneBy(array('id'=>$parameters->get('idDocumentDelete')));
                
                // first delete all files

                for($i = 0; $i< sizeOf($candidateDocument->getFiles()); $i++){
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($candidateDocument->getFiles()[$i]);
                    $entityManager->flush();
                }
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($candidateDocument);
                $entityManager->flush();
        
            }
        }

        //end delete document





        // update personal info
        
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('editPInfo')) {
               
                $condidate->setDob(trim($parameters->get('ageEdit')));
                $condidate->setFamilyStatusType( $familyStatusTypesRepository->findOneBy(array('id'=>$parameters->get('fstEdit'))) );
                $condidate->setNationality(trim($parameters->get('nationalityEdit')));

                $isActive = $parameters->get('candidateIsActiveEdit') == 'on' ? true : false;
                $condidate->setIsActive($isActive);
                $this->getDoctrine()->getManager()->flush();

            }
        }


        // end update personal info

        // update other info
        
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('editOtherInfo')) {
               
                $condidate->setOtherExperience(trim($parameters->get('otherExperienceEdit')));
                $reffBy = trim($parameters->get('reffBy'));

                try {
                    if ($reffBy != '') {
                        $refCondi = $condidatesRepository->findOneBy(array('id'=>$reffBy));
                        $condidate->setReferredBy($refCondi);
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }

                
                $applicationFile = $files->get('applicationFileEdit');
    
                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($applicationFile) {
                    $newFilename = uniqid().'.'.$applicationFile->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {

                        
                        $applicationFile->move('assets/candidates/application-files',
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // updates the 'imagename' property to store the PDF file name
                    // instead of its contents
                    $condidate->setApplicationFile($newFilename);
                }
                
                
                $this->getDoctrine()->getManager()->flush();

            }
        }


        //end update other info



        // add new location


        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('addNewAddress')) {
                $location = new Locations();

                $location->setAddresse1($parameters->get('address1'));
                $location->setAddresse2($parameters->get('address2'));
                $location->setZipCode($parameters->get('zipcode'));
                $location->setCity($parameters->get('city'));
                $location->setState($parameters->get('state'));
                $location->setCountry($parameters->get('country'));
        
                $locationType = $locationTypesRepository->findOneBy(array('id'=>$parameters->get('locationType')));
        
                // first we save the location
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($location);
                $entityManager->flush();
        
                $candidateLocation = new CandidateLocations();
                $candidateLocation->setLocation($location);
                $candidateLocation->setCandidate($condidate);
                $candidateLocation->setLocationType($locationType);
        
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($candidateLocation);
                $entityManager->flush();
        
            }
        }


        // end add new location


        // edit location
        
        
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('editAddress')) {
                $locationCandidate = $candidateLocationsRepository->findOneBy(array('id'=>$parameters->get('editAddress')));
                $location = $locationCandidate->getLocation();

                $location->setAddresse1($parameters->get('address1'));
                $location->setAddresse2($parameters->get('address2'));
                $location->setZipCode($parameters->get('zipcode'));
                $location->setCity($parameters->get('city'));
                $location->setState($parameters->get('state'));
                $location->setCountry($parameters->get('country'));
                
        
                $locationType = $locationTypesRepository->findOneBy(array('id'=>$parameters->get('locationType')));
        
                // first we save the location
                $locationCandidate->setLocationType($locationType);
        
                
                $this->getDoctrine()->getManager()->flush();
        
            }
        }


        //end edit location
        
        // delete address

        
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('idAddressDelete')) {
                $locationCandidate = $candidateLocationsRepository->findOneBy(array('id'=>$parameters->get('idAddressDelete')));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($locationCandidate);
                $entityManager->flush();
        
            }
        }
        // end delete address



        // add new langauage
        
            if ($method == 'POST') {
                // start filling staff entity
                if ($parameters->get('addNewLanguage')) {
                    $candidateLanguage = new CandidatesLanguages();

                    $language = $languagesRepository->findOneBy(array('id'=>$parameters->get('language')));
            
                    $candidateLanguage->setLanguage($language);
                    $candidateLanguage->setDisplayOrder(0);
                    $candidateLanguage->setCandidate($condidate);
                    $candidateLanguage->setLevel($parameters->get('levelLng'));
                    $candidateLanguage->setStatus($parameters->get('statusLng'));
                    

                    
                    // now we save it
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($candidateLanguage);
                    $entityManager->flush();
                }
            }

        // end add new langauage

        // edit languagae

        
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('editLanguage')) {
                $candidateLanguage = $condidateLanguageRepository->findOneBy(array('id'=>$parameters->get('editLanguage')));

                $language = $languagesRepository->findOneBy(array('id'=>$parameters->get('language')));
        
                $candidateLanguage->setLanguage($language);
                $candidateLanguage->setDisplayOrder(0);
                $candidateLanguage->setCandidate($condidate);
                $candidateLanguage->setLevel($parameters->get('levelLng'));
                $candidateLanguage->setStatus($parameters->get('statusLng'));
                
                
                $this->getDoctrine()->getManager()->flush();
        
            }
        }

        // edit language


        // delete language
        
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('idDeleteLanguage')) {
                $candidateLanguage = $condidateLanguageRepository->findOneBy(array('id'=>$parameters->get('idDeleteLanguage')));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($candidateLanguage);
                $entityManager->flush();
        
            }
        }
        // delete language



        // add new phone
        

        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('addNewPhone')) {
                 // build the location
                 $phone = new Phones();

                 $tel = trim($parameters->get('tel'));
                 $tel = str_replace(" ","",$tel);
                 $code = $parameters->get('tel1Code');
     
                 $tel = '('.$code.')'.' '.$tel;
 
                 $phoneType = $phoneTypesRepository->findOneBy(array('id'=>$parameters->get('phoneType')));
                 $phone->setPhoneNumber($tel);
                 $phone->setCandidate($condidate);
                 $phone->setDisplayOrder(0);
                 $phone->setPhoneType($phoneType);
 
                 // now we save it
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($phone);
                 $entityManager->flush();
        
            }
        }

        // delete phone
        

        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('idDeletePhone')) {
                $phone = $phonesRepository->findOneBy(array('id'=>$parameters->get('idDeletePhone')));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($phone);
                $entityManager->flush();
        
            }
        }
        //eend delete phone




        // update phone
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('editOldPhone')) {
                $phone = $phonesRepository->findOneBy(array('id'=>$parameters->get('editOldPhone')));

                 $tel = trim($parameters->get('tel'));
                 $arrTel = explode(" ",$tel) ;
                 $code = $arrTel[0];
     
                 $tel = '('.$code.')'.' '.$arrTel[1];
 
                 $phoneType = $phoneTypesRepository->findOneBy(array('id'=>$parameters->get('phoneType')));
                 $phone->setPhoneNumber($tel);
                 $phone->setCandidate($condidate);
                 $phone->setDisplayOrder(0);
                 $phone->setPhoneType($phoneType);
                 $phone->setExtension(trim($parameters->get('extension')));
                 
                 
                 
 
                 // now we save it
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($phone);
                 $entityManager->flush();
        
            }
        }
        

        //end update phone.



        // add new email
        
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('addNewEmail')) {
                $email = new Emails();

                $emailType = $emailTypesRepository->findOneBy(array('id'=>$parameters->get('emailType')));
                $email->setEmailType($emailType);
                $email->setEmail( trim($parameters->get('email')) );
                $email->setCandiate($condidate);

                // now we save it
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($email);
                $entityManager->flush();
            }
        }

        //end add new email

        // update email
        
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('editOldEmail')) {
                $email = $emailsRepository->findOneBy(array('id'=>$parameters->get('editOldEmail')));

                $emailType = $emailTypesRepository->findOneBy(array('id'=>$parameters->get('emailType')));
                $email->setEmailType($emailType);
                $email->setEmail( trim($parameters->get('email')) );
                $email->setCandiate($condidate);

                // now we save it
                $this->getDoctrine()->getManager()->flush();
            }
        }

        //end update email


        // delete email
        
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('idDeleteEmail')) {
                $email = $emailsRepository->findOneBy(array('id'=>$parameters->get('idDeleteEmail')));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($email);
                $entityManager->flush();
                
            }
        }


        // end delete email




        // add new social
        
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('addNewSocial')) {
                // build the location
                $socialMedia = new SocialMedia();

                $socialMediaType = $socialMediaTypesRepository->findOneBy(array('id'=>$parameters->get('socialMediaType')));
                $socialMedia->setSocialMediaType($socialMediaType);
                $socialMedia->setSocialMedia( trim($parameters->get('socialurl')) );
                $socialMedia->setCandidate($condidate);

                // now we save it
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($socialMedia);
                $entityManager->flush();
            }
        }


        //end add new social


        // update social media 
        
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('updateSocialMedia')) {
                // build the location
                $socialMedia = $socialMediaRepository->findOneBy(array('id'=>$parameters->get('updateSocialMedia')));
                
                $socialMediaType = $socialMediaTypesRepository->findOneBy(array('id'=>$parameters->get('socialMediaType')));
                $socialMedia->setSocialMediaType($socialMediaType);
                $socialMedia->setSocialMedia( trim($parameters->get('socialurl')) );
                $socialMedia->setCandidate($condidate);

                // now we save it
                $this->getDoctrine()->getManager()->flush();
            }
        }

        //end update social media


        // delete social media
        
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('idDeleteSocialMedia')) {
                $socialMedia = $socialMediaRepository->findOneBy(array('id'=>$parameters->get('idDeleteSocialMedia')));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($socialMedia);
                $entityManager->flush();
                
            }
        }


        // end delete social media

        
        $format = 'Y-m-d';
        $date = DateTime::createFromFormat($format, $condidate->getDOB());

        $today = new DateTime();

        $diff = $today->format('U') - $date->format('U');
        $years = (((($diff / 60)  / 60)  / 24) / 365 );
        $years = round($years);


        // payments

        $payments = $condidate->getCandidatesPayments();

        $totalP = 0;

        for ($i=0; $i < sizeof($payments); $i++) { 
            $totalP+=$payments[$i]->getPaymentHistory()->getAmount();
        }

        $paymentProgress = 0;

        $packAmount = $condidate->getStatuses()[0]->getPackType()->getPrice();

        $paymentProgress = (($totalP * 100 ) / $packAmount );
        $paymentProgress = round($paymentProgress);




        ////////////
                // generate condidates references
                $refs = array();

                // get all condidates
                $condidatesList = $condidatesRepository->findAll();
        
                // for each candidate get gis phones numbers
                for ($i=0; $i < sizeof($condidatesList) ; $i++) { 
                    $id = $condidatesList[$i]->getId();
        
                    $phonesList = $phonesRepository->findBy(array('candidate'=>$condidatesList[$i]));
        
                    // generate list option
                    $label = $condidatesList[$i]->getFirstName().' '.$condidatesList[$i]->getLastName();
                    for ($j=0; $j < sizeof($phonesList); $j++) { 
                        $label.=' / '.$phonesList[$j]->getPhoneNumber();
                    }
        
                    array_push($refs,array('id'=>$id,'label'=>$label));
                }

        return $this->render('condidates/show.html.twig', [
            'candidate' => $condidate,
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            'formEditCandidate' =>$formEditCandidate->createView(),
            'age'=>$years,
            'subjects'=>$subjectsRepository->findAll() ,
            'skills' => $skillsRepository->findAll(),
            'payment_modes'=>$paymentModesRepository->findAll(),
            'document_types'=>$documentTypesRepository->findBy(array('documentRef'=>3)),
            'totalP'=>$totalP,
            'paymentProgress'=>$paymentProgress,
            'packAmount'=>$packAmount,
            'fst'=>$familyStatusTypesRepository->findAll(),
            'location_types'=>$locationTypesRepository->findAll(),
            'languages'=>$languagesRepository->findAll(),
            'phone_types' => $phoneTypesRepository->findAll(),
            'email_types' => $emailTypesRepository->findAll(),
            'social_media_types' => $socialMediaTypesRepository->findAll(),
            'refs'=>$refs
        ]);
    }

    /**
     * @Route("/{id}/edit", name="condidates_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Condidates $condidate): Response
    {
        $form = $this->createForm(CondidatesType::class, $condidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('condidates_index');
        }

        return $this->render('condidates/edit.html.twig', [
            'condidate' => $condidate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="condidates_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Condidates $condidate): Response
    {
        if ($this->isCsrfTokenValid('delete'.$condidate->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($condidate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('condidates_index');
    }
}
