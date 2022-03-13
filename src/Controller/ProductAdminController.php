<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/product')]
#[IsGranted('ROLE_PRODUCT_ADMIN')]
class ProductAdminController extends AbstractController
{
    #[Route('/', name: 'app_product_admin_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('productAdmin/index.html.twig', [
            'title' => 'All products',
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_product_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product);
            return $this->redirectToRoute('app_product_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('productAdmin/new.html.twig', [
            'title' => 'New product',
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_admin_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('productAdmin/show.html.twig', [
            'title' => $product->getProductName(),
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product);
            return $this->redirectToRoute('app_product_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('productAdmin/edit.html.twig', [
            'title' => $product->getProductName(),
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_admin_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product);
        }

        return $this->redirectToRoute('app_product_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
