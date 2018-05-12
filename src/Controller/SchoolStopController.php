<?php

namespace App\Controller;

use App\Entity\SchoolStop;
use App\Form\SchoolStopType;
use App\Repository\SchoolStopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/school/stop")
 */
class SchoolStopController extends Controller
{
    /**
     * @Route("/", name="school_stop_index", methods="GET")
     */
    public function index(SchoolStopRepository $schoolStopRepository): Response
    {
        return $this->render('school_stop/index.html.twig', ['school_stops' => $schoolStopRepository->findAll()]);
    }

    /**
     * @Route("/new", name="school_stop_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $schoolStop = new SchoolStop();
        $form = $this->createForm(SchoolStopType::class, $schoolStop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($schoolStop);
            $em->flush();

            return $this->redirectToRoute('school_stop_index');
        }

        return $this->render('school_stop/new.html.twig', [
            'school_stop' => $schoolStop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="school_stop_show", methods="GET")
     */
    public function show(SchoolStop $schoolStop): Response
    {
        return $this->render('school_stop/show.html.twig', ['school_stop' => $schoolStop]);
    }

    /**
     * @Route("/{id}/edit", name="school_stop_edit", methods="GET|POST")
     */
    public function edit(Request $request, SchoolStop $schoolStop): Response
    {
        $form = $this->createForm(SchoolStopType::class, $schoolStop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('school_stop_edit', ['id' => $schoolStop->getId()]);
        }

        return $this->render('school_stop/edit.html.twig', [
            'school_stop' => $schoolStop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="school_stop_delete", methods="DELETE")
     */
    public function delete(Request $request, SchoolStop $schoolStop): Response
    {
        if ($this->isCsrfTokenValid('delete'.$schoolStop->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($schoolStop);
            $em->flush();
        }

        return $this->redirectToRoute('school_stop_index');
    }
}
