<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Member;

class MemberController extends Controller
{
    /**
     * @Route("/member/showForm", name="member_showForm")
     */
    public function showForm()
    {
        return $this->render('member/memberCreate.html.twig');
    }

    /**
     * @Route("/member/create", name="member_create")
     */
    public function create(Request $request)
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $member = new Member();
        $member->setMemberName($request->get('memberName'));
        $member->setMemberSurname($request->get('memberSurname'));
        $member->setMemberAddress1($request->get('memberAddress1'));
        $member->setMemberAddress2($request->get('memberAddress2'));
        $member->setMemberCity($request->get('memberCity'));
        $member->setMemberTel($request->get('memberTel'));
        $member->setMemberEmail($request->get('memberEmail'));
        $member->setMemberPassword($request->get('memberPassword'));
        $member->setMemberButtonWallet('0');
        $member->setMemberSubscription($request->get('memberSubscription'));
        $member->setMemberExpertise($request->get('memberExpertise'));
        $member->setMemberLevel($request->get('memberLevel'));

        // tell Doctrine you want to (eventually) save the Member (no queries yet)
        $entityManager->persist($member);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Bienvenue  ' .$member->getMemberSurname().'! Votre profil a bien été crée.'
        );
        // $message='Bienvenue' .$member->getMemberSurname().'! Votre profil a bien été crée.';

        return $this->render('member/memberCreate.html.twig');
        // return $this->render('member/memberCreate.html.twig', array('message' => $message));

    }
}
