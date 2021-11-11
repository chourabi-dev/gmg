<?php

namespace App\Controller;

use App\Entity\Staff;
use App\Form\StaffType;
use App\Repository\StaffRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Entity\AgencyToStaff;
use App\Entity\Allowances;
use App\Entity\BankInformations;
use App\Entity\Contracts;
use App\Entity\EmergencyContacts;
use App\Entity\Locations;
use App\Entity\LocationToStaff;
use App\Entity\LocationTypes;
use App\Entity\PrivateNotes;
use App\Entity\StaffContracts;
use App\Entity\User;
use App\Form\AllowancesType;
use App\Form\BankInformationsType;
use App\Form\ContractsType;
use App\Form\EmergencyContactsType;
use App\Repository\AgenciesRepository;
use App\Repository\AgencyToStaffRepository;
use App\Repository\AllowancesRepository;
use App\Repository\ContractsRepository;
use App\Repository\ContractTypesRepository;
use App\Repository\DepartmentsRepository;
use App\Repository\DocumentTypesRepository;
use App\Repository\EmergencyContactsRepository;
use App\Repository\FamilyStatusTypesRepository;
use App\Repository\LocationsRepository;
use App\Repository\LocationToStaffRepository;
use App\Repository\LocationTypesRepository;
use App\Repository\PrivateNotesRepository;
use App\Repository\RelativeTypesRepository;
use App\Repository\SettingsRepository;
use App\Repository\StaffContractsRepository;
use App\Repository\StaffTypesRepository;
use App\Repository\SubjectsRepository;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;



class StaffController extends AbstractController
{
    private $encoder;
 
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
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
      * @Route("/{lng}/hr/new", name="staff_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Staff", "route" = "hr_route" },
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
    SubjectsRepository $subjectsRepository,
    SluggerInterface $slugger
    
    ): Response
    {
        
        /*$form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);*/

        /*if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($staff);
            $entityManager->flush();

            return $this->redirectToRoute('staff_index',['lng' => $lng,]);
        }*/

        $parameters = $request->request;
        $files = $request->files;
        $method = $request->getMethod();

        //dump($parameters);
        //dump($parameters);

        $staff = new Staff();
        if ($method == 'POST') {
            // start filling staff entity
            $staff->setGender($parameters->get('Gender'));
            $staff->setFirstname(trim($parameters->get('firstname')));
            $staff->setLastname(trim($parameters->get('lastname')));
            $staff->setDOB($parameters->get('dob'));
            $staff->setNationality($parameters->get('nationality'));

            $fst = $familyStatusTypesRepository->findOneBy(array('id'=>$parameters->get('FST')));
            $staff->setFamilyStatusType($fst);


            // hundle phone insert
            $tel1 = trim($parameters->get('tel1'));
            $tel1 = str_replace(" ","",$tel1);
            $tel1Code = $parameters->get('tel1Code');
            
            $tel2 = trim($parameters->get('tel2'));
            $tel2 = str_replace(" ","",$tel2);
            $tel2Code = $parameters->get('tel2Code');


            $tel1 = '('.$tel1Code.')'.' '.$tel1;
            $tel2 = '('.$tel2Code.')'.' '.$tel2;
            if ($tel2 == '') {
                $tel2 = '';
            }
            

            
            $staff->setTel1($tel1);
            $staff->setTel2($tel2);

            $staff->setPemail(trim($parameters->get('pemail')));
            $staff->setTitle(trim($parameters->get('titleCompany')));
            


            $department = $departmentsRepository->findOneBy(array('id'=>$parameters->get('departmentCompany')));
            $staff->setDepartment($department);

            
            $staffType = $staffTypesRepository->findOneBy(array('id'=>$parameters->get('stuffTypeSTaff')));
            $staff->setStaffType($staffType);


            $isActive = $parameters->get('isActiveStaff') == 'true' ? true : false;
            $staff->setIsActive($isActive);

            
            


            $bankAccount = new BankInformations();

            $bankAccount->setBankName(trim($parameters->get('banknameCompany')));
            $bankAccount->setBankAddress(trim($parameters->get('bankaddressCompany')));
            $bankAccount->setAcountNumber(trim($parameters->get('accountnumberCompany')));
            $bankAccount->setBeneficiaryName(trim($parameters->get('beneficiarynameCompany')));
            $bankAccount->setSwiftcode(trim($parameters->get('swiftcodeCompany')));
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bankAccount);
            $entityManager->flush();

            $staff->setBankInformation($bankAccount);
            
            

            // photo part
            
            /** @var UploadedFile $image */
            $image = $files->get('profile_avatar');
    
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {

                    
                    $image->move('assets/img/staff',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $staff->setPhoto($newFilename);
            }else{
                $staff->setPhoto("null.jpg");
            }


           // extension ?
           $staff->setExtension($parameters->get('extentionCompany'));
           $staff->setEmail($parameters->get('emailSTaff'));


            

            // now we need to save staff

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($staff);
            $entityManager->flush();


            // many to manys

            /************* locations part ************ */
            $location = new Locations();
            $location->setAddresse1(trim($parameters->get('address1')));
            $location->setAddresse2(trim($parameters->get('address2')));
            $location->setZipCode(trim($parameters->get('zipcode')));
            $location->setCity(trim($parameters->get('city')));
            $location->setState(trim($parameters->get('state')));
            $location->setCountry(trim($parameters->get('country')));

            // now save it in data base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($location);
            $entityManager->flush();
            $locationType = $locationTypesRepository->findOneBy(array('id'=>$parameters->get('locationType')));
            
            $locationTostaff = new LocationToStaff();
            $locationTostaff->setLocationType($locationType);
            $locationTostaff->setStaff($staff);
            $locationTostaff->setLocation($location);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($locationTostaff);
            $entityManager->flush();


            /********************** agency part ******************** */
            $agency = $agenciesRepository->findOneBy(array('id'=>$parameters->get('agencyCompany')));

            $agencyToStaff = new AgencyToStaff();
            $agencyToStaff->setAgency($agency);
            $agencyToStaff->setStaff($staff);

            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agencyToStaff);
            $entityManager->flush();


            /********************** note ********************** */
            $privateNote = new PrivateNotes();
            $privateNote->setSubject( $subjectsRepository->findOneBy(array('id'=>0)) );
            $privateNote->setStaff($staff);
            $privateNote->setDateAddNote(new DateTime());
            $privateNote->setNote($parameters->get('noteSTaff'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($privateNote);
            $entityManager->flush();

            

            // add the user now

            $user = new User();
            $user->setUsername(trim($parameters->get('usernameSTaff')));
            $user->setRoles(array('ROLE_STAFF'));
            
            $entityManager = $this->getDoctrine()->getManager();

            $user->setPassword($this->encoder->encodePassword($user,$parameters->get('passwordSTaff')));


            $entityManager->persist($user);
            $entityManager->flush();

            $staff->setUser($user);
            $this->getDoctrine()->getManager()->flush();

            // now redirect to staff index ( HR )

            return $this->redirectToRoute('hr_route',['lng' => $lng,]);

            
        }
        



        return $this->render('staff/new.html.twig', [
            'staff' => $staff,
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

        ]);
    }

     /**
     * @Route("/{lng}/hr/details/{id}", name="staff_show", methods={"GET","POST","DELETE"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "HR", "route" = "hr_route" },
      *   { "label" = "Details"}
      * })
     */
    public function show(Staff $staff,$lng,
    PrivateNotesRepository $privateNotesRepository,
    SubjectsRepository $subjectsRepository,
    Request $request,
    StaffRepository $staffRepository,
    StaffContractsRepository $staffContractsRepository,
    SluggerInterface $slugger,
    LocationToStaffRepository $locationToStaffRepository,
    AgencyToStaffRepository $agencyToStaffRepository,
    EmergencyContactsRepository $emergencyContactsRepository,
    FamilyStatusTypesRepository $familyStatusTypesRepository,
    AllowancesRepository $allowancesRepository,
    SettingsRepository $settingsRepository,
    
    $id
    ): Response
    {


        // update photo

        

        $parameters = $request->request;
        $files = $request->files;
        $method = $request->getMethod();

        //dump($parameters);
        //dump($parameters);

        
        if ($method == 'POST') {

            if ($parameters->get('photoupdate') != null) {

                            // photo part
            
            /** @var UploadedFile $image */
            $image = $files->get('profile_avatar');
    
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {

                    
                    $image->move('assets/img/staff',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $staff->setPhoto($newFilename);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($staff);
                $entityManager->flush();
            }
            
            }
        }






        // now we should get all of the staff data
        // get staff notes

        $parameters = $request->request;
        $files = $request->files;
        $method = $request->getMethod();

        //dump($parameters);
        //dump($parameters);

        
        if ($method == 'POST') {

            if ($parameters->get('noteToAdd') != null) {
                $privateNote = new PrivateNotes();
                $privateNote->setStaff( $staffRepository->findOneBy(array('id'=>$id)) );
                $privateNote->setDateAddNote(new DateTime());
                $privateNote->setNote( trim($parameters->get('noteToAdd')));
                $privateNote->setSubject( $subjectsRepository->findOneBy(array('id'=>$parameters->get('subjectID'))));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($privateNote);
                $entityManager->flush();

            }
        }
 

        //dump($request);
        $notes =$privateNotesRepository->findBy(array( 'staff'=>$staff));

       $notes = array_reverse($notes);


        $subjects = $subjectsRepository->findAll();
        $subjectsList = array();

        for ($i=0; $i < sizeof($subjects); $i++) { 
            if ($subjects[$i]->getId() != 0) {
                array_push($subjectsList,$subjects[$i]);
            }
        }

        // hundle emergency contact add
        $emergencyContact = new EmergencyContacts();
        $emergency_contact_form = $this->createForm(EmergencyContactsType::class, $emergencyContact);
        $emergency_contact_form->handleRequest($request);

        if ($emergency_contact_form->isSubmitted() && $emergency_contact_form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $emergencyContact->setStaff($staff);

            $entityManager->persist($emergencyContact);
            $entityManager->flush();

            $emergencyContact = new EmergencyContacts();
        }



        // hundle emergency contact edit
        //emergencyContactFormEdit

        $ec = $emergencyContactsRepository->findOneBy(array('staff'=>$staff));

        $emergencyContactFormEdit = $this->createForm(EmergencyContactsType::class, $ec);

        $emergencyContactFormEdit->handleRequest($request);

        if ($emergencyContactFormEdit->isSubmitted() && $emergencyContactFormEdit->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        // hundle contracts add 
        $contract = new Contracts();
        $form = $this->createForm(ContractsType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $contractPDF */
            $contractPdf = $form->get('contractPdf')->getData();

    
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($contractPdf) {
                $originalFilename = pathinfo($contractPdf->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$contractPdf->guessExtension();

                // Move the file to the directory where brochures are stored
                try {

                    
                    $contractPdf->move('assets/contracts',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                   
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $contract->setContractPdf($newFilename);
            }
            
            /** contract pdf upload */
                        /** @var UploadedFile $contractDoc */
                        $contractDoc = $form->get('contractDoc')->getData();
    
                        // this condition is needed because the 'brochure' field is not required
                        // so the PDF file must be processed only when a file is uploaded
                        if ($contractDoc) {
                            $originalFilename = pathinfo($contractDoc->getClientOriginalName(), PATHINFO_FILENAME);
                            // this is needed to safely include the file name as part of the URL
                            $safeFilename = $slugger->slug($originalFilename);
                            $newFilename = $safeFilename.'-'.uniqid().'.'.$contractDoc->guessExtension();
            
                            // Move the file to the directory where brochures are stored
                            try {
            
                                
                                $contractDoc->move('assets/contracts',
                                    $newFilename
                                );
                            } catch (FileException $e) {
                                // ... handle exception if something happens during file upload
                               
                            }
            
                            // updates the 'imagename' property to store the PDF file name
                            // instead of its contents
                            $contract->setContractDoc($newFilename);
                        }
                        
                        /** contract pdf upload */
            $contract->setStatus(true);

            // check for end date

            


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contract);
            $entityManager->flush();
            // associate the contract to the staff
            $staffContract = new StaffContracts();
            $staffContract->setStaff($staff);
            $staffContract->setContract($contract);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($staffContract);
            $entityManager->flush();
            unset($form);
            unset($contract);
            
            $contract = new Contracts();
            $form = $this->createForm(ContractsType::class, $contract);
        }


       

        $format = 'Y-m-d';
        $date = DateTime::createFromFormat($format, $staff->getDOB());

        $today = new DateTime();

        $diff = $today->format('U') - $date->format('U');
        $years = (((($diff / 60)  / 60)  / 24) / 365 );
        $years = round($years);



        // hundle bank info edit
        $bankInformation = $staff->getBankInformation();

        $bankInfoEdit = $this->createForm(BankInformationsType::class, $bankInformation);

        $bankInfoEdit->handleRequest($request);

        if ($bankInfoEdit->isSubmitted() && $bankInfoEdit->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }



        $contracts = $staffContractsRepository->findBy(array( 'staff'=>$staff));
        $locations = $locationToStaffRepository->findBy(array( 'staff'=>$staff) );
        $agency = $agencyToStaffRepository->findBy(array( 'staff'=>$staff) )[0];
        $emergencyContacts = $emergencyContactsRepository->findBy(array( 'staff'=>$staff) );




        // hundle personal info submit
        $parameters = $request->request;
        $files = $request->files;
        $method = $request->getMethod();

        //dump($parameters);
        //dump($parameters);

        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('editPInfo')) {
                //dump($parameters);
                $staff->setDOB(trim($parameters->get('ageEdit')));
                $staff->setFamilyStatusType( $familyStatusTypesRepository->findOneBy(array('id'=>$parameters->get('fstEdit'))) );
                $staff->setNationality(trim($parameters->get('nationalityEdit')));

                $tel1 = trim($parameters->get('tel1'));
                $tel1 = str_replace(" ","",$tel1);
                $tel1Code = $parameters->get('tel1Code');
                
                $tel2 = trim($parameters->get('tel2'));
                $tel2 = str_replace(" ","",$tel2);
                $tel2Code = $parameters->get('tel2Code');


                $tel1 = '('.$tel1Code.')'.' '.$tel1;
                $tel2 = '('.$tel2Code.')'.' '.$tel2;
                if ($tel2 == '') {
                    $tel2 = '';
                }

                $staff->setTel1($tel1);
                $staff->setTel2($tel2);
                $staff->setPemail(trim($parameters->get('pemailEdit')));

                if($parameters->get('isActiveStaffEdit') != null){
                    $staff->setIsActive($parameters->get('isActiveStaffEdit'));
                }else{
                    $staff->setIsActive(false);
                }
                //
                
                // update associated location
                $location = $locations[0]->getLocation();
                $location->setAddresse1(trim($parameters->get('address1Edit')));
                $location->setAddresse2(trim($parameters->get('address2Edit')));
                $location->setCountry(trim($parameters->get('countryEdit')));
                $location->setState(trim($parameters->get('stateEdit')));
                $location->setCity(trim($parameters->get('cityEdit')));
                $location->setZipCode(trim($parameters->get('zipcodeEdit')));
                $this->getDoctrine()->getManager()->flush();
                
            }
            
        }



        // main user top section edit
        // hundle contracts add 
        
        $formEditStaff = $this->createForm(StaffType::class, $staff);
        $formEditStaff->handleRequest($request);

        if ($formEditStaff->isSubmitted() && $formEditStaff->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }




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
        $contract = new Contracts();











        $periodicitys = $settingsRepository->findOneBy(array('id'=>1))->getPeriodicity();
        // allowances type form
        $allowance = new Allowances();
        $allowance_form = $this->createForm(AllowancesType::class, $allowance, [
            'periodicitys' => $periodicitys,
        ]);
        $allowance_form->handleRequest($request);

        if ($allowance_form->isSubmitted() && $allowance_form->isValid()) {
            //dump("submitted");
            //dump($allowance);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($allowance);
            $entityManager->flush();

            $allowance = new Allowances();
            $allowance_form = $this->createForm(AllowancesType::class, $allowance, [
                'periodicitys' => $periodicitys,
            ]);
                    
        }

         


        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('deleteAllow')) {
                $a = $allowancesRepository->findOneBy(array('id'=>$parameters->get('idAllowDelete')));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($a);
                $entityManager->flush();
            }
        }


        



        
        return $this->render('staff/show.html.twig', [
            'subjects'=>$subjectsList,
            'notes'=>$notes,
            'age'=>$years,
            'staff' => $staff,
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            'contract' => $contract,
            'contract_form' => $form->createView(),
            'contracts'=>$contracts,
            'locations'=>$locations,
            'agency'=>$agency,
            'emergency_contact' => $emergencyContact,
            'emergency_contact_form' => $emergency_contact_form->createView(),
            'emergencyContacts'=> sizeof($emergencyContacts) == 0 ? null : $emergencyContacts[0] ,
            'bankInfoEdit' => $bankInfoEdit->createView(),
            'formEditStaff'=>$formEditStaff->createView(),
            'emergencyContactFormEdit'=>$emergencyContactFormEdit->createView(),
            'fst'=>$familyStatusTypesRepository->findAll(),
            'allowances' => $allowancesRepository->findAll(),
            'allowance' => $allowance,
            'allowance_form' => $allowance_form->createView(),
            'periodicitys'=>$periodicitys
        ]);
    }







    /**
     * @Route("/{id}/edit", name="staff_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Staff $staff): Response
    {
        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('staff_index');
        }

        return $this->render('staff/edit.html.twig', [
            'staff' => $staff,
            'form' => $form->createView(),
        ]);
    }

}
