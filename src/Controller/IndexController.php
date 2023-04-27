<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/acceuil', name: 'app_acceuil')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findBy(['visible' => true, 'discount' => true]);
        return $this->render('acceuil/acceuil.html.twig', [
            'products' => $products,
        ]);
    }
}
