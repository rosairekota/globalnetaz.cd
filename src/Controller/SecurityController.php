<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\UserRegistrationType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
    	 //$this->addFlash('success',' Connectez-vous maintenant!');
         $lastusername=$authenticationUtils->getLastUsername();
         
        return $this->render('security/login.html.twig',[
            'last_username' =>$lastusername,
            'error' =>$authenticationUtils->getLastAuthenticationError()
        ]);
    }
     
    /**
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
    		 $user=new User();
    		 $form=$this->createForm(UserRegistrationType::class, $user);
    		 $form->handleRequest($request);
    		 if ($form->isSubmitted() && $form->isValid()  ) {
                 $password_hashing=$encoder->encodePassword($user,$user->getPassword());
                 $user->setPassword($password_hashing);
                 $em->persist($user);
                 $em->flush();
                 return $this->redirectToRoute('security_login');
    		 }
    	     
    	    return $this->render('security/create.html.twig',[
    	        'formUser' =>$form->createView(),
    	    ]);
    }
}
