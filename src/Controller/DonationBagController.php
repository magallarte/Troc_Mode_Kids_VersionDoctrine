<?php

namespace App\Controller;

use App\Entity\DonationBag;
use App\Form\DonationBagType;
use App\Repository\DonationBagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/donation/bag")
 */
class DonationBagController extends Controller
{
    /**
     * @Route("/", name="donation_bag_index", methods="GET")
     */
    public function index(DonationBagRepository $donationBagRepository): Response
    {
        return $this->render('donation_bag/index.html.twig', ['donation_bags' => $donationBagRepository->findAll()]);
    }

    /**
     * @Route("/new", name="donation_bag_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $donationBag = new DonationBag();
        $form = $this->createForm(DonationBagType::class, $donationBag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($donationBag);
            $em->flush();

            return $this->redirectToRoute('donation_bag_index');
        }

        return $this->render('donation_bag/new.html.twig', [
            'donation_bag' => $donationBag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="donation_bag_show", methods="GET")
     */
    public function show(DonationBag $donationBag): Response
    {
        return $this->render('donation_bag/show.html.twig', ['donation_bag' => $donationBag]);
    }

    /**
     * @Route("/{id}/edit", name="donation_bag_edit", methods="GET|POST")
     */
    public function edit(Request $request, DonationBag $donationBag): Response
    {
        $form = $this->createForm(DonationBagType::class, $donationBag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('donation_bag_edit', ['id' => $donationBag->getId()]);
        }

        return $this->render('donation_bag/edit.html.twig', [
            'donation_bag' => $donationBag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="donation_bag_delete", methods="DELETE")
     */
    public function delete(Request $request, DonationBag $donationBag): Response
    {
        if ($this->isCsrfTokenValid('delete'.$donationBag->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($donationBag);
            $em->flush();
        }

        return $this->redirectToRoute('donation_bag_index');
    }
}
