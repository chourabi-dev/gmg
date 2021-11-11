<?php

namespace App\Controller;

use App\Entity\Currencies;
use App\Form\CurrenciesType;
use App\Form\CurrenciesTypeEdit;
use App\Repository\CurrenciesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;


class CurrenciesController extends AbstractController
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
     * @Route("/{lng}/config/currencies", name="currencies_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Currencies",},
      
      * })
     */
    public function index(CurrenciesRepository $currenciesRepository , $lng): Response
    {
        return $this->render('currencies/index.html.twig', [
            'currencies' => $currenciesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }

    /**
     * @Route("/{lng}/config/currencies/new", name="currencies_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Currencies", "route" = "currencies_index"},
      *   { "label" = "New"},
      
      
      * })
     */
    public function new(Request $request , $lng): Response
    {
        $currency = new Currencies();
        $form = $this->createForm(CurrenciesType::class, $currency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currency);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('currencies_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('currencies_index',['lng' => $lng,]);
            }
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('currencies/new.html.twig', [
                'currency' => $currency,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{id}", name="currencies_show", methods={"GET"})
     * 
     */
    public function show(Currencies $currency): Response
    {
        return $this->render('currencies/show.html.twig', [
            'currency' => $currency,
        ]);
    }

    /**
     * @Route("/{lng}/config/currencies/edit/{id}", name="currencies_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Currencies", "route" = "currencies_index"},
      *   { "label" = "Edit"},
      * })
      
     */
    public function edit(Request $request, Currencies $currency, $lng): Response
    {
        $form = $this->createForm(CurrenciesTypeEdit::class, $currency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('currencies_index',['lng' => $lng]);
        }else{
            $errors = $form->getErrors(true);

            $form->clearErrors(true);

            return $this->render('currencies/edit.html.twig', [
                'currency' => $currency,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]); 
        }

    }

    /**
     * @Route("/{lng}/config/currencies/delete/{id}", name="currencies_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Currencies $currency , $lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$currency->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($currency);
            $entityManager->flush();
        }

        return $this->redirectToRoute('currencies_index',['lng' => $lng]);
    }
}
