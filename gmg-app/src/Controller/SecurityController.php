<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{


    private $encoder;
 
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


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
     * @Route("/{lng}/login", defaults={"lng"="EN"} , name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils,$lng): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('index_route');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
             'error' => $error,
             'lng' => $this->lanChooser($lng),
             'lngbase' => $lng,
        ]);
    }

    
    /**
     * @Route("/{lng}/signup", defaults={"lng"="EN"} , name="app_siginup", methods={"GET","POST"})
     */
    public function new(Request $request,$lng): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $user->setPassword($this->encoder->encodePassword($user,$user->getPassword()));


            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }
        $error="";
        

        return $this->render('security/signup.html.twig', [
            'lng' => $this->lanChooser($lng),
            'lngbase' => $lng,
            'form' => $form->createView(),
            'error' => $error
        ]);
    }


    /**
     * @Route("/{lng}/logout", defaults={"lng"="EN"} , name="app_logout")
     */
    public function logout()
    {
      
    }
}
