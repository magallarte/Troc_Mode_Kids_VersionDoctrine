<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Kid;
use App\Entity\School;

class KidController extends Controller
{
    /**
     * @Route("/kid/showForm", name="kid_showForm")
     */
    public function showForm()
    {
        $schools=$this->getDoctrine()->getRepository(School::class)->findAll();
        return $this->render('kid/kidCreate.html.twig', array(
            'schools'=>$schools
        ));
    }

    /**
     * @Route("/kid/create", name="kid_create")
     */
    public function create(Request $request)
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $member = new Kid();
        $member->setKidName($request->get('kidName'));
        $member->setKidSurname($request->get('kidSurname'));
        $member->setKidBirthday($request->get('kidBirthday'));
        $member->setKidSchoolId($request->get('kidSchoolId'));

        // tell Doctrine you want to (eventually) save the Member (no queries yet)
        $entityManager->persist($member);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Le profil de  ' .$kid->getKidSurname().' a bien été crée.'
        );
       

        return $this->render('kid/kidCreate.html.twig');
    }
}
