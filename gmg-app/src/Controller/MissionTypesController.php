<?php

namespace App\Controller;

use App\Entity\MissionTypes;
use App\Form\MissionTypesType;
use App\Form\MissionTypesTypeEdit;
use App\Repository\MissionTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;


class MissionTypesController extends AbstractController
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
     * @Route("/{lng}/config/mission_types", name="mission_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Mission Types"}
      * })
     */
    public function index(MissionTypesRepository $missionTypesRepository , $lng): Response
    {
        return $this->render('mission_types/index.html.twig', [
            'mission_types' => $missionTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/config/mission_types/new", name="mission_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Mission Types", "route" = "mission_types_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request, $lng): Response
    {
        $missionType = new MissionTypes();
        $form = $this->createForm(MissionTypesType::class, $missionType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($missionType);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('mission_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('mission_types_index',['lng' => $lng,]);
            }
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('mission_types/new.html.twig', [
                'mission_type' => $missionType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{id}", name="mission_types_show", methods={"GET"})
     */
    public function show(MissionTypes $missionType): Response
    {
        return $this->render('mission_types/show.html.twig', [
            'mission_type' => $missionType,
        ]);
    }

    /**
     * @Route("/{lng}/config/mission_types/edit/{id}", name="mission_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Mission Types", "route" = "mission_types_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, MissionTypes $missionType,$lng): Response
    {
        $form = $this->createForm(MissionTypesTypeEdit::class, $missionType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mission_types_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('mission_types/edit.html.twig', [
                'mission_type' => $missionType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);
        }

    }

    /**
     * @Route("/{lng}/config/mission_types/delete/{id}", name="mission_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MissionTypes $missionType , $lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$missionType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($missionType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mission_types_index',['lng' => $lng,]);
    }
}
