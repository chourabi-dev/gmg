<?php

namespace App\Controller;

use App\Entity\StaffTypes;
use App\Form\StaffTypesType;
use App\Repository\StaffTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Form\StaffTypesTypeEdit;

class StaffTypesController extends AbstractController
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
     * @Route("/{lng}/config/staff_types", name="staff_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Staff Types"}
      * })
     */

    public function index(StaffTypesRepository $staffTypesRepository,$lng): Response
    {
        return $this->render('staff_types/index.html.twig', [
            'staff_types' => $staffTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }


    /**
     * @Route("/{lng}/config/staff_types/new", name="staff_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Staff Types", "route" = "staff_types_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $staffType = new StaffTypes();
        $form = $this->createForm(StaffTypesType::class, $staffType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($staffType);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('staff_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('staff_types_index',['lng' => $lng,]);
            }

        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('staff_types/new.html.twig', [
                'staff_type' => $staffType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 

        }
    }

    /**
     * @Route("/{id}", name="staff_types_show", methods={"GET"})
     */
    public function show(StaffTypes $staffType): Response
    {
        return $this->render('staff_types/show.html.twig', [
            'staff_type' => $staffType,
        ]);
    }


    /**
     * @Route("/{lng}/config/stuff_types/edit/{id}", name="staff_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Staff Types", "route" = "source_types_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, StaffTypes $staffType,$lng): Response
    {
        $form = $this->createForm(StaffTypesTypeEdit::class, $staffType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('staff_types_index',['lng' => $lng,]);
        }else{
            
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('staff_types/edit.html.twig', [
                'staff_type' => $staffType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);
        }

        
    }



    /**
     * @Route("/{lng}/config/stuff_types/delete/{id}", name="staff_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, StaffTypes $staffType,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$staffType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($staffType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('staff_types_index',['lng' => $lng,]);
    }
}
