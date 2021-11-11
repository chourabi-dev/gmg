<?php

namespace App\Controller;

use App\Entity\Agencies;
use App\Form\AgenciesType;
use App\Repository\AgenciesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Form\AgenciesTypeEdit;

class AgenciesController extends AbstractController
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
     * @Route("/{lng}/config/agencies", name="agencies_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Agencies",},
      
      * })
     */
    public function index(AgenciesRepository $agenciesRepository,$lng): Response
    {
        return $this->render('agencies/index.html.twig', [
            'agencies' => $agenciesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }


    /**
     * @Route("/{lng}/config/agencies/new", name="agencies_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Agencies", "route" = "agencies_index"},
      *   { "label" = "New"},
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $agency = new Agencies();
        $form = $this->createForm(AgenciesType::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agency);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('agencies_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('agencies_index',['lng' => $lng,]);
            }
        }else{

            
            $errors = $form->getErrors(true);

            $form->clearErrors(true);
            return $this->render('agencies/new.html.twig', [
                'agency' => $agency,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);
        }

        
    }


    /**
     * @Route("/{lng}/config/agencies/edit/{id}", name="agencies_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Agencies", "route" = "agencies_index"},
      *   { "label" = "Edit"},
      * })
     */
    public function edit(Request $request, Agencies $agency, $lng): Response
    {
        $form = $this->createForm(AgenciesTypeEdit::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agencies_index',['lng' => $lng,]);
        }else{

            $errors = $form->getErrors(true);

            $form->clearErrors(true);
            return $this->render('agencies/edit.html.twig', [
                'agency' => $agency,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);
        }


    }

    /**
     * @Route("/{lng}/config/agencies/delete/{id}", name="agencies_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Agencies $agency,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agency->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($agency);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agencies_index',['lng' => $lng,]);
    }
}
