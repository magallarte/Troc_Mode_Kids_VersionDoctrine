<?php

namespace App\Controller;

use App\Entity\DeliveryBag;
use App\Form\DeliveryBagType;
use App\Repository\DeliveryBagRepository;
use App\Entity\Article;
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
use App\Repository\WearStatusRepository;
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
        $totalEuros= 0;
        foreach ($session->get('cart')->getDeliveryBagArticleList() as $key => $article) {
            $totalEuros=$totalEuros+$article->getArticleEurosValue();
        }
        $totalButtons= 0;
        foreach ($session->get('cart')->getDeliveryBagArticleList() as $key => $article) {
            $totalButtons=$totalButtons+$article->getArticleButtonValue();
        }
        $totalServiceFee= 0;
        foreach ($session->get('cart')->getDeliveryBagArticleList() as $key => $article) {
            $totalServiceFee=$totalServiceFee+1;
        }
        return $this->render('delivery_bag/Cart.html.twig', [
            'deliveryBag' => $session->get('cart'),
            'totalEuros' => $totalEuros,
            'totalButtons' => $totalButtons,
            'totalServiceFee' => $totalServiceFee
            ]);
    }

    /**
     * @Route("/delivery/bag/{id}/addToCart", name="delivery_bag_addToCart", methods="GET|POST", requirements={"id"="\d+"})
     */
    public function addToCart(Request $request, Article $article, SessionInterface $session)
    {
            $em = $this->getDoctrine()->getManager();
            $article_selectedStatus= $em->getRepository(ProcessStatus::class)->find(8);

            $article->setArticleProcessStatus($article_selectedStatus);
            $em->persist($article);
            $em->flush();
            
            $session =new Session();
            $session->start();
            if(!is_null($session->get('cart')))
            {
                $cart = $session->get('cart');
            }
            else
            {
                $cart=new DeliveryBag();
            }
           
            $id=$article->getId();
            $article=$em->getRepository(Article::class)->find($id);
            $cart->addDeliveryBagArticleList($article);
            $session->set('cart', $cart);
            
            $this->addFlash(
                        'notice',
                        'L\'article a bien été ajouté au panier !'
                );
        // }
        return $this->redirectToRoute('delivery_bag_showCart');
    }

    /**
     * @Route("/delivery/bag/{id}/removeFromCart", name="article_removeFromCart", methods="GET|POST", requirements={"id"="\d+"})
     */
    public function removeFromCart(Request $request, Article $article, SessionInterface $session)
    {
            $em = $this->getDoctrine()->getManager();
            $article_toSellStatus= $em->getRepository(ProcessStatus::class)->find(4);

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
        // }
        return $this->redirectToRoute('article_selection');
    }

    /**
    * @Route("/delivery/bag/unsetCart", name="member_unsetCart")
    */
    // Ne fonctionne pas !!!! checker erreur INDEX
    public function unsetCart(SessionInterface $session)
    {
        $em = $this->getDoctrine()->getManager();
        $article_toSellStatus= $em->getRepository(ProcessStatus::class)->find(4);

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
        return $this->render('home.html.twig');
    }
}
