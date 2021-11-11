<?php

namespace App\Controller;

use App\Entity\ExpenseTypes;
use App\Form\ExpenseTypesType;
use App\Form\ExpenseTypesTypeEdit;
use App\Repository\ExpenseTypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;

class ExpenseTypesController extends AbstractController
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
     * @Route("/{lng}/config/expense_types", name="expense_types_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Expense Types"}
      * })
     */
    public function index(ExpenseTypesRepository $expenseTypesRepository,$lng): Response
    {
        return $this->render('expense_types/index.html.twig', [
            'expense_types' => $expenseTypesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/config/expense_types/new", name="expense_types_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Expense Types", "route" = "expense_types_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $expenseType = new ExpenseTypes();
        $form = $this->createForm(ExpenseTypesType::class, $expenseType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($expenseType);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('expense_types_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('expense_types_index',['lng' => $lng,]);
            }
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('expense_types/new.html.twig', [
                'expense_type' => $expenseType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{id}", name="expense_types_show", methods={"GET"})
     */
    public function show(ExpenseTypes $expenseType): Response
    {
        return $this->render('expense_types/show.html.twig', [
            'expense_type' => $expenseType,
        ]);
    }

    /**
     * @Route("/{lng}/config/expense_types/edit/{id}", name="expense_types_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Expense Types", "route" = "expense_types_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, ExpenseTypes $expenseType, $lng): Response
    {
        $form = $this->createForm(ExpenseTypesTypeEdit::class, $expenseType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('expense_types_index',['lng' => $lng]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('expense_types/edit.html.twig', [
                'expense_type' => $expenseType,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{lng}/config/expense_types/delete/{id}", name="expense_types_delete", methods={"DELETE"})
     * 
     */
    public function delete(Request $request, ExpenseTypes $expenseType,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$expenseType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($expenseType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('expense_types_index',['lng' => $lng,]);
    }
}
