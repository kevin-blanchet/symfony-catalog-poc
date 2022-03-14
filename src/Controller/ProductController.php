<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductSearchFormType;
use App\Form\ProductFormType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'title' => 'All products',
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/search', name: 'app_product_search_index')]
    public function searchIndex(ProductRepository $productRepository, Request $request): Response
    {
        $form = $this->createForm(ProductSearchFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $searchTerm = $form->get('search_term')->getData();
            return $this->redirectToRoute('app_product_search', Array('term' => $searchTerm));
        }

        return $this->render('product/search.html.twig', [
            'title' => 'Search a product',
            'searchForm' => $form->createView()
        ]);
    }

    #[Route('/search/{term}', name: 'app_product_search', methods: ['GET'])]
    public function search(string $term, ProductRepository $productRepository): Response
    {
        $products = $this->_search($productRepository, $term);
        return $this->render('product/search_ajax.html.twig', [
            'products' => $products,
        ]);
    }

    private function _search(ProductRepository $productRepository, string $term): array
    {
        return array_unique(array_merge($productRepository->findByName($term), $productRepository->findByTag($term)));
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'title' => $product->getProductName(),
            'product' => $product,
        ]);
    }
}
