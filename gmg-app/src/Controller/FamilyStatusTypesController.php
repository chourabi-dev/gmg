<?php

namespace App\Controller;

use App\Entity\FamilyStatusTypes;
use App\Form\FamilyStatusTypesType;
use App\Form\FamilyStatusTypesTypeEdit;
use App\Repository\FamilyStatusTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
class FamilyStatusTypesController extends AbstractController
{
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
     * @Route("/{lng}/config/family_status_types", defaults={"lng"="EN"} , name="family_status_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Family Status Types"}
      * })
     */
    public function index(FamilyStatusTypesRepository $familyStatusTypesRepository,$lng): Response
    {
        return $this->render('family_status_types/index.html.twig', [
            'family_status_types' => $familyStatusTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("{lng}/config/family_status_types/new", name="family_status_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Family Status Types", "route" = "family_status_types_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $familyStatusType = new FamilyStatusTypes();
        $form = $this->createForm(FamilyStatusTypesType::class, $familyStatusType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($familyStatusType);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('family_status_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('family_status_types_index',['lng' => $lng,]);
            }

        }else{

            $errors = $form->getErrors(true);

            $form->clearErrors(true);
            return $this->render('family_status_types/new.html.twig', [
            'family_status_type' => $familyStatusType,
            'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);  

        }

        
    }

    /**
     * @Route("/{id}", name="family_status_types_show", methods={"GET"})
     */
    public function show(FamilyStatusTypes $familyStatusType): Response
    {
        return $this->render('family_status_types/show.html.twig', [
            'family_status_type' => $familyStatusType,
        ]);
    }

    /**
     * @Route("/{lng}/config/family_status_types/edit/{id}", name="family_status_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Family Status Types", "route" = "family_status_types_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, FamilyStatusTypes $familyStatusType,$lng): Response
    {
        $form = $this->createForm(FamilyStatusTypesTypeEdit::class, $familyStatusType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('family_status_types_index');


         
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('family_status_types/edit.html.twig', [
                'family_status_type' => $familyStatusType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{lng}/config/family_status_types/delete/{id}", name="family_status_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, FamilyStatusTypes $familyStatusType,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$familyStatusType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($familyStatusType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('family_status_types_index',['lng' => $lng,]);
    }
}
