<?php

namespace App\Controller;

use App\Entity\Languages;
use App\Form\LanguagesType;
use App\Form\LanguagesTypeEdit;
use App\Repository\LanguagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;


class LanguagesController extends AbstractController
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
     * @Route("/{lng}/config/languages", defaults={"lng"="EN"}, name="languages_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Languages"}
      * })
     */
    public function index(LanguagesRepository $languagesRepository,$lng): Response
    {
        return $this->render('languages/index.html.twig', [
            'languages' => $languagesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/config/languages/new", name="languages_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Languages", "route" = "languages_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $language = new Languages();
        $form = $this->createForm(LanguagesType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($language);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('languages_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('languages_index',['lng' => $lng,]);
            }

        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('languages/new.html.twig', [
                'language' => $language,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }
    }

    /**
     * @Route("/{id}", name="languages_show", methods={"GET"})
     */
    public function show(Languages $language): Response
    {
        return $this->render('languages/show.html.twig', [
            'language' => $language,
        ]);
    }

    /**
     * @Route("/{lng}/config/languages/edit/{id}", name="languages_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Languages", "route" = "languages_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, Languages $language,$lng): Response
    {
        $form = $this->createForm(LanguagesTypeEdit::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('languages_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('languages/edit.html.twig', [
                'language' => $language,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);
        }

    }



    /**
     * @Route("/{lng}/config/languages/delete/{id}", name="languages_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Languages $language,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$language->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($language);
            $entityManager->flush();
        }

        return $this->redirectToRoute('languages_index',['lng' => $lng,]);
    }
}
