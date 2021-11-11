<?php

namespace App\Controller;

use App\Entity\SocialMediaTypes;
use App\Form\SocialMediaTypesType;
use App\Form\SocialMediaTypesTypeEdit;
use App\Repository\SocialMediaTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;


class SocialMediaTypesController extends AbstractController
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
     * @Route("/{lng}/config/social_media_types", defaults={"lng"="EN"}, name="social_media_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Social Media Types"}
      * })
     */
    public function index(SocialMediaTypesRepository $socialMediaTypesRepository,$lng): Response
    {
        return $this->render('social_media_types/index.html.twig', [
            'social_media_types' => $socialMediaTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/config/social_media_types/new", name="social_media_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Social Media Types", "route" = "social_media_types_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $socialMediaType = new SocialMediaTypes();
        $form = $this->createForm(SocialMediaTypesType::class, $socialMediaType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($socialMediaType);
            $entityManager->flush();


            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('social_media_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('social_media_types_index',['lng' => $lng,]);
            }
        }

        $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('social_media_types/new.html.twig', [
                'social_media_type' => $socialMediaType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
    }

    /**
     * @Route("/{id}", name="social_media_types_show", methods={"GET"})
     */
    public function show(SocialMediaTypes $socialMediaType): Response
    {
        return $this->render('social_media_types/show.html.twig', [
            'social_media_type' => $socialMediaType,
        ]);
    }

    /**
     * @Route("{lng}/config/social_media_types/edit/{id}", name="social_media_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Social Media Types", "route" = "social_media_types_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, SocialMediaTypes $socialMediaType,$lng): Response
    {
        $form = $this->createForm(SocialMediaTypesTypeEdit::class, $socialMediaType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('social_media_types_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('social_media_types/edit.html.twig', [
                'social_media_type' => $socialMediaType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }




    }

    /**
     * @Route(" /{lng}/config/social_media_types/delete/{id}", name="social_media_types_delete", methods={"DELETE"})
     * 
     */
    public function delete(Request $request, SocialMediaTypes $socialMediaType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$socialMediaType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($socialMediaType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('social_media_types_index');
    }
}
