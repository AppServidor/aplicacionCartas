<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Form\RegistrationFormType;
use App\Form\AdminType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registroUser", name="registro_user")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        
        $user = new Usuarios();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setFoto($form->get('foto')->getData());
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            self::renamePic($form->get('foto')->getData(), $user);
            // do anything else you need here, like send an email

            return $this->redirectToRoute('usuarios_home');
        }

        return $this->render('registration/registroUsuarios.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/registroAdmin", name="registro_admin")
     */
    public function registerAdmin(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $user = new Usuarios();
        $form = $this->createForm(RegistrationFormType::class, $user);
       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setRoles(array('ROLE_ADMIN'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('cartas_index');
        }
        return $this->render('registration/registroAdmin.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    private function renamePic($imagen, $user){

        $nombreImg = $user->getId().'.'.$imagen->guessExtension();
        $imagen->move('img/usuarios',$nombreImg);

        $entityManager=$this->getDoctrine()->getManager();
        $user->setFoto($nombreImg);
        $entityManager->flush();

    }
}
