<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
     /**
     * @Route("/correo", name="correo")
     */
    public function enviarCorreo(\Swift_Mailer $mailer)
    {
        $message = new \Swift_Message();
        $message->setfrom('pruebasconsymfony@gmail.com');
        $message->setTo('programandoqueesgerundio@gmail.com');
        $message->setBody("Pruebas");
        $mailer->send($message);
        
        return $this->render('/home/index.html.twig');
    }

    /**
     * @Route("/homeUser", name="usuarios_home", methods={"GET"})
     */
    public function homeUser()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('home/homeUser.html.twig');
    }
}
