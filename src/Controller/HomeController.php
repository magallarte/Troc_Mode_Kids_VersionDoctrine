<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Kid;
use App\Entity\School;
use App\Entity\Member;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface; 

class HomeController extends Controller
{

    /**
    * @Route("/", name="home_show")
    */
    public function show(Request $request,SessionInterface $session)
    {
        return $this->render('home.html.twig', array(
            'sessionName' => $session->get('name'),
            'sessionSurname' => $session->get('surname')
        ));
    }
}
