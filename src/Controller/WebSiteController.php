<?php


namespace App\Controller;


use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class WebSiteController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function homePage(): Response
    {
        return $this->render('pages/home.html.twig');
    }

    /**
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function navbar(Request $request, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render(
            '_header.html.twig',
            [
                'categories' => $categories,
                'route' => $request->get('_route'),
            ]
        );
    }

    /**
     *
     * @Route("/admin", name="admin_access")
     * @param SessionInterface $session
     * @return Response
     */
    public function adminAccess(SessionInterface $session): Response
    {

        if ($session->get('admin') === true) {
            return $this->render('/admin/adminAccess.html.twig');
        }
        return $this->redirectToRoute('login');
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @return Response
     * @Route("/mes-creations", name="creations")
     */
    public function creationsPage(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render(
            'pages/creations.html.twig',
            [
                'categories' => $categories,
            ]
        );
    }

    /**
     * @Route("/mes-creations/category/{slug}", name="category_details")
     * @param $slug
     * @param CategoryRepository $categoryRepository
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function categoryDetailsPage(
        $slug,
        CategoryRepository $categoryRepository,
        ArticleRepository $articleRepository
    ): Response {
        $category = $categoryRepository->findOneBySlug($slug);
        dump($category->getArticles());die();


        return $this->render(
            'pages/categoryDetails.html.twig',
            [
                'articles' => $articles,
            ]
        );
    }
}