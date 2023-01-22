<?php declare(strict_types=1);

namespace App\Controller;

use App\Components\PriceCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PriceController extends AbstractController
{
    private PriceCalculator $priceCalculator;

    public function __construct(PriceCalculator $priceCalculator)
    {
        $this->priceCalculator = $priceCalculator;
    }

    #[Route('/', name: 'home', methods: "GET")]
    public function index(Request $request): Response
    {
        return $this->render('price-form.html.twig');
    }

    #[Route('/check-price', name: 'check-price', methods: "POST")]
    public function checkPrice(Request $request): Response
    {
        return new Response((string)$this->priceCalculator->calculateProductPrice($request->get('tax_number'), $request->get('product')));
    }
}