<?php

namespace App\Controller;

use App\Entity\PhoneTypes;
use App\Form\PhoneTypesType;
use App\Form\PhoneTypesTypeEdit;
use App\Repository\PhoneTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;


class PhoneTypesController extends AbstractController
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
     * @Route("/{lng}/config/phone_types", name="phone_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Phone Types"}
      * })
     */
    public function index(PhoneTypesRepository $phoneTypesRepository,$lng): Response
    {
        return $this->render('phone_types/index.html.twig', [
            'phone_types' => $phoneTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/config/phone_types/new", name="phone_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Phone Types", "route" = "phone_types_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $phoneType = new PhoneTypes();
        $form = $this->createForm(PhoneTypesType::class, $phoneType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($phoneType);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('phone_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('phone_types_index',['lng' => $lng,]);
            }
            
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('phone_types/new.html.twig', [
                'phone_type' => $phoneType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }
    }

    /**
     * @Route("/{id}", name="phone_types_show", methods={"GET"})
     */
    public function show(PhoneTypes $phoneType): Response
    {
        return $this->render('phone_types/show.html.twig', [
            'phone_type' => $phoneType,
        ]);
    }

    /**
     * @Route("/{lng}/config/phone_types/edit/{id}", name="phone_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Phone Types", "route" = "phone_types_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, PhoneTypes $phoneType,$lng): Response
    {
        $form = $this->createForm(PhoneTypesTypeEdit::class, $phoneType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('phone_types_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('phone_types/edit.html.twig', [
                'phone_type' => $phoneType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);
        }
    }

    /**
     * @Route("/{lng}/config/phone_types/delete/{id}", name="phone_types_delete", methods={"DELETE"})
     * 
     */
    public function delete(Request $request, PhoneTypes $phoneType,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$phoneType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($phoneType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('phone_types_index',['lng' => $lng,]);
    }
}
