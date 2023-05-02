<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/products')]
class ProductController extends AbstractController
{
  #[Route('/', name: 'products_crud_list')]
  public function index(ProductRepository $productRepository): Response
  {
    $products = $productRepository->findAll();

    return $this->render('admin/product/products.html.twig', [
      'products' => $products
    ]);
  }

  #[Route('/create', name: 'products_crud_create')]
  public function create(
    Request $request,
    EntityManagerInterface $em
  ): Response {
    $product = new Product();
    $form = $this->createForm(ProductType::class, $product);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $product->setDateCreated(new DateTime());
      $em->persist($product);
      $em->flush();
      $this->addFlash('success', 'Produit créé');
      return $this->redirectToRoute('products_crud_list');
    }

    return $this->renderForm('admin/product/create.html.twig', [
      'form' => $form
    ]);
  }

  #[Route('/edit/{id}', name: 'products_crud_edit')]
  public function edit(
    Request $request,
    Product $product,
    EntityManagerInterface $em
  ): Response {
    $form = $this->createForm(ProductType::class, $product);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->flush();
      $this->addFlash('success', 'Produit modifié');
      return $this->redirectToRoute('products_crud_list');
    }

    return $this->renderForm('admin/product/edit.html.twig', [
      'form' => $form
    ]);
  }

  #[Route('/delete/{id}', name: 'products_crud_delete')]
  public function delete(
    Product $product,
    ProductRepository $productRepository
  ): Response {
    $productRepository->remove($product, true);
    $this->addFlash('success', 'Produit supprimé');
    return $this->redirectToRoute('products_crud_list');
  }
}