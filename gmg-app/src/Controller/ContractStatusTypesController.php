<?php

namespace App\Controller;

use App\Entity\ContractStatusTypes;
use App\Form\ContractStatusTypesType;
use App\Repository\ContractStatusTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Form\ContractStatusTypesTypeEdit;

class ContractStatusTypesController extends AbstractController
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
     * @Route("/{lng}/config/contract_status_types", name="contract_status_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Contract Status Types",},
      
      * })
     */
    public function index(ContractStatusTypesRepository $contractStatusTypesRepository , $lng): Response
    {
        return $this->render('contract_status_types/index.html.twig', [
            'contract_status_types' => $contractStatusTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }


    /**
     * @Route("/{lng}/config/contract_status_types/new", name="contract_status_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Contract Status Types", "route" = "contract_status_types_index"},
      *   { "label" = "New"},
      * })
     */
    public function new(Request $request, $lng): Response
    {
        $contractStatusType = new ContractStatusTypes();
        $form = $this->createForm(ContractStatusTypesType::class, $contractStatusType);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contractStatusType);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('contract_status_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('contract_status_types_index',['lng' => $lng,]);
            }

        }else{
            
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('contract_status_types/new.html.twig', [
                'contract_status_type' => $contractStatusType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
            
        }
    }



    /**
     * @Route("/{lng}/config/contract_status_types/edit/{id}", name="contract_status_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Contract Status Types", "route" = "contract_status_types_index"},
      *   { "label" = "Edit"},
      * })
     */
    public function edit(Request $request, ContractStatusTypes $contractStatusType, $lng): Response
    {
        $form = $this->createForm(ContractStatusTypesTypeEdit::class, $contractStatusType);
        $form->handleRequest($request);


        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contract_status_types_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('contract_status_types/edit.html.twig', [
                'contract_status_type' => $contractStatusType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }


    /**
     * @Route("/{lng}/config/contract_status_types/delete/{id}", name="contract_status_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ContractStatusTypes $contractStatusType, $lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contractStatusType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contractStatusType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contract_status_types_index',['lng' => $lng,]);
    }
}
