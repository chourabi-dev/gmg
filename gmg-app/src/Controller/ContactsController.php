<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Form\ContactsType;
use App\Repository\ContactsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Entity\CandidatesLanguages;
use App\Entity\CompanyContacts;
use App\Entity\ContactsLanguages;
use App\Entity\Emails;
use App\Entity\Locations;
use App\Entity\Phones;
use App\Entity\PrivateNotes;
use App\Entity\SocialMedia;
use App\Repository\CompaniesRepository;
use App\Repository\EmailTypesRepository;
use App\Repository\LanguagesRepository;
use App\Repository\LocationsRepository;
use App\Repository\LocationTypesRepository;
use App\Repository\PhoneTypesRepository;
use App\Repository\SocialMediaTypesRepository;
use App\Repository\SubjectsRepository;
use DateTime;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ContactsController extends AbstractController
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
      * @Route("/{lng}/contacts/new", name="contacts_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Contacts", "route" = "contacts_route" },
      *   { "label" = "New" }
      * })
     */

    public function new(Request $request,$lng,LanguagesRepository $languagesRepository,
    LocationTypesRepository $locationTypesRepository,
    PhoneTypesRepository $phoneTypesRepository,
    EmailTypesRepository $emailTypesRepository,
    SocialMediaTypesRepository $socialMediaTypesRepository,
    CompaniesRepository $companiesRepository,
    LocationsRepository $locationsRepository,
    SubjectsRepository $subjectsRepository
    ): Response
    {
        $contact = new Contacts();
        
        $parameters = $request->request;
        $files = $request->files;
        $method = $request->getMethod();

        if ($method == 'POST') {

            // hundle the location first so we can add the contact
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




            // hundle contact
            $contact->setGender($parameters->get('Gender')); 
            $contact->setFirstname(trim($parameters->get('firstname')));
            $contact->setLastname(trim($parameters->get('lastname')));
            $contact->setDobContact($parameters->get('dob'));
            $contact->setNationality($parameters->get('nationality'));
            $isActive = $parameters->get('isActiveStaff') == 'true' ? true : false;
            $contact->setIsActive($isActive);
            $contact->setLocation($location);
            
            
            // photo part
            
            /** @var UploadedFile $image */
            $image = $files->get('profile_avatar');
    
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {

                    
                    $image->move('assets/img/contacts',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $contact->setAvatar($newFilename);
            }else{
                $contact->setAvatar("null.jpg");
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            // contact saved




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
                $phone->setPhoneNumber($tel);
                $phone->setCandidate(null);
                $phone->setDisplayOrder(($i+1));
                $phone->setPhoneType($phoneType);
                $phone->setExtension(trim($parameters->get('extension')[$i] ));
                $phone->setContact($contact);

                // now we save it
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($phone);
                $entityManager->flush();
            }
            /*********************** end with the phones *********************/

            /*********************** start with the emails *********************/
            $Lengths = sizeof($parameters->get('email'));

            for ($i=0; $i < $Lengths ; $i++) { 
                
                // build the location
                $email = new Emails();

                $emailType = $emailTypesRepository->findOneBy(array('id'=>$parameters->get('emailType')[$i]));
                $email->setEmailType($emailType);
                $email->setEmail( trim($parameters->get('email')[$i]) );
                $email->setCandiate(null);
                $email->setContact($contact);
                

                // now we save it
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($email);
                $entityManager->flush();
            }

            /*********************** end with the emails *********************/


            /*********************** start with the social medias *********************/
            $Lengths = sizeof($parameters->get('socialurl'));

            for ($i=0; $i < $Lengths ; $i++) { 
                
                // build the location
                $socialMedia = new SocialMedia();

                $socialMediaType = $socialMediaTypesRepository->findOneBy(array('id'=>$parameters->get('socialMediaType')[$i]));
                $socialMedia->setSocialMediaType($socialMediaType);
                $socialMedia->setSocialMedia( trim($parameters->get('socialurl')[$i]) );
                $socialMedia->setCandidate(null);
                $socialMedia->setContact($contact);
                

                // now we save it
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($socialMedia);
                $entityManager->flush();
            }
            /*********************** end with the social medias *********************/


            /*********************** start with the private note medias *********************/
            $privateNote = new PrivateNotes();
            $privateNote->setSubject( $subjectsRepository->findOneBy(array('id'=>0)) );
            
            $privateNote->setContact($contact);
            
            
            $privateNote->setDateAddNote(new DateTime());
            $privateNote->setNote(trim($parameters->get('noteSTaff')));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($privateNote);
            $entityManager->flush();
            /*********************** end with the private note medias *********************/


            /*********************** start with the languages *********************/
            $Lengths = sizeof($parameters->get('language'));

            for ($i=0; $i < $Lengths ; $i++) { 
                
                // build the location
                $contactsLanguages = new ContactsLanguages();

                $language = $languagesRepository->findOneBy(array('id'=>$parameters->get('language')[$i]));

                $contactsLanguages->setLanguage($language);
                $contactsLanguages->setDisplayOrder(0);
                $contactsLanguages->setContact($contact);
                $contactsLanguages->setLevel($parameters->get('levelLng')[$i]);
                $contactsLanguages->setStatus($parameters->get('statusLng')[$i]);
                



                // now we save it
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($contactsLanguages);
                $entityManager->flush();
            }
            /*********************** end with the languages *********************/



            /*********************** start with the company contact *********************/
            $Lengths = sizeof($parameters->get('company_name'));

            for ($i=0; $i < $Lengths ; $i++) { 
                
                // build the location
                $companyContacts = new CompanyContacts();

                $company= $companiesRepository->findOneBy(array('id'=>$parameters->get('company_name')[$i]));
                $companyContacts->setTitle($parameters->get('title')[$i]);
                $companyContacts->setDepartement($parameters->get('department')[$i]);
                $companyContacts->setVcard($parameters->get('vcard')[$i]);
                $companyContacts->setCompany($company);
                $companyContacts->setContact($contact);

                // hundle business card docs
                
                // photo part
            
            /** @var UploadedFile $image */
            $image = $files->get('business_card_f1')[$i];
    
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {

                    
                    $image->move('assets/contacts/businessCards',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $companyContacts->setBusinessCardFaceOne($newFilename);
            }else{
                $companyContacts->setBusinessCardFaceOne("null");
            }

            /** @var UploadedFile $image */
            $image = $files->get('business_card_f2')[$i];
    
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {

                    
                    $image->move('assets/contacts/businessCards',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $companyContacts->setBusinessCardFaceTwo($newFilename);
            }else{
                $companyContacts->setBusinessCardFaceTwo("null");
            }

            
                // now we save it
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($companyContacts);
                $entityManager->flush();
            }
            /*********************** end with the languages *********************/

            return $this->redirectToRoute('contacts_route',['lng' => $lng,]);

        }


        return $this->render('contacts/new.html.twig', [
            'contact' => $contact,
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            'languages'=>$languagesRepository->findAll(),
            'location_types'=>$locationTypesRepository->findAll(),
            'phone_types'=>$phoneTypesRepository->findAll(),
            'email_types'=>$emailTypesRepository->findAll(),
            'social_media_types'=>$socialMediaTypesRepository->findAll(),
            'companies'=>$companiesRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="contacts_show", methods={"GET"})
     */
    public function show(Contacts $contact): Response
    {
        return $this->render('contacts/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contacts_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contacts $contact): Response
    {
        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contacts_index');
        }

        return $this->render('contacts/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contacts_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Contacts $contact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contacts_index');
    }
}
