<?php

namespace App\Controller;

use App\Entity\RelativeTypes;
use App\Form\RelativeTypesType;
use App\Repository\RelativeTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Form\RelativeTypesTypeEdit;

class RelativeTypesController extends AbstractController
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
     * @Route("/{lng}/config/relative_types", name="relative_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Relative Types"}
      * })
     */
    public function index(RelativeTypesRepository $relativeTypesRepository, $lng): Response
    {
        return $this->render('relative_types/index.html.twig', [
            'relative_types' => $relativeTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }



    /**
     * @Route("/{lng}/config/relative_types/new", name="relative_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Relative Types", "route" = "relative_types_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request, $lng): Response
    {
        $relativeType = new RelativeTypes();
        $form = $this->createForm(RelativeTypesType::class, $relativeType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($relativeType);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('relative_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('relative_types_index',['lng' => $lng,]);
            }

        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);
            return $this->render('relative_types/new.html.twig', [
                'relative_type' => $relativeType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);

        }

        
    }

    /**
     * @Route("/{id}", name="relative_types_show", methods={"GET"})
     */
    public function show(RelativeTypes $relativeType): Response
    {
        return $this->render('relative_types/show.html.twig', [
            'relative_type' => $relativeType,
        ]);
    }


    /**
     * @Route("/{lng}/config/relative_types/edit/{id}", name="relative_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Relative Types", "route" = "relative_types_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, RelativeTypes $relativeType, $lng): Response
    {
        $form = $this->createForm(RelativeTypesTypeEdit::class, $relativeType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('relative_types_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);
            return $this->render('relative_types/edit.html.twig', [
                'relative_type' => $relativeType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);
        }

    }

    /**
     * @Route("/{lng}/config/relative_types/delete/{id}", name="relative_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RelativeTypes $relativeType,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$relativeType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($relativeType);
            $entityManager->flush();
        }
        return $this->redirectToRoute('relative_types_index',['lng' => $lng,]);
    }
}
