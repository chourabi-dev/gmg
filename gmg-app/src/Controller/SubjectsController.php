<?php

namespace App\Controller;

use App\Entity\Subjects;
use App\Form\SubjectsType;
use App\Form\SubjectsTypeEdit;
use App\Repository\SubjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;


class SubjectsController extends AbstractController
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
     * @Route("/{lng}/config/subjects", defaults={"lng"="EN"} , name="subjects_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Subjects"}
      * })
     */
    public function index(SubjectsRepository $subjectsRepository, $lng): Response
    {
        return $this->render('subjects/index.html.twig', [
            'subjects' => $subjectsRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/config/subjects/new", name="subjects_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Subjects", "route" = "subjects_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $subject = new Subjects();
        $form = $this->createForm(SubjectsType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subject);
            $entityManager->flush();


            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('subjects_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('subjects_index',['lng' => $lng,]);
            }

            
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('subjects/new.html.twig', [
                'subject' => $subject,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 

        }

        return $this->render('subjects/new.html.twig', [
            'subject' => $subject,
            'form' => $form->createView(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            'errors' => array()
        ]);
    }

    /**
     * @Route("/{id}", name="subjects_show", methods={"GET"})
     */
    public function show(Subjects $subject): Response
    {
        return $this->render('subjects/show.html.twig', [
            'subject' => $subject,
        ]);
    }

    /**
     * @Route("/{lng}/config/subjects/edit/{id}", name="subjects_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Subjects", "route" = "subjects_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, Subjects $subject,$lng): Response
    {
        $form = $this->createForm(SubjectsTypeEdit::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subjects_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('subjects/edit.html.twig', [
                'subject' => $subject,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{lng}/config/subjects/delete/{id}", name="subjects_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Subjects $subject ,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subject->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('subjects_index',['lng' => $lng,]);
    }
}
