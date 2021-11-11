<?php

namespace App\Controller;

use App\Entity\SourceTypes;
use App\Form\SourceTypesType;
use App\Form\SourceTypesTypeEdit;
use App\Repository\SourceTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;


class SourceTypesController extends AbstractController
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
     * @Route("/{lng}/config/source_types", name="source_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Source Types"}
      * })
     */
    public function index(SourceTypesRepository $sourceTypesRepository,$lng): Response
    {
        return $this->render('source_types/index.html.twig', [
            'source_types' => $sourceTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/config/source_types/new", name="source_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Source Types", "route" = "source_types_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $sourceType = new SourceTypes();
        $form = $this->createForm(SourceTypesType::class, $sourceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sourceType);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('source_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('source_types_index',['lng' => $lng,]);
            }

        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('source_types/new.html.twig', [
                'source_type' => $sourceType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 

        }
    }

    /**
     * @Route("/{id}", name="source_types_show", methods={"GET"})
     */
    public function show(SourceTypes $sourceType): Response
    {
        return $this->render('source_types/show.html.twig', [
            'source_type' => $sourceType,
        ]);
    }

    /**
     * @Route("/{lng}/config/source_types/edit/{id}", name="source_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Source Types", "route" = "source_types_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, SourceTypes $sourceType,$lng): Response
    {
        $form = $this->createForm(SourceTypesTypeEdit::class, $sourceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('source_types_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('source_types/edit.html.twig', [
                'source_type' => $sourceType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{lng}/config/source_types/delete/{id}", name="source_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SourceTypes $sourceType,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sourceType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sourceType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('source_types_index',['lng' => $lng,]);
    }
}
