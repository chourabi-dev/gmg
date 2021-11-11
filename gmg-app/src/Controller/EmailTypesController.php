<?php

namespace App\Controller;

use App\Entity\EmailTypes;
use App\Form\EmailTypesType;
use App\Form\EmailTypesTypeEdit;
use App\Repository\EmailTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;

class EmailTypesController extends AbstractController
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
     * @Route("/{lng}/config/email_types" , defaults={"lng"="EN"} , name="email_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Email Types"}
      * })
     */
    public function index(EmailTypesRepository $emailTypesRepository,$lng): Response
    {
        return $this->render('email_types/index.html.twig', [
            'email_types' => $emailTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/config/email_types/new", name="email_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Email Types", "route" = "email_types_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $emailType = new EmailTypes();
        $form = $this->createForm(EmailTypesType::class, $emailType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emailType);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('email_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('email_types_index',['lng' => $lng,]);
            }
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);
          return $this->render('email_types/new.html.twig', [
                'email_type' => $emailType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);  
        }

        
    }

    /**
     * @Route("/{id}", name="email_types_show", methods={"GET"})
     */
    public function show(EmailTypes $emailType): Response
    {
        return $this->render('email_types/show.html.twig', [
            'email_type' => $emailType,
        ]);
    }

    /**
     * @Route("/{lng}/config/email_types/edit/{id}", name="email_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Email Types", "route" = "email_types_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, EmailTypes $emailType,$lng): Response
    {
        $form = $this->createForm(EmailTypesTypeEdit::class, $emailType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('email_types_index');
        }else {

            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('email_types/edit.html.twig', [
                'email_type' => $emailType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{lng}/config/email_types/delete/{id}", name="email_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EmailTypes $emailType,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emailType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emailType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('email_types_index',['lng' => $lng,]);
    }
}
