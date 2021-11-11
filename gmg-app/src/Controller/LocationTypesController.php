<?php

namespace App\Controller;

use App\Entity\LocationTypes;
use App\Form\LocationTypesType;
use App\Form\LocationTypesTypeEdit;
use App\Repository\LocationTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;


class LocationTypesController extends AbstractController
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
     * @Route("/{lng}/config/loaction_types", defaults={"lng"="EN"}, name="location_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Location Types"}
      * })
     */
    public function index(LocationTypesRepository $locationTypesRepository,$lng): Response
    {
        return $this->render('location_types/index.html.twig', [
            'location_types' => $locationTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/config/location_types/new", name="location_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Location Types", "route" = "location_types_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $locationType = new LocationTypes();
        $form = $this->createForm(LocationTypesType::class, $locationType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($locationType);
            $entityManager->flush();

            
            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('location_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('location_types_index',['lng' => $lng,]);
            }
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('location_types/new.html.twig', [
                'location_type' => $locationType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 

        }

    }

    /**
     * @Route("/{id}", name="location_types_show", methods={"GET"})
     */
    public function show(LocationTypes $locationType): Response
    {
        return $this->render('location_types/show.html.twig', [
            'location_type' => $locationType,
        ]);
    }

    /**
     * @Route("/{lng}/config/location_types/edit/{id}", name="location_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Location Types", "route" = "location_types_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, LocationTypes $locationType,$lng): Response
    {
        $form = $this->createForm(LocationTypesTypeEdit::class, $locationType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('location_types_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('location_types/edit.html.twig', [
                'location_type' => $locationType,
            'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);
        }
    }

    /**
     * @Route("/{lng}/config/location_types/delete/{id}", name="location_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LocationTypes $locationType,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$locationType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($locationType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('location_types_index',['lng' => $lng,]);
    }
}
