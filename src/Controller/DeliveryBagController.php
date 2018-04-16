<?php

namespace App\Controller;

use App\Entity\DeliveryBag;
use App\Form\DeliveryBagType;
use App\Repository\DeliveryBagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/delivery/bag")
 */
class DeliveryBagController extends Controller
{
    /**
     * @Route("/", name="delivery_bag_index", methods="GET")
     */
    public function index(DeliveryBagRepository $deliveryBagRepository): Response
    {
        return $this->render('delivery_bag/index.html.twig', ['delivery_bags' => $deliveryBagRepository->findAll()]);
    }

    /**
     * @Route("/new", name="delivery_bag_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $deliveryBag = new DeliveryBag();
        $form = $this->createForm(DeliveryBagType::class, $deliveryBag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($deliveryBag);
            $em->flush();

            return $this->redirectToRoute('delivery_bag_index');
        }

        return $this->render('delivery_bag/new.html.twig', [
            'delivery_bag' => $deliveryBag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delivery_bag_show", methods="GET")
     */
    public function show(DeliveryBag $deliveryBag): Response
    {
        return $this->render('delivery_bag/show.html.twig', ['delivery_bag' => $deliveryBag]);
    }

    /**
     * @Route("/{id}/edit", name="delivery_bag_edit", methods="GET|POST")
     */
    public function edit(Request $request, DeliveryBag $deliveryBag): Response
    {
        $form = $this->createForm(DeliveryBagType::class, $deliveryBag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('delivery_bag_edit', ['id' => $deliveryBag->getId()]);
        }

        return $this->render('delivery_bag/edit.html.twig', [
            'delivery_bag' => $deliveryBag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delivery_bag_delete", methods="DELETE")
     */
    public function delete(Request $request, DeliveryBag $deliveryBag): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deliveryBag->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($deliveryBag);
            $em->flush();
        }

        return $this->redirectToRoute('delivery_bag_index');
    }
}
