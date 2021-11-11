<?php

namespace App\Controller;

use App\Entity\SubSkills;
use App\Form\SubSkillsType;
use App\Form\SubSkillsTypeEdit;
use App\Repository\SubSkillsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;


class SubSkillsController extends AbstractController
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
     * @Route("/{lng}/sub/skills", name="sub_skills_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Sub Skills"}
      * })
     */
    public function index(SubSkillsRepository $subSkillsRepository,$lng): Response
    {
        return $this->render('sub_skills/index.html.twig', [
            'sub_skills' => $subSkillsRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/sub/skills/new", name="sub_skills_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Sub Skills", "route" = "sub_skills_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $subSkill = new SubSkills();
        $form = $this->createForm(SubSkillsType::class, $subSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subSkill);
            $entityManager->flush();


            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('sub_skills_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('sub_skills_index',['lng' => $lng,]);
            }

        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('sub_skills/new.html.twig', [
                'sub_skill' => $subSkill,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{id}", name="sub_skills_show", methods={"GET"})
     */
    public function show(SubSkills $subSkill): Response
    {
        return $this->render('sub_skills/show.html.twig', [
            'sub_skill' => $subSkill,
        ]);
    }

    /**
     * @Route("/{lng}/sub/skills/edit/{id}", name="sub_skills_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Sub Skills", "route" = "sub_skills_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, SubSkills $subSkill,$lng): Response
    {
        $form = $this->createForm(SubSkillsTypeEdit::class, $subSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sub_skills_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('sub_skills/edit.html.twig', [
                'sub_skill' => $subSkill,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{lng}/sub/skills/delete/{id}", name="sub_skills_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SubSkills $subSkill,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subSkill->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subSkill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sub_skills_index',['lng' => $lng,]);
    }
}
