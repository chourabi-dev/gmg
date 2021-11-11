<?php

namespace App\Controller;

use App\Entity\PaymentModes;
use App\Form\PaymentModesType;
use App\Repository\PaymentModesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Form\PaymentModesTypeEdit;

class PaymentModesController extends AbstractController
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
     * @Route("/{lng}/config/payment_modes", name="payment_modes_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Payment Modes"}
      * })
     */
    public function index(PaymentModesRepository $paymentModesRepository, $lng): Response
    {
        return $this->render('payment_modes/index.html.twig', [
            'payment_modes' => $paymentModesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }


    /**
     * @Route("/{lng}/config/payment_modes/new", name="payment_modes_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Payment Modes" , "route" = "payment_modes_index" },
      *   { "label" = "New" }
      * })
     */
    public function new(Request $request,$lng): Response
    {
        $paymentMode = new PaymentModes();
        $form = $this->createForm(PaymentModesType::class, $paymentMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($paymentMode);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('payment_modes_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('payment_modes_index',['lng' => $lng,]);
            }
        }else{
            $errors = $form->getErrors(true);
            $form->clearErrors(true);

            return $this->render('payment_modes/new.html.twig', [
                'payment_mode' => $paymentMode,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{id}", name="payment_modes_show", methods={"GET"})
     */
    
    public function show(PaymentModes $paymentMode): Response
    {
        return $this->render('payment_modes/show.html.twig', [
            'payment_mode' => $paymentMode,
        ]);
    }

    
    /**
     * @Route("/{lng}/config/payment_modes/edit/{id}", name="payment_modes_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Payment Modes" , "route" = "payment_modes_index" },
      *   { "label" = "Edit" }
      * })
     */
    public function edit(Request $request, PaymentModes $paymentMode, $lng): Response
    {
        $form = $this->createForm(PaymentModesTypeEdit::class, $paymentMode);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('payment_modes_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('payment_modes/edit.html.twig', [
                'payment_mode' => $paymentMode,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);
        }
    }

    /**
     * @Route("/{lng}/config/payment_modes/delete/{id}", name="payment_modes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PaymentModes $paymentMode, $lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paymentMode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paymentMode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('payment_modes_index',['lng' => $lng,]);
    }
}
