<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Form\CompaniesType;
use App\Repository\CompaniesRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Entity\BankInformations;
use App\Entity\CompanyAccounts;
use App\Entity\CompanyDocuments;
use App\Entity\CompanyLocations;
use App\Entity\CompanyTypes;
use App\Entity\Emails;
use App\Entity\IndustryTypes;
use App\Entity\Locations;
use App\Entity\Phones;
use App\Entity\PrivateNotes;
use App\Entity\SocialMedia;
use App\Repository\CompanyAccountsRepository;
use App\Repository\CompanyDocumentsRepository;
use App\Repository\CompanyLocationsRepository;
use App\Repository\CompanyTypesRepository;
use App\Repository\DocumentTypesRepository;
use App\Repository\EmailsRepository;
use App\Repository\EmailTypesRepository;
use App\Repository\IndustryTypesRepository;
use App\Repository\LanguagesRepository;
use App\Repository\LocationTypesRepository;
use App\Repository\PhonesRepository;
use App\Repository\PhoneTypesRepository;
use App\Repository\PrivateNotesRepository;
use App\Repository\SocialMediaRepository;
use App\Repository\SocialMediaTypesRepository;
use App\Repository\SubjectsRepository;
use DateTime;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Date;

class CompaniesController extends AbstractController
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




    private function lanChooser($lng)
    {
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
     * @Route("/{lng}/companies/new", name="companies_new", methods={"GET","POST"})
     * @Breadcrumb({
     *   { "label" = "Home", "route" = "index_route" },
     *   { "label" = "Companies", "route" = "companies_route" },
     *   { "label" = "New" }
     * })
     */


    public function new(
        $lng,
        Request $request,
        LocationTypesRepository $locationTypesRepository,
        EmailTypesRepository $emailTypesRepository,
        SocialMediaTypesRepository $socialMediaTypesRepository,
        PhoneTypesRepository $phoneTypesRepository,
        SubjectsRepository $subjectsRepository,
        CompanyTypesRepository $companyTypesRepository,
        IndustryTypesRepository $industryTypesRepository
    ): Response {


        $parameters = $request->request;
        $files = $request->files;
        $method = $request->getMethod();

        //dump($parameters);

        if ($method == 'POST') {
            $company = new Companies();
            $company->setCompanyName(trim($parameters->get('comapnyName')));
            $isActive = $parameters->get('isActiveStaff') == 'true' ? true : false;
            $company->setIsActive($isActive);
            $companyType = $companyTypesRepository->findOneBy(array('id' => $parameters->get('companyType')));
            $industry = $industryTypesRepository->findOneBy(array('id' => $parameters->get('industry')));

            $company->setCompanyType($companyType);
            $company->setIndustry($industry);



            // hundle logo

            // photo part

            /** @var UploadedFile $image */
            $image = $files->get('profile_avatar');

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $newFilename = uniqid() . '.' . $image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {


                    $image->move(
                        'assets/img/companies',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $company->setCompanyLogo($newFilename);
            } else {
                $company->setCompanyLogo("null.jpg");
            }

            // add company in db
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($company);
            $entityManager->flush();



            /******************************************** */


            /************** start with locations **************/
            $locationsLengths = sizeof($parameters->get('address1'));

            for ($i = 0; $i < $locationsLengths; $i++) {

                // build the location
                $location = new Locations();

                $location->setAddresse1($parameters->get('address1')[$i]);
                $location->setAddresse2($parameters->get('address2')[$i]);
                $location->setZipCode($parameters->get('zipcode')[$i]);
                $location->setCity($parameters->get('city')[$i]);
                $location->setState($parameters->get('state')[$i]);
                $location->setCountry($parameters->get('country')[$i]);

                $locationType = $locationTypesRepository->findOneBy(array('id' => $parameters->get('locationType')[$i]));

                // first we save the location
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($location);
                $entityManager->flush();

                $companyLocation = new CompanyLocations();
                $companyLocation->setLocation($location);
                $companyLocation->setCompany($company);
                $companyLocation->setLocationType($locationType);
                $companyLocation->setIsBillingAddress(false);


                if ($locationsLengths == 1) {
                    $companyLocation->setIsBillingAddress(true);
                }


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($companyLocation);
                $entityManager->flush();
            }

            /**************** end with the locations ****************/


            /*********************** start with the phones *********************/
            $Lengths = sizeof($parameters->get('tel'));

            for ($i = 0; $i < $Lengths; $i++) {

                // build the location
                $phone = new Phones();

                $tel = trim($parameters->get('tel')[$i]);
                $tel = str_replace(" ", "", $tel);
                $code = $parameters->get('tel1Code')[$i];

                $tel = '(' . $code . ')' . ' ' . $tel;

                $phoneType = $phoneTypesRepository->findOneBy(array('id' => $parameters->get('phoneType')[$i]));
                $phone->setPhoneNumber($tel);
                $phone->setCompany($company);
                $phone->setDisplayOrder(($i + 1));
                $phone->setPhoneType($phoneType);
                $phone->setExtension(trim($parameters->get('extension')[$i]));

                // now we save it
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($phone);
                $entityManager->flush();
            }
            /*********************** end with the phones *********************/

            /*********************** start with the emails *********************/
            $Lengths = sizeof($parameters->get('email'));

            for ($i = 0; $i < $Lengths; $i++) {

                // build the location
                $email = new Emails();

                $emailType = $emailTypesRepository->findOneBy(array('id' => $parameters->get('emailType')[$i]));
                $email->setEmailType($emailType);
                $email->setEmail(trim($parameters->get('email')[$i]));
                $email->setCompany($company);

                // now we save it
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($email);
                $entityManager->flush();
            }

            /*********************** end with the emails *********************/


            /*********************** start with the social medias *********************/
            $Lengths = sizeof($parameters->get('socialurl'));

            for ($i = 0; $i < $Lengths; $i++) {

                // build the location
                $socialMedia = new SocialMedia();

                $socialMediaType = $socialMediaTypesRepository->findOneBy(array('id' => $parameters->get('socialMediaType')[$i]));
                $socialMedia->setSocialMediaType($socialMediaType);
                $socialMedia->setSocialMedia(trim($parameters->get('socialurl')[$i]));
                $socialMedia->setCompany($company);

                // now we save it
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($socialMedia);
                $entityManager->flush();
            }
            /*********************** end with the social medias *********************/

            /** start with bank infos */
            $Lengths = sizeof($parameters->get('banknameCompany'));

            for ($i = 0; $i < $Lengths; $i++) {

                // build the location
                $bankAccount = new BankInformations();



                $bankAccount->setBankName(trim($parameters->get('banknameCompany')[$i]));
                $bankAccount->setBankAddress(trim($parameters->get('bankaddressCompany')[$i]));
                $bankAccount->setAcountNumber(trim($parameters->get('accountnumberCompany')[$i]));
                $bankAccount->setBeneficiaryName(trim($parameters->get('beneficiarynameCompany')[$i]));
                $bankAccount->setSwiftcode(trim($parameters->get('swiftcodeCompany')[$i]));


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($bankAccount);
                $entityManager->flush();

                $companyAccount = new  CompanyAccounts();
                $companyAccount->setCompany($company);
                $companyAccount->setBankInformations($bankAccount);
                $companyAccount->setOrdre($parameters->get('bankAccountOrdre')[$i]);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($companyAccount);
                $entityManager->flush();
            }


            /** end with bank infos */


            /*********************** start with the private note medias *********************/
            $privateNote = new PrivateNotes();
            $privateNote->setSubject($subjectsRepository->findOneBy(array('id' => 0)));
            $privateNote->setStaff(null);
            $privateNote->setCompany($company);

            $privateNote->setDateAddNote(new DateTime());
            $privateNote->setNote(trim($parameters->get('noteSTaff')));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($privateNote);
            $entityManager->flush();
            /*********************** end with the private note medias *********************/

            return $this->redirectToRoute('companies_route', ['lng' => $lng,]);
        }







        return $this->render('companies/new.html.twig', [
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            'location_types' => $locationTypesRepository->findAll(),
            'email_types' => $emailTypesRepository->findAll(),
            'social_media_types' => $socialMediaTypesRepository->findAll(),
            'phone_types' => $phoneTypesRepository->findAll(),
            'company_types' => $companyTypesRepository->findAll(),
            'industry_types' => $industryTypesRepository->findAll(),

        ]);
    }



    /**
     * @Route("/{id}", name="", methods={"GET"})
     */
    /**
     * @Route("/{lng}/Companies/details/{id}", name="companies_show", methods={"GET","POST","DELETE"})
     * @Breadcrumb({
     *   { "label" = "Home", "route" = "index_route" },
     *   { "label" = "Companies", "route" = "companies_route" },
     *   { "label" = "Details"}
     * })
     */

    public function show(
        Companies $company,
        $lng,
        LocationTypesRepository $locationTypesRepository,
        EmailTypesRepository $emailTypesRepository,
        SocialMediaTypesRepository $socialMediaTypesRepository,
        PhoneTypesRepository $phoneTypesRepository,
        SubjectsRepository $subjectsRepository,
        CompanyTypesRepository $companyTypesRepository,
        IndustryTypesRepository $industryTypesRepository,
        LanguagesRepository $languagesRepository,
        PrivateNotesRepository $privateNotesRepository,
        CompanyLocationsRepository $companyLocationsRepository,
        PhonesRepository $phonesRepository,
        EmailsRepository $emailsRepository,
        SocialMediaRepository $socialMediaRepository,
        DocumentTypesRepository $documentTypesRepository,
        CompanyAccountsRepository $companyAccountsRepository,
        CompanyDocumentsRepository $companyDocumentsRepository,
        Request $request
    ): Response {


        $parameters = $request->request;
        $files = $request->files;
        $method = $request->getMethod();


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
                    $image->move('assets/img/companies',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $company->setCompanyLogo ($newFilename);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($company);
                $entityManager->flush();
            }
            
            }
        }

        


        /*new note*/

        if ($method == 'POST') {

            if ($parameters->get('noteToAdd') != null) {
                $privateNote = new PrivateNotes();
                $privateNote->setCompany($company);
                $privateNote->setDateAddNote(new DateTime());
                $privateNote->setNote(trim($parameters->get('noteToAdd')));
                $privateNote->setSubject($subjectsRepository->findOneBy(array('id' => $parameters->get('subjectID'))));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($privateNote);
                $entityManager->flush();
            }
        }


        // update note 

        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('noteEdit')) {
                $id = $parameters->get('id');
                $noteTxt = trim($parameters->get('editNote'));
                $note = $privateNotesRepository->findOneBy(array('id' => $id));
                $note->setNote($noteTxt);
                $this->getDoctrine()->getManager()->flush();
            }
        }


        // end update note






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

                $locationType = $locationTypesRepository->findOneBy(array('id' => $parameters->get('locationType')));

                // first we save the location
                // first we save the location
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($location);
                $entityManager->flush();

                $companyLocation = new CompanyLocations();
                $companyLocation->setLocation($location);
                $companyLocation->setCompany($company);
                $companyLocation->setLocationType($locationType);
                $companyLocation->setIsBillingAddress(false);


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($companyLocation);
                $entityManager->flush();
            }
        }


        // end add new location


        // edit location


        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('editAddress')) {
                //dump($parameters);
                // first 

                $isBillingAddress = $parameters->get('isBillingAddress') == 'on' ? true : false;

                if ($isBillingAddress == true) {
                    // set all location to false

                    for ($i=0; $i < sizeof($company->getCompanyLocations()) ; $i++) { 
                        $cl = $company->getCompanyLocations()[$i];
                        $cl->setIsBillingAddress(false);
                        $this->getDoctrine()->getManager()->flush();
                    }
                }

                $locationCompany = $companyLocationsRepository->findOneBy(array('id' => $parameters->get('editAddress')));

                $locationCompany->setIsBillingAddress($isBillingAddress);

                $location = $locationCompany->getLocation();

                $location->setAddresse1($parameters->get('address1'));
                $location->setAddresse2($parameters->get('address2'));
                $location->setZipCode($parameters->get('zipcode'));
                $location->setCity($parameters->get('city'));
                $location->setState($parameters->get('state'));
                $location->setCountry($parameters->get('country'));
                

                


                $locationType = $locationTypesRepository->findOneBy(array('id' => $parameters->get('locationType')));

                // first we save the location
                $locationCompany->setLocationType($locationType);


                $this->getDoctrine()->getManager()->flush();
            }
        }


        //end edit location

        // delete address


        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('idAddressDelete')) {
                $locationCompany = $companyLocationsRepository->findOneBy(array('id' => $parameters->get('idAddressDelete')));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($locationCompany);
                $entityManager->flush();
            }
        }
        // end delete address


        // add new phone


        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('addNewPhone')) {
                // build the location
                $phone = new Phones();

                $tel = trim($parameters->get('tel'));
                $tel = str_replace(" ", "", $tel);
                $code = $parameters->get('tel1Code');

                $tel = '(' . $code . ')' . ' ' . $tel;

                $phoneType = $phoneTypesRepository->findOneBy(array('id' => $parameters->get('phoneType')));
                $phone->setPhoneNumber($tel);
                $phone->setCompany($company);
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
                $phone = $phonesRepository->findOneBy(array('id' => $parameters->get('idDeletePhone')));
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
                $phone = $phonesRepository->findOneBy(array('id' => $parameters->get('editOldPhone')));

                $tel = trim($parameters->get('tel'));
                $arrTel = explode(" ", $tel);
                $code = $arrTel[0];

                $tel = '(' . $code . ')' . ' ' . $arrTel[1];

                $phoneType = $phoneTypesRepository->findOneBy(array('id' => $parameters->get('phoneType')));
                $phone->setPhoneNumber($tel);
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

                $emailType = $emailTypesRepository->findOneBy(array('id' => $parameters->get('emailType')));
                $email->setEmailType($emailType);
                $email->setEmail(trim($parameters->get('email')));
                $email->setCompany($company);

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
                $email = $emailsRepository->findOneBy(array('id' => $parameters->get('editOldEmail')));

                $emailType = $emailTypesRepository->findOneBy(array('id' => $parameters->get('emailType')));
                $email->setEmailType($emailType);
                $email->setEmail(trim($parameters->get('email')));
                // now we save it
                $this->getDoctrine()->getManager()->flush();
            }
        }

        //end update email


        // delete email

        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('idDeleteEmail')) {
                $email = $emailsRepository->findOneBy(array('id' => $parameters->get('idDeleteEmail')));
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

                $socialMediaType = $socialMediaTypesRepository->findOneBy(array('id' => $parameters->get('socialMediaType')));
                $socialMedia->setSocialMediaType($socialMediaType);
                $socialMedia->setSocialMedia(trim($parameters->get('socialurl')));
                $socialMedia->setCompany($company);

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
                $socialMedia = $socialMediaRepository->findOneBy(array('id' => $parameters->get('updateSocialMedia')));

                $socialMediaType = $socialMediaTypesRepository->findOneBy(array('id' => $parameters->get('socialMediaType')));
                $socialMedia->setSocialMediaType($socialMediaType);
                $socialMedia->setSocialMedia(trim($parameters->get('socialurl')));

                // now we save it
                $this->getDoctrine()->getManager()->flush();
            }
        }

        //end update social media


        // delete social media

        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('idDeleteSocialMedia')) {
                $socialMedia = $socialMediaRepository->findOneBy(array('id' => $parameters->get('idDeleteSocialMedia')));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($socialMedia);
                $entityManager->flush();
            }
        }


        // end delete social media


        // add new bank account



        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('addNewBankAccount')) {
                $bankAccount = new BankInformations();



                $bankAccount->setBankName(trim($parameters->get('banknameCompany')));
                $bankAccount->setBankAddress(trim($parameters->get('bankaddressCompany')));
                $bankAccount->setAcountNumber(trim($parameters->get('accountnumberCompany')));
                $bankAccount->setBeneficiaryName(trim($parameters->get('beneficiarynameCompany')));
                $bankAccount->setSwiftcode(trim($parameters->get('swiftcodeCompany')));


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($bankAccount);
                $entityManager->flush();

                $companyAccount = new  CompanyAccounts();
                $companyAccount->setCompany($company);
                $companyAccount->setBankInformations($bankAccount);
                $companyAccount->setOrdre($parameters->get('bankAccountOrdre'));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($companyAccount);
                $entityManager->flush();
            }
        }


        // end add bank account


        // edit bank account



        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('editOldAccount')) {
                $companyAccount = $companyAccountsRepository->findOneBy(array('id' => $parameters->get('editOldAccount')));
                $companyAccount->setOrdre($parameters->get('bankAccountOrdre'));
                $this->getDoctrine()->getManager()->flush();



                $bankAccount = $companyAccount->getBankInformations();


                $bankAccount->setBankName(trim($parameters->get('banknameCompany')));
                $bankAccount->setBankAddress(trim($parameters->get('bankaddressCompany')));
                $bankAccount->setAcountNumber(trim($parameters->get('accountnumberCompany')));
                $bankAccount->setBeneficiaryName(trim($parameters->get('beneficiarynameCompany')));
                $bankAccount->setSwiftcode(trim($parameters->get('swiftcodeCompany')));


                $this->getDoctrine()->getManager()->flush();
            }
        }


        // end edit account


        // delete bank account



        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('deletAccountCompany')) {
                $companyAccount = $companyAccountsRepository->findOneBy(array('id' => $parameters->get('deletAccountCompany')));



                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($companyAccount);
                $entityManager->flush();
            }
        }


        // end delete account


        //first add the Document


        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('docTypeId')) {

                //dump($parameters);

                $documentType = $documentTypesRepository->findOneBy(array('id' => $parameters->get('docTypeId')));
                $companyDocuemnt = new CompanyDocuments();
                $companyDocuemnt->setCompany($company);
                $companyDocuemnt->setDocumentType($documentType);

                if ($parameters->get('docExpiryDate') != '') {
                    $companyDocuemnt->setExpiryDate(new DateTime($parameters->get('docExpiryDate')));
                }else{
                    $companyDocuemnt->setExpiryDate(null);
                }

                

                /** @var UploadedFile $image */
            $file = $files->get('companyDocument');
    
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($file) {
                $newFilename = uniqid().'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {

                    
                    $file->move('assets/companies/files',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $companyDocuemnt->setDocPDF($newFilename);
            }else{
                $companyDocuemnt->setDocPDF("null");
            }

                


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($companyDocuemnt);
                $entityManager->flush();


                // now add files


               
            }
        }

        //end add documents

        // delete document
        if ($method == 'POST') {
            // start filling staff entity
            if ($parameters->get('idDocumentDelete')) {

                $compnayDocument = $companyDocumentsRepository->findOneBy(array('id' => $parameters->get('idDocumentDelete')));

                

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($compnayDocument);
                $entityManager->flush();
            }
        }

        //end delete document


        $formEditCompany = $this->createForm(CompaniesType::class, $company);
        $formEditCompany->handleRequest($request);


        return $this->render('companies/show.html.twig', [
            'company' => $company,
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            'location_types' => $locationTypesRepository->findAll(),
            'email_types' => $emailTypesRepository->findAll(),
            'social_media_types' => $socialMediaTypesRepository->findAll(),
            'phone_types' => $phoneTypesRepository->findAll(),
            'company_types' => $companyTypesRepository->findAll(),
            'industry_types' => $industryTypesRepository->findAll(),
            'languages' => $languagesRepository->findAll(),
            'subjects' => $subjectsRepository->findAll(),
            'document_types' => $documentTypesRepository->findBy(array('documentRef' => 2)),
            'formEditCompany'=>$formEditCompany->createView(),
        ]);
    }

    


    
    /**
      * @Route("/{lng}/Companies/update_state/{id}", name="update_state_company")
     */

    public function update_state($id, CompaniesRepository $condidatesRepository ):JsonResponse {

        $company = $condidatesRepository->findOneBy(array('id'=>$id));

        $company->setIsActive(! $company->getIsActive());
        $this->getDoctrine()->getManager()->flush();

        return $this->json(array("newSatate"=>$company->getIsActive()));
    }









    /**
     * @Route("/{id}/edit", name="companies_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Companies $company): Response
    {
        $form = $this->createForm(CompaniesType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('companies_index');
        }

        return $this->render('companies/edit.html.twig', [
            'company' => $company,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="companies_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Companies $company): Response
    {
        if ($this->isCsrfTokenValid('delete' . $company->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($company);
            $entityManager->flush();
        }

        return $this->redirectToRoute('companies_index');
    }
}
