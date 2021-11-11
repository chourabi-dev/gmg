<?php

namespace App\Controller;

use App\Entity\IndustryTypes;
use App\Form\IndustryTypesType;
use App\Form\IndustryTypesTypeEdit;
use App\Repository\IndustryTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;


class IndustryTypesController extends AbstractController
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
     * @Route("/{lng}/config/industry_types", defaults={"lng"="EN"} , name="industry_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Industry Types"}
      * })
     */
    public function index(IndustryTypesRepository $industryTypesRepository,$lng): Response
    {
        return $this->render('industry_types/index.html.twig', [
            'industry_types' => $industryTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/config/industry_types/new", name="industry_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Industry Types", "route" = "industry_types_index" },
      *   { "label" = "New" }
      * })
     */

    public function new(Request $request,$lng): Response
    {
        $industryType = new IndustryTypes();
        $form = $this->createForm(IndustryTypesType::class, $industryType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($industryType);
            $entityManager->flush();
            
            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('industry_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('industry_types_index',['lng' => $lng,]);
            }
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('industry_types/new.html.twig', [
                'industry_type' => $industryType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

        return $this->render('industry_types/new.html.twig', [
            'industry_type' => $industryType,
            'form' => $form->createView(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            'errors' => array()
        ]);
    }

    /**
     * @Route("/{id}", name="industry_types_show", methods={"GET"})
     */
    public function show(IndustryTypes $industryType): Response
    {
        return $this->render('industry_types/show.html.twig', [
            'industry_type' => $industryType,
        ]);
    }


    /**
     * @Route("/{lng}/config/industry_types/edit/{id}", name="industry_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Industry Types", "route" = "industry_types_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, IndustryTypes $industryType,$lng): Response
    {
        $form = $this->createForm(IndustryTypesTypeEdit::class, $industryType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('industry_types_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('industry_types/edit.html.twig', [
                'industry_type' => $industryType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);

        }




        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('company_types_index',['lng' => $lng,]);
        }else {

             
        }


    }



    /**
     * @Route("/{lng}/config/industry_types/delete/{id}", name="industry_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, IndustryTypes $industryType,$id,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$industryType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($industryType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('industry_types_index',['lng' => $lng,]);
    }
}
