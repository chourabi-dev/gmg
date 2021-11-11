<?php

namespace App\Controller;

use App\Entity\Holidays;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HolidaysController extends AbstractController
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
     * @Route("/{lng}/settings/holiday/delete/{id}", name="holiday_delete_route", methods={"DELETE"})
     */
    public function delete(Request $request, Holidays $holiday, $lng, $id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$holiday->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($holiday);
            $entityManager->flush();
        }

        return $this->redirectToRoute('setting_route',['lng' => $lng]);
    }
}
