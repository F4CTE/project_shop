<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Product1Type;
use App\Repository\ProductRepository;
use App\Security\Voter\ProductVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product/crud/maker')]
class ProductCrudMakerController extends AbstractController
{
    #[Route('/', name: 'app_product_crud_maker_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product_crud_maker/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_product_crud_maker_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(Product1Type::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_crud_maker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product_crud_maker/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_crud_maker_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product_crud_maker/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_crud_maker_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {

        $this->denyAccessUnlessGranted(ProductVoter::EDIT, $product, 'You cannot edit this product.');

        $form = $this->createForm(Product1Type::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_crud_maker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product_crud_maker/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_crud_maker_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $this->denyAccessUnlessGranted(ProductVoter::DELETE, $product, 'You cannot delete this product.');
        
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_product_crud_maker_index', [], Response::HTTP_SEE_OTHER);
    }
}
