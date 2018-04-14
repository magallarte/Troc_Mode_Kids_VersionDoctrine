<?php

namespace App\Controller;

use App\Entity\Fabric;
use App\Form\FabricType;
use App\Repository\FabricRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fabric")
 */
class FabricController extends Controller
{
    /**
     * @Route("/", name="fabric_index", methods="GET")
     */
    public function index(FabricRepository $fabricRepository): Response
    {
        return $this->render('fabric/index.html.twig', ['fabrics' => $fabricRepository->findAll()]);
    }

    /**
     * @Route("/new", name="fabric_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $fabric = new Fabric();
        $form = $this->createForm(FabricType::class, $fabric);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fabric);
            $em->flush();

            return $this->redirectToRoute('fabric_index');
        }

        return $this->render('fabric/new.html.twig', [
            'fabric' => $fabric,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fabric_show", methods="GET")
     */
    public function show(Fabric $fabric): Response
    {
        return $this->render('fabric/show.html.twig', ['fabric' => $fabric]);
    }

    /**
     * @Route("/{id}/edit", name="fabric_edit", methods="GET|POST")
     */
    public function edit(Request $request, Fabric $fabric): Response
    {
        $form = $this->createForm(FabricType::class, $fabric);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fabric_edit', ['id' => $fabric->getId()]);
        }

        return $this->render('fabric/edit.html.twig', [
            'fabric' => $fabric,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fabric_delete", methods="DELETE")
     */
    public function delete(Request $request, Fabric $fabric): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fabric->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fabric);
            $em->flush();
        }

        return $this->redirectToRoute('fabric_index');
    }
}
