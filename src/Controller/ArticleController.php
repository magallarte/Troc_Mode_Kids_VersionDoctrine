<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
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
     * @Route("/article/selection", name="article_selection", methods="GET|POST")
     */
    public function selection(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $genders= $em->getRepository(Gender::class)->findAll();
        $sizes= $em->getRepository(Size::class)->findAll();
        $types= $em->getRepository(Type::class)->findAll();
        $seasons= $em->getRepository(Season::class)->findAll();
        $colors= $em->getRepository(Color::class)->findAll();
        $brands= $em->getRepository(Brand::class)->findAll();
        $wearStatuss= $em->getRepository(WearStatus::class)->findAll();
        $articles= $em->getRepository(Article::class)->findAll();

        if ( ($request->get('selectionGender')) || ($request->get('selectionSize')) || ($request->get('selectionType')) || ($request->get('selectionSeason')) || ($request->get('selectionColor')) || ($request->get('selectionBrand')) && ($request->get('selectionWearStatus')) )
        {
            //Option1: POST transformés en tableaux d'objets
            // if($request->get('selectionGender'))
            // {
            //     $selection['Gender']=[];
            //     foreach ($request->get('selectionGender') as $key => $genderId) {
            //         $selection['Gender'][]=$em->getRepository(Gender::class)->find($genderId);
            //     }
            // }
            // else
            // {
            //         $selection['Gender'][]=$em->getRepository(Gender::class)->findAll();
            // }

            // if($request->get('selectionSize'))
            // {
            //     $selection['Size']=[];
            //     foreach ($request->get('selectionSize') as $key => $sizeId)
            //     {
            //         $selection['Size'][]=$em->getRepository(Size::class)->find($sizeId);
            //     }
            // }
            // else
            // {
            //     $selection['Size'][]=$em->getRepository(Size::class)->findAll();
            // }

            //  if($request->get('selectionType'))
            // {
            //     $selection['Type']=[];
            //     foreach ($request->get('selectionType') as $key => $typeId)
            //     {
            //         $selection['Type'][]=$em->getRepository(Type::class)->find($typeId);
            //     }
            // }
            // else
            // {
            //         $selection['Type'][]=$em->getRepository(Type::class)->findAll();
            // }

            //  if($request->get('selectionColor'))
            // {
            //     $selection['Color']=[];
            //     foreach ($request->get('selectionColor') as $key => $colorId)
            //     {
            //         $selection['Color'][]=$em->getRepository(Color::class)->find($colorId);
            //     }
            // }
            // else
            // {
            //     $selection['Color'][]=$em->getRepository(Color::class)->findAll();
            // }

            //  if($request->get('selectionSeason'))
            // {
            //     $selection['Season']=[];
            //     foreach ($request->get('selectionSeason') as $key => $seasonId)
            //     {
            //         $selection['Season'][]=$em->getRepository(Season::class)->find($seasonId);
            //     }
            // }
            // else
            // {
            //     $selection['Season'][]=$em->getRepository(Season::class)->findAll();
            // }

            //  if($request->get('selectionBrand'))
            // {
            //     $selection['Brand']=[];
            //     foreach ($request->get('selectionBrand') as $key => $brandId)
            //     {
            //         $selection['Brand'][]=$em->getRepository(Brand::class)->find($brandId);
            //     }
            // }
            // else
            // {
            //     $selection['Brand'][]=$em->getRepository(Brand::class)->findAll();
            // }

            //  if($request->get('selectionWearStatus'))
            // {
            //     $selection['WearStatus']=[];
            //     foreach ($request->get('selectionWearStatus') as $key => $wearStatusId)
            //     {
            //         $selection['WearStatus'][]=$em->getRepository(WearStatus::class)->find($wearStatusId);
            //     }
            // }
            // else
            // {
            //     $selection['WearStatus'][]=$em->getRepository(WearStatus::class)->findAll();
            // }

            //Option2: POST transformés en tableaux d'integers
            if($request->get('selectionGender'))
            {
                foreach ($request->get('selectionGender') as $key => $gender) {
                    $selection['Gender'][]=$gender;
                }
            }
            else
            {
                foreach ($genders as $key => $gender) {
                    $selection['Gender'][]=$gender->getId();
                }
            }
            
            if($request->get('selectionSize'))
            {
                foreach ($request->get('selectionSize') as $key => $size) {
                    $selection['Size'][]=$size;
                }
            }
            else
            {
                foreach ($sizes as $key => $size) {
                    $selection['Size'][]=$size->getId();
                }
            }
            
            if($request->get('selectionType'))
            {
                foreach ($request->get('selectionType') as $key => $type) {
                    $selection['Type'][]=$type;
                }
            }
            else
            {
                foreach ($types as $key => $type) {
                    $selection['Type'][]=$type->getId();
                }
            }
            
            if($request->get('selectionSeason'))
            {
                foreach ($request->get('selectionSeason') as $key => $season) {
                    $selection['Season'][]=$season;
                }
            }
            else
            {
                foreach ($seasons as $key => $season) {
                    $selection['Season'][]=$season->getId();
                }
            }

            if($request->get('selectionColor'))
            {
                foreach ($request->get('selectionColor') as $key => $color) {
                    $selection['Color'][]=$color;
                }
            }
            else
            {
                foreach ($colors as $key => $color) {
                    $selection['Color'][]=$color->getId();
                }
            }
            
            if($request->get('selectionBrand'))
            {
                foreach ($request->get('selectionBrand') as $key => $brand) {
                    $selection['Brand'][]=$brand;
                }
            }
            else
            {
                foreach ($brands as $key => $brand) {
                    $selection['Brand'][]=$brand->getId();
                }
            }
            
            if($request->get('selectionWearStatus'))
            {
                foreach ($request->get('selectionWearStatus') as $key => $wearStatus) {
                    $selection['WearStatus'][]=$wearStatus;
                }
            }
            else
            {
                foreach ($wearStatuss as $key => $wearStatus) {
                    $selection['WearStatus'][]=$wearStatus->getId();
                }
            }
           
            $em = $this->getDoctrine()->getManager();
            $articles= $em->getRepository(Article::class)->findArticlesByMultipleSelection($selection);
            return $this->render('article/selection.html.twig', [
            'articles' => $articles,
            ]);
            
        }

        return $this->render('article/selection.html.twig', [
            'genders' => $genders,
            'sizes' => $sizes,
            'types' => $types,
            'seasons' => $seasons,
            'colors' => $colors,
            'brands' => $brands,
            'wearStatuss' => $wearStatuss,
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/article/new", name="article_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $details = new Article();
        $form = $this->createForm(ArticleType::class, $details);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $details = $form->getData();

            $article->setArticleGender($details->getArticleGender());
            $article->setArticleType($details->getArticleType());
            // foreach($details->getArticleSeason() as $season)
            // {
            //     $article->setArticleSeason($season);
            // }
            $article->setArticleSeason($details->getArticleSeason());
            $article->setArticleSize($details->getArticleSize());
            $article->setArticleColor($details->getArticleColor());
            $article->setArticleBrand($details->getArticleBrand());
            $article->setArticleWearStatus($details->getArticleWearStatus());
            foreach($details->getArticleFabric() as $fabric)
            {
                $article->setArticleFabric([
                    'name' =>$fabric->getFabricName(),
                    'percentage'=>$fabric->getFabricPercentage()]);
            }
            $article->setArticleButtonValue($details->getArticleButtonValue());
            $article->setArticleEurosValue($details->getArticleEurosValue());
            $article->setArticleComments($details->getArticleComments());
            $article->setArticleProcessStatus($details->getArticleProcessStatus());

// On récupère le code du dernier article pour créer le code de l'article en cours de création
            $em = $this->getDoctrine()->getManager();
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

            $em->persist($article);
            $em->flush();

            $this->addFlash(
                    'notice',
                    'L\'article a bien été crée !'
            );

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $details,
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
