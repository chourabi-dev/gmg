<?php

namespace App\Controller;

use App\Entity\StatusTypes;
use App\Form\StatusTypesType;
use App\Form\StatusTypesTypeEdit;
use App\Repository\StatusTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;


class StatusTypesController extends AbstractController
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
     * @Route("{lng}/config/status_types", name="status_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Status Types"}
      * })
     */
    public function index(StatusTypesRepository $statusTypesRepository,$lng): Response
    {
        return $this->render('status_types/index.html.twig', [
            'status_types' => $statusTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("{lng}/config/status_types/new", name="status_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Status Types", "route" = "status_types_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $statusType = new StatusTypes();
        $form = $this->createForm(StatusTypesType::class, $statusType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($statusType);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('status_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('status_types_index',['lng' => $lng,]);
            }

        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('status_types/new.html.twig', [
                'status_type' => $statusType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 

        }

    }

    /**
     * @Route("/{id}", name="status_types_show", methods={"GET"})
     */
    public function show(StatusTypes $statusType): Response
    {
        return $this->render('status_types/show.html.twig', [
            'status_type' => $statusType,
        ]);
    }

    /**
     * @Route("{lng}/config/status_types/edit/{id}", name="status_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Status Types", "route" = "status_types_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, StatusTypes $statusType,$lng): Response
    {
        $form = $this->createForm(StatusTypesTypeEdit::class, $statusType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('status_types_index',['lng' => $lng]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('status_types/edit.html.twig', [
                'status_type' => $statusType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("{lng}/config/status_types/delete/{id}", name="status_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, StatusTypes $statusType,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$statusType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($statusType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('status_types_index',['lng' => $lng]);
    }
}
