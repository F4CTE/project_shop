<?php

namespace App\Controller\Api;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/api/products', name: 'app_api_product')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->json($products, context: [
            'groups' => ['products:read']
        ]);
    }
}
