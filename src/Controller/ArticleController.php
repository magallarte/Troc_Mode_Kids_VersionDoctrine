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
use App\Entity\ProcessStatus;
use App\Repository\ProcessStatusRepository;
use App\Entity\DeliveryBag;
use App\Entity\Kid;
use App\Entity\Member;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;


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
    public function selection(Request $request, SessionInterface $session): Response
    {
        $em = $this->getDoctrine()->getManager();

        $genders= $em->getRepository(Gender::class)->findAll();
        $sizes= $em->getRepository(Size::class)->findAll();
        $types= $em->getRepository(Type::class)->findAll();
        $seasons= $em->getRepository(Season::class)->findAll();
        $colors= $em->getRepository(Color::class)->findAll();
        $brands= $em->getRepository(Brand::class)->findAll();
        $wearStatuss= $em->getRepository(WearStatus::class)->findAll();
        $articles= $em->getRepository(Article::class)->findArticlesToSellStatus();

        if($session->get('user'))
        {
            $user = $session->get('user');
        }
        
        if ( (!empty($request->get('preselectionKid'))))
        {
            $em = $this->getDoctrine()->getManager();
            $kid=$em->getRepository(Kid::class)->find($request->get('preselectionKid'));
            $articles= $em->getRepository(Article::class)->findByKid($kid);
            return $this->render('article/selection.html.twig', [
            'genders' => $genders,
            'sizes' => $sizes,
            'types' => $types,
            'seasons' => $seasons,
            'colors' => $colors,
            'brands' => $brands,
            'wearStatuss' => $wearStatuss,
            'articles' => $articles,
            ]);
        }

        if ( (!empty($request->get('selectionGender'))) || (!empty($request->get('selectionSize'))) || (!empty($request->get('selectionType'))) || (!empty($request->get('selectionSeason'))) || (!empty($request->get('selectionColor'))) || (!empty($request->get('selectionBrand'))) || (!empty($request->get('selectionWearStatus')) ))
        {

            if(!empty($request->get('selectionGender'))){
                foreach ($request->get('selectionGender') as $key => $gender) {
                    $selection['Gender'][]=$gender;
                }
            }else{
                foreach ($genders as $key => $gender) {
                    $selection['Gender'][]=$gender->getId();
                }
            }
            
            if(!empty($request->get('selectionSize'))){
                foreach ($request->get('selectionSize') as $key => $size) {
                    $selection['Size'][]=$size;
                }
            }else{
                foreach ($sizes as $key => $size) {
                    $selection['Size'][]=$size->getId();
                }
            }
            
            if(!empty($request->get('selectionType'))){
                foreach ($request->get('selectionType') as $key => $type) {
                    $selection['Type'][]=$type;
                }
            }else{
                foreach ($types as $key => $type) {
                    $selection['Type'][]=$type->getId();
                }
            }
            
            if(!empty($request->get('selectionSeason'))){
                foreach ($request->get('selectionSeason') as $key => $season) {
                    $selection['Season'][]=$season;
                }
            }else{
                foreach ($seasons as $key => $season) {
                    $selection['Season'][]=$season->getId();
                }
            }

            if(!empty($request->get('selectionColor'))){
                foreach ($request->get('selectionColor') as $key => $color) {
                    $selection['Color'][]=$color;
                }
            }else{
                foreach ($colors as $key => $color) {
                    $selection['Color'][]=$color->getId();
                }
            }
            
            if(!empty($request->get('selectionBrand'))){
                foreach ($request->get('selectionBrand') as $key => $brand) {
                    $selection['Brand'][]=$brand;
                }
            }else{
                foreach ($brands as $key => $brand) {
                    $selection['Brand'][]=$brand->getId();
                }
            }
            
            if(!empty($request->get('selectionWearStatus'))){
                foreach ($request->get('selectionWearStatus') as $key => $wearStatus) {
                    $selection['WearStatus'][]=$wearStatus;
                }
            }else{
                foreach ($wearStatuss as $key => $wearStatus) {
                    $selection['WearStatus'][]=$wearStatus->getId();
                }
            }

            $em = $this->getDoctrine()->getManager();
            $articles= $em->getRepository(Article::class)->findArticlesByMultipleSelection($selection);
            return $this->render('article/selection.html.twig', [
            'genders' => $genders,
            'sizes' => $sizes,
            'types' => $types,
            'seasons' => $seasons,
            'colors' => $colors,
            'brands' => $brands,
            'wearStatuss' => $wearStatuss,
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
            'articles' => $articles,
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
            $article = new Article();
            $article->setArticleGender($details->getArticleGender());
            $article->setArticleType($details->getArticleType());
            foreach($details->getArticleSeason() as $season)
            {
                $article->addArticleSeason($season);
            }
            $article->setArticleSize($details->getArticleSize());
            foreach($details->getArticleColor() as $color)
            {
                $article->addArticleColor($color);
            }
            $article->setArticleBrand($details->getArticleBrand());
            $article->setArticleWearStatus($details->getArticleWearStatus());
            foreach($details->getArticleFabric() as $fabric)
            {
                $article->addArticleFabric($fabric);
            }
            $article->setArticleButtonValue($details->getArticleButtonValue());
            $article->setArticleEurosValue($details->getArticleEurosValue());
            $article->setArticleComments($details->getArticleComments());
            $article->setArticleProcessStatus($details->getArticleProcessStatus());

            // Look for the last created article with same gender, size and type to determine the code
            // of the new article in creation
            $em = $this->getDoctrine()->getManager();
            $criteria=array(
                'article_gender'=> $details->getArticleGender(),
                'article_size'=> $details->getArticleSize(),
                'article_type'=> $details->getArticleType(),
            );
            $orderBy = array('id'=>'DESC');

            $lastArticle = $em->getRepository(Article::class)->findOneBy($criteria,$orderBy);
            
            if(is_null ($lastArticle))
            {
                $lastArticleCode = ('XXXXXXXXX0000');
            }
            else{
                $lastArticleCode = $lastArticle->getArticleCode();
            }
            $article->setArticleCode($lastArticleCode);

            // we upload the picture file and name it with the new article code
            // Picture 1
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file1 */
            $file1 = $details->getArticlePicture1();
            $fileName1 = $article->setArticleCode($lastArticleCode).'(1).'.$file1->guessExtension();

            // moves the file to the directory where images are stored
            $file1->move(
                $this->getParameter('pictures_directory'),
                $fileName1
            );
            // updates the 'ArticlePicture1' property to store the PDF file name
            // instead of its contents
            $article->setArticlePicture1($fileName1);

            // Picture 2
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file2 */
            $file2 = $details->getArticlePicture2();
            $fileName2 = $article->setArticleCode($lastArticleCode).'(2).'.$file2->guessExtension();

            // moves the file to the directory where images are stored
            $file2->move(
                $this->getParameter('pictures_directory'),
                $fileName2
            );
            // updates the 'ArticlePicture2' property to store the PDF file name
            // instead of its contents
            $article->setArticlePicture2($fileName2);

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
    
    //VOIR SI UTILE DE METTRE requirements={"id"="\d+"}
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
     * @Route("/article/{id}", name="article_delete", methods="DELETE", requirements={"id"="\d+"})
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
