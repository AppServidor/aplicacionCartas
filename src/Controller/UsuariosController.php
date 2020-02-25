<?php

namespace App\Controller;

use App\Entity\Usuarios;

use App\Form\RegistrationFormType;
use App\Repository\UsuariosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/usuarios")
 */
class UsuariosController extends AbstractController
{
    /**
     * @Route("/", name="usuarios_index", methods={"GET"})
     */
    public function index(UsuariosRepository $usuariosRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('usuarios/index.html.twig', [
            'usuarios' => $usuariosRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="usuarios_show", methods={"GET"})
     */
    public function show(Usuarios $usuario): Response
    {
        return $this->render('usuarios/show.html.twig', [
            'usuario' => $usuario,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="usuarios_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Usuarios $usuario): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if(!is_null($form->get('foto')->getData()||!is_null($form->get('plainPassword')->getData()))){
                if(!is_null($form->get('foto')->getData())){
                    self::renamePic($form->get('foto')->getData(),$usuario);
                }
                if(!is_null($form->get('plainPassword')->getData())){
                    $usuario->setPassword($form->get('plainPassword')->getData());
                    $this->getDoctrine()->getManager()->flush();
                }                
            }else{
                $this->getDoctrine()->getManager()->flush();
            }
            

            return $this->redirectToRoute('usuarios_index');
        }

        return $this->render('usuarios/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="usuarios_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Usuarios $usuario): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usuario->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($usuario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('usuarios_index');
    }
    private function renamePic($imagen, $user){

        $nombreImg = $user->getId().'.'.$imagen->guessExtension();
        $imagen->move('img/usuarios',$nombreImg);

        $entityManager=$this->getDoctrine()->getManager();
        $user->setFoto($nombreImg);
        $entityManager->flush();

    }
}
