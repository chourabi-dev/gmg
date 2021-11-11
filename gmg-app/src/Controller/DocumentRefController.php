<?php

namespace App\Controller;

use App\Entity\DocumentRef;
use App\Form\DocumentRefType;
use App\Form\DocumentRefTypeEdit;
use App\Repository\DocumentRefRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;

class DocumentRefController extends AbstractController
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
     * @Route("/{lng}/config/document_ref", name="document_ref_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Document Refs" }
      * })
     */
    public function index(DocumentRefRepository $documentRefRepository,$lng): Response
    {
        return $this->render('document_ref/index.html.twig', [
            'document_refs' => $documentRefRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/config/document_ref/new", name="document_ref_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Document Refs", "route" = "document_ref_index"},
      *   { "label" = "New"},
      * })
     */
    public function new(Request $request, $lng): Response
    {
        $documentRef = new DocumentRef();
        $form = $this->createForm(DocumentRefType::class, $documentRef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($documentRef);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('document_ref_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('document_ref_index',['lng' => $lng,]);
            }

        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('document_ref/new.html.twig', [
                'document_ref' => $documentRef,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{id}", name="document_ref_show", methods={"GET"})
     */
    public function show(DocumentRef $documentRef): Response
    {
        return $this->render('document_ref/show.html.twig', [
            'document_ref' => $documentRef,
        ]);
    }

    /**
     * @Route("/{lng}/config/document_ref/edit/{id}", name="document_ref_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Document Refs", "route" = "document_ref_index"},
      *   { "label" = "Edit"},
      * })
     */
    public function edit(Request $request, DocumentRef $documentRef,$lng): Response
    {
        $form = $this->createForm(DocumentRefTypeEdit::class, $documentRef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('document_ref_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('document_ref/edit.html.twig', [
                'document_ref' => $documentRef,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{lng}/config/document_ref/delete/{id}", name="document_ref_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DocumentRef $documentRef,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$documentRef->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($documentRef);
            $entityManager->flush();
        }

        return $this->redirectToRoute('document_ref_index',['lng' => $lng,]);
    }
}
