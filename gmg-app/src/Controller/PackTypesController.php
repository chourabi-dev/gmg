<?php

namespace App\Controller;

use App\Entity\PackTypes;
use App\Form\PackTypesType;
use App\Repository\PackTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Form\PackTypesTypeEdit;

class PackTypesController extends AbstractController
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
     * @Route("/{lng}/config/pack_types", name="pack_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Pack Types"}
      * })
     */
    public function index(PackTypesRepository $packTypesRepository, $lng): Response
    {
        return $this->render('pack_types/index.html.twig', [
            'pack_types' => $packTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }


    /**
     * @Route("/{lng}/config/pack_types/new", name="pack_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Pack Types", "route" = "pack_types_index" },
      *   { "label" = "New" }
      * })
     */

    public function new(Request $request,$lng): Response
    {
        $packType = new PackTypes();
        $form = $this->createForm(PackTypesType::class, $packType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($packType);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('pack_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('pack_types_index',['lng' => $lng,]);
            }

        }else{
            $errors = $form->getErrors(true);
            $form->clearErrors(true);

            return $this->render('pack_types/new.html.twig', [
                'pack_type' => $packType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

        
    }

    /**
     * @Route("/{id}", name="pack_types_show", methods={"GET"})
     */
    public function show(PackTypes $packType): Response
    {
        return $this->render('pack_types/show.html.twig', [
            'pack_type' => $packType,
        ]);
    }


    /**
     * @Route("/{lng}/config/pack_types/edit/{id}", name="pack_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Pack Types", "route" = "pack_types_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, PackTypes $packType,$lng): Response
    {
        $form = $this->createForm(PackTypesTypeEdit::class, $packType);
        $form->handleRequest($request);

        

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pack_types_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('pack_types/edit.html.twig', [
                'pack_type' => $packType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);
        }
    }


    /**
     * @Route("/{lng}/config/pack_types/delete/{id}", name="pack_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PackTypes $packType,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$packType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($packType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pack_types_index',['lng' => $lng,]);
    }
}
