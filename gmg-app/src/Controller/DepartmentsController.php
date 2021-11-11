<?php

namespace App\Controller;

use App\Entity\Departments;
use App\Form\DepartmentsType;
use App\Repository\DepartmentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Form\DepartmentsTypeEdit;

class DepartmentsController extends AbstractController
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
     * @Route("/{lng}/config/departments", name="departments_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Departments",},
      
      * })
     */
    public function index(DepartmentsRepository $departmentsRepository, $lng): Response
    {
        return $this->render('departments/index.html.twig', [
            'departments' => $departmentsRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }


    /**
     * @Route("/{lng}/config/departments/new", name="departments_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Departments", "route" = "departments_index"},
      *   { "label" = "New"},
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $department = new Departments();
        $form = $this->createForm(DepartmentsType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($department);
            $entityManager->flush();
            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('departments_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('departments_index',['lng' => $lng,]);
            }
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);
            return $this->render('departments/new.html.twig', [
                'department' => $department,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);
        }


    }



    /**
     * @Route("/{lng}/config/departments/edit/{id}", name="departments_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Departments", "route" = "departments_index"},
      *   { "label" = "Edit"},
      * })
     */
    public function edit(Request $request, Departments $department, $lng): Response
    {
        $form = $this->createForm(DepartmentsTypeEdit::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('departments_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('departments/edit.html.twig', [
                'department' => $department,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 

        }

    }

    /**
     * @Route("/{lng}/config/departments/delete/{id}", name="departments_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Departments $department, $lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$department->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($department);
            $entityManager->flush();
        }

        return $this->redirectToRoute('departments_index',['lng' => $lng,]);
    }
}
