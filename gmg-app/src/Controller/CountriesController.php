<?php

namespace App\Controller;

use App\Entity\Countries;
use App\Form\CountriesType;
use App\Repository\CountriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AndreaSprega\Bundle\BreadcrumbBundle\Annotation\Breadcrumb;
use App\Form\CountriesTypeEdit;

class CountriesController extends AbstractController
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
     * @Route("/{lng}/config/countries", name="countries_index", methods={"GET"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Countries",},
      
      * })
     */
    public function index(CountriesRepository $countriesRepository, $lng): Response
    {
        return $this->render('countries/index.html.twig', [
            'countries' => $countriesRepository->findAll(),
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
        ]);
    }


    /**
     * @Route("/{lng}/config/countries/new", name="countries_new", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Countries", "route" = "countries_index"},
      *   { "label" = "New"},
      * })
     */
    public function new(Request $request, $lng): Response
    {
        $country = new Countries();
        $form = $this->createForm(CountriesType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($country);
            $entityManager->flush();
            $nextAction = $form->get('saveAndAdd')->isClicked()
            ? 'task_new'
            : 'task_success';

            if ($nextAction == 'task_new') {
                 return $this->redirectToRoute('countries_new',['lng' => $lng,]);
            } else {
                return $this->redirectToRoute('countries_index',['lng' => $lng,]);
            }
        }else{
            $errors = $form->getErrors(true);
            $form->clearErrors(true);

            return $this->render('countries/new.html.twig', [
                'country' => $country,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);

        }


    }


    /**
     * @Route("/{lng}/config/countries/edit/{id}/", name="countries_edit", methods={"GET","POST"})
      * @Breadcrumb({
      *   { "label" = "Home", "route" = "index_route" },
      *   { "label" = "Config", "route" = "config_route" },
      *   { "label" = "Countries", "route" = "countries_index"},
      *   { "label" = "Edit"},
      
      
      * })
     */
    public function edit(Request $request, Countries $country,$lng): Response
    {
        $form = $this->createForm(CountriesTypeEdit::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('countries_index',['lng' => $lng,]);
        }else{
            $errors = $form->getErrors(true);
            $form->clearErrors(true);

            return $this->render('countries/edit.html.twig', [
                'country' => $country,
                'form' => $form->createView(),
                'lng' => $this->lanChooser($lng),
                'lngbase' => $lng,
                'errors' => $errors
            ]);
        }


    }

    /**
     * @Route("/{lng}/config/countries/delete/{id}/", name="countries_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Countries $country,$lng): Response
    {
        if ($this->isCsrfTokenValid('delete'.$country->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($country);
            $entityManager->flush();
        }

        return $this->redirectToRoute('countries_index',['lng' => $lng,]);
    }
}
