<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class ArticleController extends Controller
{
    /**
     * @Route("/article", name="article_index", methods="GET")
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', ['articles' => $articleRepository->findAll()]);
    }

    /**
     * @Route("/article/create", name="article_create", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article = $form->getData();
            $em = $this->getDoctrine()->getManager();
           
            // On récupère le code du dernier article pour créer le code de l'article en cours de création
            $criteria=array(
                'article_gender'=> $article->getArticleGender(),
                'article_size'=> $article->getArticleSize(),
                // 'article_season'=> $article->getArticleSeason(),
                'article_type'=> $article->getArticleType(),
            );
            $orderBy = array('id'=>'ASC' );

            $lastArticle = $em->getRepository(Article::class)->findOneBy($criteria,$orderBy);
            $lastArticleCode = $lastArticle->getArticleCode();
            
            if(is_null ($lastArticle))
            {
                $article->setArticleCode('XXXXXXXXX0000');
            }
            
            $article->setArticleCode($lastArticle);

            // On affecte au ArticleFabric un tableau avec avec les POST de fabric_name et fabric_percentage
            // $article->setArticleFabric([
            //   'name' =>$request('fabric_name'),
            //   'percentage'=>$request('fabric_percentage')
            //]);
            
            $em->persist($article);
            $em->flush();

            $this->addFlash(
                    'notice',
                    'L\'article a bien été crée !'
            );

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show", methods="GET")
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', ['article' => $article]);
    }

    /**
     * @Route("/article/{id}/edit", name="article_edit", methods="GET|POST")
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_edit', ['id' => $article->getId()]);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_delete", methods="DELETE")
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
