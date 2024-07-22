<?php

declare(strict_types=1);

namespace App\Order\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OrderController extends AbstractController
{
    #[Route('/', name: 'order')]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }
}
