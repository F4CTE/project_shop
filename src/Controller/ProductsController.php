<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    #[Route('/products', name: 'app_products')]
    public function index(ProductRepository $productRepository): Response
    {
        $faker = \Faker\Factory::create();
        $products = $productRepository->findBy(['visible' => true]);
        return $this->render('products/products.html.twig', [
            'products' => $products,
        ]);
    }
}
