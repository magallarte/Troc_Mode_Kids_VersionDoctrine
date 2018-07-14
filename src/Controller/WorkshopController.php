<?php

namespace App\Controller;

use App\Entity\Workshop;
use App\Entity\Member;
use App\Form\WorkshopType;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface; 


class WorkshopController extends Controller
{
    /**
     * @Route("/workshop/", name="workshop_index", methods="GET")
     */
    public function index(WorkshopRepository $workshopRepository): Response
    {
        return $this->render('workshop/index.html.twig', ['workshops' => $workshopRepository->findAll()]);
    }

    /**
     * @Route("/workshop/new", name="workshop_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $workshop = new Workshop();
        $form = $this->createForm(WorkshopType::class, $workshop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($workshop);
            $em->flush();

            return $this->redirectToRoute('workshop_index');
        }

        return $this->render('workshop/new.html.twig', [
            'workshop' => $workshop,
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/workshop/create", name="workshop_create")
    */
    public function create(Request $request)
    { 
    $workshop = new Workshop();
    $form = $this->createFormBuilder($workshop)
            ->add('workshop_date', DateTimeType::class, array(
                'label'  => 'Date et heure :',
                'widget' => 'choice',
                // pourquoi le format n'est pas pris en compte ?
                'format' => 'dd-MM-yyyy',
                'placeholder' => array(
                        'day' => 'Jour', 'month' => 'Mois', 'year' => 'Année',)
                ))
            ->add('workshop_theme', TextType::class, array('label'  => 'Thème : '))
            ->add('workshop_fee', MoneyType::class, array('label'  => 'Prix : '))
            ->add('workshop_place', TextareaType::class, array('label'  => 'Lieu :'))
            ->add('workshop_picture', TextType::class, array('label'  => 'Image :'))
            ->add('workshop_trainer', EntityType::class, array(
                'label'  => 'Formateur',
                'class' => Member::class,
                'query_builder' => function (\App\Repository\MemberRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->innerJoin('m.member_role', 'r', 'WITH', 'r.role_name = :role')
                        ->addselect('r')
                        ->orderBy('m.member_name', 'ASC')
                        ->setParameter('role', "formateur");
                 },
                'choice_label' => function ($trainers){
                 return $trainers->getMemberSurname().' '.$trainers->getMemberName();
                },
                ))
            ->add('workshop_trainees_list', EntityType::class, array(
                'label'  => 'Personnes inscrites',
                'class' => Member::class,
                'choice_label' => function ($members){
                 return $members->getMemberSurname().' '.$members->getMemberName();
                },
                'multiple'=>true
                ))
            ->add('save', SubmitType::class, array('label' => 'Créez un atelier'))
            ->getForm();
        
            $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid())
                {
                    // $form->getData() holds the submitted values
                    // but, the original `$task` variable has also been updated
                    $workshop = $form->getData();

                    // ... perform some action, such as saving the task to the database
                    // for example, if Task is a Doctrine entity, save it!
                    $entityManager = $this->getDoctrine()->getManager();
                     
                    $entityManager->persist($workshop);
                    $entityManager->flush();

                    return $this->render('home.html.twig');
                }
        
        return $this->render('workshop/workshopCreate.html.twig', array(
                    'form' => $form->createView(),
                ));
    }

    /**
     * @Route("/workshop/book/{id}", name="workshop_book", methods="GET")
     */
    public function book(Workshop $workshop, SessionInterface $session): Response
    {
         if(!is_null($session->get('user')))
            {
                return $this->render('workshop/book.html.twig', [
                    'workshop' => $workshop,
                    'user'=>$session->get('user')
                    ]);
            }
        else
            {
            $this->addFlash(
                    'notice',
                    'Pour vous inscrire, merci de vous identifier !'
            );
            return $this->redirectToRoute('member_setSession');
            }
 
    }

    /**
     * @Route("/workshop/pay/{id}", name="workshop_pay", methods="GET")
     */
    public function pay(Workshop $workshop, SessionInterface $session): Response
    {
         if(!is_null($session->get('user')))
            {
            $workshop->addWorkshopTraineesList($session->get('user'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($workshop);
            $em->flush();

            $this->addFlash(
                    'notice',
                    'Vous avez bien été inscrit à l\'atelier !'
            );

            return $this->redirectToRoute('home_show');

            }
        else
            {
            $this->addFlash(
                    'notice',
                    'Pour réserver, merci de vous identifier !'
            );
            return $this->redirectToRoute('member_setSession');
            }

    }

    /**
     * @Route("/workshop/{id}", name="workshop_show", methods="GET")
     */
    public function show(Workshop $workshop): Response
    {
        return $this->render('workshop/show.html.twig', ['workshop' => $workshop]);
    }

    /**
     * @Route("/workshop/{id}/edit", name="workshop_edit", methods="GET|POST")
     */
    public function edit(Request $request, Workshop $workshop): Response
    {
        $form = $this->createForm(WorkshopType::class, $workshop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('workshop_edit', ['id' => $workshop->getId()]);
        }

        return $this->render('workshop/edit.html.twig', [
            'workshop' => $workshop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/workshop/{id}", name="workshop_delete", methods="DELETE")
     */
    public function delete(Request $request, Workshop $workshop): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workshop->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($workshop);
            $em->flush();
        }

        return $this->redirectToRoute('workshop_index');
    }
}
