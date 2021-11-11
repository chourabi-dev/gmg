<?php

namespace App\Controller;

use App\Entity\AllowanceTypes;
use App\Form\AllowanceTypesType;
use App\Repository\AllowanceTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Form\AllowanceTypesTypeEdit;

class AllowanceTypesController extends AbstractController
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
      * @Route("/{lng}/config/allowance_types", defaults={"lng"="EN"},  name="allowance_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Allowance Types",},
      * })
     */
    public function index(AllowanceTypesRepository $allowanceTypesRepository,$lng): Response
    {
        return $this->render('allowance_types/index.html.twig', [
            'allowance_types' => $allowanceTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }


    /**
     * @Route("/{lng}/config/allowance_types/new", name="allowance_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Allowance Types", "route" = "allowance_types_index"},
      *   { "label" = "New"},
      
      
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $allowanceType = new AllowanceTypes();
        $form = $this->createForm(AllowanceTypesType::class, $allowanceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($allowanceType);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('allowance_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('allowance_types_index',['lng' => $lng,]);
            }
            

        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('allowance_types/new.html.twig', [
                'allowance_type' => $allowanceType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);

        }

        
    }




    /**
     * @Route("/{lng}/config/allowance_types/edit/{id}", name="allowance_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Allowance Types", "route" = "allowance_types_index"},
      *   { "label" = "Edit"},
      
      
      * })
     */
    public function edit(Request $request, AllowanceTypes $allowanceType, $lng): Response
    {
        $form = $this->createForm(AllowanceTypesTypeEdit::class, $allowanceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('allowance_types_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);
            
            return $this->render('allowance_types/edit.html.twig', [
            'allowance_type' => $allowanceType,
            'form' => $form->createView(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            'errors' => $errors
        ]);
        }

        
    }

    /**
     * @Route("{lng}/config/allowance_types/delete/{id}/", name="allowance_types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AllowanceTypes $allowanceType,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$allowanceType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($allowanceType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('allowance_types_index',['lng' => $lng,]);
    }
}
