<?php

namespace App\Controller;

use App\Entity\Cartas;
use App\Form\CartasType;
use App\Repository\CartasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cartas")
 */
class CartasController extends AbstractController
{
    /**
     * @Route("/", name="cartas_index", methods={"GET"})
     */
    public function index(CartasRepository $cartasRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('cartas/index.html.twig', [
            'cartas' => $cartasRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cartas_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $carta = new Cartas();
        $form = $this->createForm(CartasType::class, $carta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $carta->setFoto($form->get('foto')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($carta);
            $entityManager->flush();
            self::renamePic($carta, $form->get('foto')->getData());
            

            return $this->redirectToRoute('cartas_index');
        }

        return $this->render('cartas/new.html.twig', [
            'carta' => $carta,
            'form' => $form->createView(),
        ]);
    }

    private function renamePic($carta, $imagen){

        $nombreImg = $carta->getId().'.'.$imagen->guessExtension();

        $imagen->move('img/cartas', $nombreImg);
        $carta->setFoto($nombreImg);
        $entityManager =$this->getDoctrine()->getManager();
        $entityManager->flush();
    }

    /**
     * @Route("/{id}", name="cartas_show", methods={"GET"})
     */
    public function show(Cartas $carta): Response
    {
        return $this->render('cartas/show.html.twig', [
            'carta' => $carta,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cartas_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cartas $carta): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(CartasType::class, $carta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cartas_index');
        }

        return $this->render('cartas/edit.html.twig', [
            'carta' => $carta,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cartas_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cartas $carta): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carta->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($carta);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cartas_index');
    }
    /**
     * @Route("/busqueda",options={"expose"=true}, name="busqueda" )
     */
    public function buscador(Request $request){
  $resp ="";
        if($request->isXmlHttpRequest()){
            $entityManager = $this->getDoctrine()->getManager();
            $datos = $request->get('datos');
            $cartas = $entityManager->getRepository(Cartas::class)->busquedaAjax($datos); 
          
            if(!$cartas){
                $resp = "No hay cartas";
            }else{
                $resp=[];
                $campo=[];

                foreach ($cartas as $clave => $resultados){
                    $campo = [
                        'id' => $resultados->getId(),
                        'nombre' => $resultados->getNombre(),
                        'ataque' => $resultados->getAtaque(),
                        'defensa' => $resultados->getDefensa(),
                        'descripcion' => $resultados->getDescripcion(),
                        'foto' => $resultados->getFoto()
                    ];
                    $resp[$clave] = $campo;
                }
            }
           
        } return new JsonResponse(['cartas' => $resp]);
    }
}
