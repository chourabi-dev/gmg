<?php

namespace App\Controller;

use App\Entity\ContractTypes;
use App\Form\ContractTypesType;
use App\Repository\ContractTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Form\ContractTypesTypeEdit;

class ContractTypesController extends AbstractController
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
     * @Route("/{lng}/config/contract_types", name="contract_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Contract Types",},
      
      * })
     */
    public function index(ContractTypesRepository $contractTypesRepository, $lng): Response
    {
        return $this->render('contract_types/index.html.twig', [
            'contract_types' => $contractTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }


    /**
     * @Route("/{lng}/config/contract_types/new", name="contract_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Contract Types", "route" = "contract_types_index"},
      *   { "label" = "New"},
      * })
     */
    public function new(Request $request, $lng): Response
    {
        $contractType = new ContractTypes();
        $form = $this->createForm(ContractTypesType::class, $contractType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contractType);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('contract_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('contract_types_index',['lng' => $lng,]);
            }

        }else{
            
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('contract_types/new.html.twig', [
                'company_type' => $contractType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
            
        }

        
    }



    /**
     * @Route("/{lng}/config/contract_types/edit/{id}", name="contract_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Contract Types", "route" = "contract_types_index"},
      *   { "label" = "Edit"},
      * })
     */
    public function edit(Request $request, ContractTypes $contractType, $lng): Response
    {
        $form = $this->createForm(ContractTypesTypeEdit::class, $contractType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contract_types_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('contract_types/edit.html.twig', [
                'contract_type' => $contractType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{lng}/config/contract_types/delete/{id}", name="contract_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ContractTypes $contractType, $lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contractType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contractType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contract_types_index',['lng' => $lng,]);
    }
}
