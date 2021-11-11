<?php

namespace App\Controller;

use App\Entity\Allowances;
use App\Form\AllowancesType;
use App\Repository\AllowancesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AllowancesController extends AbstractController
{








    /**
     * @Route("/{lng}/delete/allow/{id}", name="allowances_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Allowances $allowance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$allowance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($allowance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('allowances_index',['lng' => $lng,]);
    }
}
