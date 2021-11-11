<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Entity\Condidates;
use App\Entity\Holidays;
use App\Entity\PrivateNotes;
use App\Entity\Status;
use App\Entity\StatusContract;
use App\Entity\User;
use App\Form\HolidaysType;
use App\Repository\AgenciesRepository;
use App\Repository\AgencyToStaffRepository;
use App\Repository\CompaniesRepository;
use App\Repository\CompanyTypesRepository;
use App\Repository\CondidatesRepository;
use App\Repository\ContactsRepository;
use App\Repository\ContractsRepository;
use App\Repository\ContractStatusTypesRepository;
use App\Repository\DepartmentsRepository;
use App\Repository\HolidaysRepository;
use App\Repository\IndustryTypesRepository;
use App\Repository\PackTypesRepository;
use App\Repository\PrivateNotesRepository;
use App\Repository\SettingsRepository;
use App\Repository\SkillsRepository;
use App\Repository\StaffContractsRepository;
use App\Repository\StaffRepository;
use App\Repository\StatusTypesRepository;
use App\Repository\SubjectsRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class AppController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
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
     * @Route("/{lng}", defaults={"lng"="EN"} , name="index_route")
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      * })
     */
    public function index($lng): Response
    {
        return $this->render('app/index.html.twig', [
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            
            

        ]);
    }
    
    /**
     * @Route("/{lng}/settings", defaults={"lng"="EN"} , name="setting_route")
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Setting" },
      * })
     */
    public function setting($lng , HolidaysRepository $holidaysRepository,Request $request, SettingsRepository $settingsRepository): Response
    {

        // get the saved settings
        $settings = $settingsRepository->find(1);


        // get holidays list
        

        // holidays add
        $holiday = new Holidays();
        $form = $this->createForm(HolidaysType::class, $holiday);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($holiday);
            $entityManager->flush();
            unset($holiday);
            unset($form);
            $holiday = new Holidays();
            $form = $this->createForm(HolidaysType::class, $holiday);
        }
        
        
        // end holidays add


        // update maximum phone numbers

        if ($request->request ->get('phoneupdate') == "update" ) {
            $nbrMaxTel = $request->request->get('maxTelNbr');

            $settings->setNbrTelMax($nbrMaxTel);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($settings);
            $entityManager->flush();


        }

        // end nbr phone max update

        // update periodicity
        

        if ($request->request ->get('periodicityUpdate') == "update" ) {
            $tags = $request->request->get('tags');

            $tags = json_decode($tags, true);
            $periodicity = array();

            for ($i=0; $i < sizeof($tags) ; $i++) { 
                array_push($periodicity, $tags[$i]['value'] );
            }


            $settings->setPeriodicity($periodicity);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($settings);
            $entityManager->flush();


        }

        


        // update day start week

        if ($request->request ->get('dayStartWeekUpdate') == "update" ) {
            $dayStartWeek = $request->request->get('dayStartWeek');

            $settings->setDayStartWeek($dayStartWeek);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($settings);
            $entityManager->flush();


        }

        // end update day start week

        


        


        $holidays = $holidaysRepository->findAll();
        return $this->render('app/settings.html.twig', [
            'setting'=>$settings,
            'holiday' => $holiday,
            'form' => $form->createView(),
            'holidays'=>$holidays,
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            
            

        ]);
    }
    


    /**
     * @Route("/{lng}/candidates", defaults={"lng"="EN"} , name="condidates_route")
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "candidates" },
      * })
     */
    public function condidatesPage($lng, CondidatesRepository $condidatesRepository,SkillsRepository $skillsRepository,
    PackTypesRepository $packTypesRepository,
    StatusTypesRepository $statusTypesRepository,
    ContractStatusTypesRepository $contractStatusTypesRepository,
    Request $request

    
    ){

        $res = array();

        $res = $condidatesRepository->findAll();

        //dump($res);

        //dump($res[0]->getCandidateSkills()[0]);

        $skills = $skillsRepository->findAll();

        $parameters = $request->request;
        $files = $request->files;
        $method = $request->getMethod();

        if ($method == 'POST') {

            if ($parameters->get('addNewStatus') != null) {
                $status = new Status();
                $condidate = $condidatesRepository->findOneBy(array('id'=>$parameters->get('idCandidate')));

                // get latest condidate pack type

                $packType = $condidate->getStatuses()[0]->getPackType();

               
                $statusType = $statusTypesRepository->findOneBy(array('id'=>$parameters->get('statusType')));
                $status->setCandidate($condidate);
                $status->setCandidate($condidate);
                $status->setPackType($packType);
                $status->setStatusType($statusType);
                $status->setNote(trim($parameters->get('note')));
                $status->setAddDate(new datetime());

                $user = $this->security->getUser();
                $status->setStaff($user->getStaff());
                
    
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($status);
                $entityManager->flush();
    
                

            }

            


            if ($parameters->get('addNewStatusContract') != null) {
                $status = new StatusContract();
                $condidate = $condidatesRepository->findOneBy(array('id'=>$parameters->get('idCandidate')));

                // get latest condidate pack type

                

               
                $contractStatusType = $contractStatusTypesRepository->findOneBy(array('id'=>$parameters->get('contractStatusType')));
                $status->setCandidate($condidate);
                
                $status->setNote(trim($parameters->get('note')));
                $status->setAddDate(new datetime());
                $status->setContractStatusType($contractStatusType);
                $user = $this->security->getUser();
                $status->setStaff($user->getCondidates());
                
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($status);
                $entityManager->flush();
    
                


            }
        }


        

        return $this->render('app/condidates.html.twig', [
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            'candidates'=>$res,
            'skills'=>$skills,
            'pack_types'=>$packTypesRepository->findAll(),
            'status_types'=>$statusTypesRepository->findBy(array(), array('ordre' => 'ASC')),
            'contract_Status_Types'=>$contractStatusTypesRepository->findBy(array(), array('ordre' => 'ASC')),
            
            
            
            

        ]);



    }



    
    /**
     * @Route("/{lng}/contacts", defaults={"lng"="EN"} , name="contacts_route")
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Contacts" },
      * })
     */
    public function contactsPage($lng, ContactsRepository $contactsRepository,CompaniesRepository $companiesRepository ){

  

        return $this->render('app/contacts.html.twig', [
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            'contacts'=>$contactsRepository->findAll(),
            'companies'=>$companiesRepository->findAll()
            

        ]);



    }


        

        /**
         * @Route("/{lng}/companies", defaults={"lng"="EN"} , name="companies_route")
         * @Breadcrumb({
         *   { "label" = "Home", "route" = "index_route" },
        *   { "label" = "companies" },
        * })
        */
        public function companiesPage($lng, Request $request,CompaniesRepository $companiesRepository,
        CompanyTypesRepository $companyTypesRepository,
        IndustryTypesRepository $industryTypesRepository
        ){

            //dump($companiesRepository->findAll());
            

            return $this->render('app/companies.html.twig', [
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'companies'=>$companiesRepository->findAll(),
                'company_types' => $companyTypesRepository->findAll(),
                'industry_types' => $industryTypesRepository->findAll(),

            ]);
    
        }


  






    /**
     * @Route("/{lng}/hr", defaults={"lng"="EN"} , name="hr_route")
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "HR" },
      * })
     */
    public function hrPage(StaffRepository $staffRepository,$lng,
     DepartmentsRepository $departmentsRepository,
     AgencyToStaffRepository $agencyToStaffRepository,
     PrivateNotesRepository $privateNotesRepository,
     AgenciesRepository $agenciesRepository,
     StaffContractsRepository $staffContractsRepository,
     SubjectsRepository $subjectsRepository,
     Request $request
     ): Response
    {
        //dump($staffRepository->findAll());

        //get the departments for the search

        $staffs = $staffRepository->findAll();
        $staffList = array();
        $agencies = $agenciesRepository->findAll();


        for ($i=0; $i < sizeof($staffs); $i++) { 
            $agency = null;
            $contracts = null;
            $notes = null;

            $agency = $agencyToStaffRepository->findOneBy(array('staff'=>$staffs[$i]))->getAgency();
            $notes = $privateNotesRepository->findBy(array('staff'=>$staffs[$i]) , array('dateAddNote'=>'ASC'));
            $contracts = $staffContractsRepository->findBy(array('staff'=>$staffs[$i]));
            
            

            array_push($staffList,array('staff'=>$staffs[$i],'agency'=>$agency,'note'=>sizeof($notes) ==0 ? null : $notes[(sizeof($notes)-1)],'contract'=>$contracts ));

        }

       // dump($staffList);



       // hundle add note for staff

               // get staff notes

               $parameters = $request->request;
               $files = $request->files;
               $method = $request->getMethod();
       
               //dump($parameters);
               //dump($parameters);
       
               
               if ($method == 'POST') {
       
                   if ($parameters->get('noteToAdd') != null) {
                       //dump("we are here");
                       $privateNote = new PrivateNotes();
                       $privateNote->setStaff( $staffRepository->findOneBy(array('id'=>$parameters->get('idStaff'))) );
                       $privateNote->setDateAddNote(new DateTime());
                       $privateNote->setNote( trim($parameters->get('noteToAdd')));
                       $privateNote->setSubject( $subjectsRepository->findOneBy(array('id'=>$parameters->get('subjectID'))));
       
                       $entityManager = $this->getDoctrine()->getManager();
                       $entityManager->persist($privateNote);
                       $entityManager->flush();
       
                   }
               }

               $subjects = $subjectsRepository->findAll();
               $subjectsList = array();
       
               for ($i=0; $i < sizeof($subjects); $i++) { 
                   if ($subjects[$i]->getId() != 0) {
                       array_push($subjectsList,$subjects[$i]);
                   }
               }
       


        $departments = $departmentsRepository->findAll();
        return $this->render('app/hr.html.twig', [
            'departments'=>$departments,

            'agencies'=>$agencies,
            'staff' => $staffList,
            'subjects'=>$subjectsList,

            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            
            

        ]);
    }


    /**
     * @Route("/{lng}/config", defaults={"lng"="EN"} , name="config_route")
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config" },
      * })
     */
    public function configPage($lng): Response
    {
        // order alpha
        $configList = array(
            array(
                'title'=>'Contract Status Types','icon'=>'fas fa-file-contract grid-icon','link'=>'contract_status_types_index'
            ),
            array(
                'title'=>'Pack Types','icon'=>'fas fa-cubes grid-icon','link'=>'pack_types_index'
            ),
            array(
                'title'=>'Payment Modes','icon'=>'fas fa-credit-card grid-icon','link'=>'payment_modes_index'
            ),
            array(
                'title'=>'Countries','icon'=>'fas fa-globe grid-icon','link'=>'countries_index'
            ),
            array(
                'title'=>'Relative Types','icon'=>'fas fa-user-friends grid-icon','link'=>'relative_types_index'
            ),
            array(
                'title'=>'Departments','icon'=>'fas fa-building grid-icon','link'=>'departments_index'
            ),
            array(
                'title'=>'Contract Types','icon'=>'fas fa-handshake grid-icon','link'=>'contract_types_index'
            ),
            array(
                'title'=>'Agencies','icon'=>'fas fa-store grid-icon','link'=>'agencies_index'
            ),
            array(
                'title'=>'Allowance Types','icon'=>'fas fa-money-check-alt grid-icon','link'=>'allowance_types_index'
            ),
            array(
                'title'=>'Staff Types','icon'=>'fas fa-users-cog grid-icon','link'=>'staff_types_index'
            ),
            array(
                'title'=>'Company Types','icon'=>'fas fa-shopping-bag grid-icon','link'=>'company_types_index'
            ),
            array(
                'title'=>'Industry Types','icon'=>"fas fa-industry grid-icon" , 'link'=>'industry_types_index'
            ),
            array(
                'title'=>'Subjects','icon'=>"fas fa-clipboard-list grid-icon" , 'link'=>'subjects_index'
            ),
            array(
                'title'=>'Social Media Types','icon'=>"fas fa-mobile-alt grid-icon" , 'link'=>'social_media_types_index'
            ),
            array(
                'title'=>'Phone Types','icon'=>"fas fa-address-book grid-icon" , 'link'=>'phone_types_index'
            ),
            array(
                'title'=>'Email Types','icon'=>"fas fa-envelope grid-icon" , 'link'=>'email_types_index'
            ),
            array(
                'title'=>'Languages','icon'=>"fas fa-language grid-icon" , 'link'=>'languages_index'
            ),
            array(
                'title'=>'Loaction Types','icon'=>"fas fa-street-view grid-icon" , 'link'=>'location_types_index'
            ),
            array(
                'title'=>'Family Status Types','icon'=>"fas fa-user-tie grid-icon" , 'link'=>'family_status_types_index'
            ),
            array(
                'title'=>'Skills','icon'=>"fab fa-superpowers grid-icon" , 'link'=>'skills_index'
            ),
            array(
                'title'=>'Sub Skills','icon'=>"fab fa-superpowers grid-icon" , 'link'=>'sub_skills_index'
            ),
            array(
                'title'=>'Source Types','icon'=>"fas fa-link grid-icon" , 'link'=>'source_types_index'
            ),
            array(
                'title'=>'Status Types','icon'=>"fas fa-user-cog grid-icon" , 'link'=>'status_types_index'
            ),

            array(
                'title'=>'Mission Types','icon'=>"fas fa-bullseye grid-icon" , 'link'=>'mission_types_index'
            ),

            array(
                'title'=>'Currencies','icon'=>"fas fa-coins grid-icon" , 'link'=>'currencies_index'
            ),

            array(
                'title'=>'Expense Types','icon'=>"fas fa-file-invoice-dollar grid-icon" , 'link'=>'expense_types_index'
            ),

            array(
                'title'=>'Document Ref','icon'=>"fas fa-file grid-icon" , 'link'=>'document_ref_index'
            ),
            array(
                'title'=>'Document Types','icon'=>"fas fa-file-alt grid-icon" , 'link'=>'document_types_index'
            ) );

            sort($configList);
        return $this->render('app/config.html.twig', [
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            'configList'=>$configList
        ]);
    }

    
}
