<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Form\DeliveryType;
use App\Repository\DeliveryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/delivery") // A MODIFIER et A RAJOUTER DANS CHAQUE FONCTION
 */
class DeliveryController extends Controller
{
    /**
     * @Route("/", name="delivery_index", methods="GET")
     */
    public function index(DeliveryRepository $deliveryRepository): Response
    {
        return $this->render('delivery/index.html.twig', ['deliveries' => $deliveryRepository->findAll()]);
    }

    /**
     * @Route("/new", name="delivery_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $delivery = new Delivery();
        $form = $this->createForm(DeliveryType::class, $delivery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($delivery);
            $em->flush();

            return $this->redirectToRoute('delivery_index');
        }

        return $this->render('delivery/new.html.twig', [
            'delivery' => $delivery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delivery_show", methods="GET")
     */
    public function show(Delivery $delivery): Response
    {
        return $this->render('delivery/show.html.twig', ['delivery' => $delivery]);
    }

    /**
     * @Route("/{id}/edit", name="delivery_edit", methods="GET|POST")
     */
    public function edit(Request $request, Delivery $delivery): Response
    {
        $form = $this->createForm(DeliveryType::class, $delivery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('delivery_edit', ['id' => $delivery->getId()]);
        }

        return $this->render('delivery/edit.html.twig', [
            'delivery' => $delivery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delivery_delete", methods="DELETE")
     */
    public function delete(Request $request, Delivery $delivery): Response
    {
        if ($this->isCsrfTokenValid('delete'.$delivery->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($delivery);
            $em->flush();
        }

        return $this->redirectToRoute('delivery_index');
    }
}
