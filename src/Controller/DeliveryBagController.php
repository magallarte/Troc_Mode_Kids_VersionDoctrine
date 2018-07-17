<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\DeliveryBag;
use App\Form\DeliveryBagType;
use App\Repository\DeliveryBagRepository;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Entity\ProcessStatus;
use App\Entity\Gender;
use App\Repository\GenderRepository;
use App\Entity\Size;
use App\Repository\SizeRepository;
use App\Entity\Type;
use App\Repository\TypeRepository;
use App\Entity\Season;
use App\Repository\SeasonRepository;
use App\Entity\Color;
use App\Repository\ColorRepository;
use App\Entity\Brand;
use App\Repository\BrandRepository;
use App\Entity\WearStatus;
use App\Entity\SchoolStop;
use App\Repository\WearStatusRepository;
use App\Repository\App\Repository\ProcessStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class DeliveryBagController extends Controller
{
    /**
     * @Route("/delivery/bag/", name="delivery_bag_index", methods="GET")
     */
    public function index(DeliveryBagRepository $deliveryBagRepository): Response
    {
        return $this->render('delivery_bag/index.html.twig', ['delivery_bags' => $deliveryBagRepository->findAll()]);
    }
   
    /**
     * @Route("/delivery/bag/new", name="delivery_bag_new", methods="GET|POST")
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
     * @Route("/delivery/bag/{id}", name="delivery_bag_show", methods="GET", requirements={"id"="\d+"})
     */
    public function show(DeliveryBag $deliveryBag): Response
    {
        return $this->render('delivery_bag/show.html.twig', ['delivery_bag' => $deliveryBag]);
    }

    /**
     * @Route("/delivery/bag/{id}/edit", name="delivery_bag_edit", methods="GET|POST", requirements={"id"="\d+"})
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
     * @Route("/delivery/bag/{id}", name="delivery_bag_delete", methods="DELETE", requirements={"id"="\d+"})
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

    /**
     * @Route("/delivery/bag/showCart", name="delivery_bag_showCart", methods="GET")
     */
    public function showCart(SessionInterface $session): Response
    {
        
        if($session->get('user'))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $member = $entityManager->getRepository(Member::class)->find($session->get('user')->getId());
            $schoolStops=$entityManager->getRepository(SchoolStop::class)->findAll();
            // PREVOIR DE FILTRER LES SCHOOL STOPDS PAR RAPPORT A LA DATE DU JOUR
        
            if($session->get('cart'))
            {
                $articlesList=$session->get('cart')->getDeliveryBagArticleList();
            
            return $this->render('delivery_bag/Cart.html.twig', [
                'deliveryBagList' => $articlesList,
                'member' => $member,
                'schoolStops' => $schoolStops,
                ]);
            }
            else 
            {
                $this->addFlash(
                        'notice',
                        'Votre panier est vide pour le moment !'
                );
            return $this->redirectToRoute('article_selection');
            }
        }
        else
        {
            $this->addFlash(
                        'notice',
                        'Identifiez vous pour accéder à votre panier'
                );
            return $this->redirectToRoute('member_setSession');
        }
        
    }

    /**
     * @Route("/delivery/bag/{id}/addToCart", name="delivery_bag_addToCart", methods="GET|POST", requirements={"id"="\d+"})
     */
    public function addToCart(Request $request, Article $article, SessionInterface $session)
    {
                // $session =new Session();
                // $session->start();
                if(!is_null($session->get('cart')))
                {
                    $cart = $session->get('cart');
                }
                else
                {
                    $cart=new DeliveryBag();
                }
            if ($article->getArticleProcessStatus()->getId()!='8')
            {
                $em = $this->getDoctrine()->getManager();
                $article_selectedStatus= $em->getRepository(ProcessStatus::class)->find(8);//8 = "sélectionné"

                $article->setArticleProcessStatus($article_selectedStatus);
                $em->persist($article);
                $em->flush();

            
                $id=$article->getId();
                $article=$em->getRepository(Article::class)->find($id);
                $cart->addDeliveryBagArticleList($article);
                $session->set('cart', $cart);
                
                $this->addFlash(    
                            'notice',
                            'L\'article a bien été ajouté au panier !'
                    );
            }
            else {
                $this->addFlash(
                            'notice',
                            'L\'article est déjà dans votre panier !'
                    );
            }
        
            $articlesList=$cart->getDeliveryBagArticleList();
            $entityManager = $this->getDoctrine()->getManager();
            $member = $entityManager->getRepository(Member::class)->find($session->get('user')->getId());
            $schoolStops=$entityManager->getRepository(SchoolStop::class)->findAll();
            
        // return $this->redirectToRoute('delivery_bag_showCart');
        return $this->render('delivery_bag/Cart.html.twig', [
                'deliveryBagList' => $articlesList,
                'member' => $member,
                'schoolStops' => $schoolStops,
                ]);
    }

    /**
     * @Route("/delivery/bag/{id}/removeFromCart", name="article_removeFromCart", methods="GET|POST", requirements={"id"="\d+"})
     */
    public function removeFromCart(Request $request, Article $article, SessionInterface $session)
    {
            $em = $this->getDoctrine()->getManager();
            $article_toSellStatus= $em->getRepository(ProcessStatus::class)->find(4);//4 = "à vendre"

            $article->setArticleProcessStatus($article_toSellStatus);
            $em->persist($article);
            $em->flush();

            $session->get('cart');
            $cart=new DeliveryBag();
            foreach ($session->get('cart')->getDeliveryBagArticleList() as $key => $sessionArticle)
            {
                if( $sessionArticle->getId() !== $article->getId())
                {
                    
                    $cart->addDeliveryBagArticleList($sessionArticle);
                }
            }

            $session->set('cart', $cart);
            
            $this->addFlash(
                        'notice',
                        'L\'article a bien été retiré du panier !'
                );

        return $this->redirectToRoute('delivery_bag_showCart');
    }

    /**
    * @Route("/delivery/bag/unsetCart", name="delivery_bag_unsetCart")
    */
    // Ne fonctionne pas !!!! checker erreur INDEX
    public function unsetCart(SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();
        $article_toSellStatus= $em->getRepository(ProcessStatus::class)->find(4);//4 = "à vendre"

        if (!empty($session->get('cart'))) {
            foreach ($session->get('cart')->getDeliveryBagArticleList() as $key => $sessionArticle)
            {
                $sessionArticle->setArticleProcessStatus($article_toSellStatus);
                $em->persist($sessionArticle);
                $em->flush();
            }
            $session->remove('cart');

            $this->addFlash(
                'notice',
                'Votre panier a été vidé !'
            );
        }

        return $this->redirectToRoute('delivery_bag_showCart');
    }

    /**
    * @Route("/delivery/bag/validateCart", name="delivery_bag_validateCart", methods="GET|POST")
    */
    public function validateCart(Request $request, SessionInterface $session)
    {

            $session->get('cart');
            $cart=new DeliveryBag();
            $em = $this->getDoctrine()->getManager();

            $article_PayedStatus= $em->getRepository(ProcessStatus::class)->find(6);//4 = "payé"
            $sessionArticlelist=[];
            foreach ($session->get('cart')->getDeliveryBagArticleList() as $key => $sessionArticle)
            {
                $sessionArticlelist[]=$sessionArticle;
            }

            $batchSize = 20;
            $i = 0;
            $q = $em->createQuery('select a from App\Entity\Article a left join App\Entity\ProcessStatus p where p.id = 8');
            // $q = $em->createQueryBuilder('a')
            //     ->leftjoin('a.processStatus', 'p')
            //     ->addselect('p')
            //     ->andwhere('p.id = :status')
            //     ->setParameter('status', '8' )
            //     ->getQuery()
            //     ->getResult();
            $iterableResult = $q->iterate();
            foreach ($iterableResult as $row) {
                $article = $row[0];
                $article->setArticleProcessStatus($article_PayedStatus);
                if (($i % $batchSize) === 0) {
                    $em->flush(); // Executes all updates.
                    $em->clear(); // Detaches all objects from Doctrine!
                }
                ++$i;
            }
            $em->flush();

            // for ($i = 0; $i <= count($sessionArticle); ++$i) {

            //     $sessionArticlelist[$i]->setArticleProcessStatus($article_PayedStatus);

            //     $em->persist($sessionArticle);

            //     if (($i % $batchSize) === 0) {
            //         $em->flush();
            //         $em->clear(); // Detaches all objects from Doctrine!
            //     }
            // }

            // $em->flush(); // Persist objects that did not make up an entire batch
            // $em->clear();

            // foreach ($session->get('cart')->getDeliveryBagArticleList() as $key => $sessionArticle)
            // {
            //     $cart->addDeliveryBagArticleList($sessionArticle);
            //     $sessionArticle->setArticleProcessStatus($article_PayedStatus);
            //     var_dump($sessionArticle->getId());
            //     $em->persist($sessionArticle);
            //     $em->flush();
            //     $em->clear();
            // }


            if ($request->post('serviceFee') || $request->post('deliveryType') || $request->post('schoolStopId')|| $request->post('walletAmount'))
            {
                $serviceFee= $request->post('serviceFee');
                $cart->setDeliveryBagServiceFee($deliveryBag_serviceFee);


                $schoolStop = $request->post('schoolStopId');
                if($schoolStopId !== null)
                {
                    $delivery = new Delivery();
                    $schoolStop = $em->getRepository(ProcessStatus::class)->find($schoolStopId);
                    $delivery->setDeliverySchoolStop($schoolStop);
                    $delivery->setDeliveryDate($schoolStop->getSchoolStopDate());
                    $deliveryType= $request->post('deliveryType');
                    $delivery->setDeliveryType($deliveryType);
                    $em->persist($delivery);
                    $em->flush();

                }
                else
                {
                    $delivery = new Delivery();
                    $delivery->setDeliverySchoolStop(null);
                    $delivery->setDeliveryDate(null);
                    $deliveryType= $request->post('deliveryType');
                    $delivery->setDeliveryType($deliveryType);
                    $em->persist($delivery);
                    $em->flush();
                }
                $cart->setDeliveryBagDelivery($delivery);

                $walletAmount = $request->post('$walletAmount');
                $cart->setDeliveryBagButtonAmount($walletAmount);

                return new Response ('success');
            }
            
            $buyer=$session->get('user');
            $cart->setDeliveryBagBuyer($buyer);
            $buyer->setMemberButtonWallet($buyer->getMemberButtonWallet()- $walletAmount);
            $em->persist($buyer);
            $em->flush();

            $date = date('m/d/Y h:i:s a', time());
            $cart->setDeliveryBagBuyDate($date);

            $PayedStatus= $em->getRepository(ProcessStatus::class)->find(6);//6 = "payé"
            $cart->setDeliveryBagProcessStatus($PayedStatus);

            $em->persist($cart);
            $em->flush();
            
            $this->addFlash(
                        'notice',
                        'Votre commande a bien été validée ! Vous allez recevoir un email concernant votre livraison.'
                );

        return $this->redirectToRoute('delivery_bag_show', ['id' => $deliveryBag->getId()]);
    }
}
