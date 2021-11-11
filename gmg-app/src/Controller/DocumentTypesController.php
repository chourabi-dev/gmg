<?php

namespace App\Controller;

use App\Entity\DocumentTypes;
use App\Form\DocumentTypesType;
use App\Form\DocumentTypesTypeEdit;
use App\Repository\DocumentTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;

class DocumentTypesController extends AbstractController
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
     * @Route("/{lng}/config/document_types", name="document_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Document Types" }
      * })
     */
    public function index(DocumentTypesRepository $documentTypesRepository, $lng): Response
    {
        return $this->render('document_types/index.html.twig', [
            'document_types' => $documentTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/config/document_types/new", name="document_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Document Types", "route" = "document_types_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request, $lng): Response
    {
        $documentType = new DocumentTypes();
        $form = $this->createForm(DocumentTypesType::class, $documentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($documentType);
            $entityManager->flush();
            
            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('document_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('document_types_index',['lng' => $lng,]);
            }
            
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('document_types/new.html.twig', [
                'document_type' => $documentType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{id}", name="document_types_show", methods={"GET"})
     */
    public function show(DocumentTypes $documentType): Response
    {
        return $this->render('document_types/show.html.twig', [
            'document_type' => $documentType,
        ]);
    }

    /**
     * @Route("/{lng}/config/document_types/edit/{id}", name="document_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Document Types", "route" = "document_types_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, DocumentTypes $documentType,$lng): Response
    {
        $form = $this->createForm(DocumentTypesTypeEdit::class, $documentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('document_types_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('document_types/edit.html.twig', [
                'document_type' => $documentType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{lng}/config/document_types/delete/{id}", name="document_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DocumentTypes $documentType,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$documentType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($documentType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('document_types_index',['lng' => $lng,]);
    }
}
