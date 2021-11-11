<?php

namespace App\Controller;

use App\Entity\Skills;
use App\Form\SkillsType;
use App\Form\SkillsTypeEdit;
use App\Repository\SkillsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;


class SkillsController extends AbstractController
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
     * @Route("/{lng}/config/skills", name="skills_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Skills"}
      * })
     */
    public function index(SkillsRepository $skillsRepository,$lng): Response
    {
        return $this->render('skills/index.html.twig', [
            'skills' => $skillsRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/config/skills/new", name="skills_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Skills", "route" = "skills_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $skill = new Skills();
        $form = $this->createForm(SkillsType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($skill);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('skills_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('skills_index',['lng' => $lng,]);
            }
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('skills/new.html.twig', [
                'skill' => $skill,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }
    }


    /**
     * @Route("/{lng}/config/skills/edit/{id}", name="skills_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Skills", "route" = "skills_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, Skills $skill,$lng): Response
    {
        $form = $this->createForm(SkillsTypeEdit::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('skills_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);
    
            $form->clearErrors(true);
    
            return $this->render('skills/edit.html.twig', [
                'skill' => $skill,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);
        }

        
    }

    /**
     * @Route("/{lng}/config/skills/{id}", name="skills_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Skills $skill,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($skill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('skills_index',['lng' => $lng,]);
    }
}
