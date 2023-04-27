<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'app_product')]
    public function index(Product $product): Response
    {
        if (!$product->isVisible()) {
            throw $this->createNotFoundException('This product is not available.');
        } else {
            return $this->render('product/product.html.twig', [
                'product' => $product
            ]);
        }
    }
}
