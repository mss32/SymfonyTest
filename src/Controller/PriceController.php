<?php
namespace App\Controller;

use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PriceController extends AbstractController
{
    const GERMANY_TAX = 0.19;
    const ITALY_TAX = 0.22;
    const GREECE_TAX = 0.24;

    #[Route('/', name: 'price')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $productPrice = $data['product'];
            $taxNumber = $data['taxNumber'];
            $countryCode = substr($taxNumber, 0, 2);

            switch ($countryCode) {
                case 'DE':
                    $tax = self::GERMANY_TAX;
                    break;
                case 'IT':
                    $tax = self::ITALY_TAX;
                    break;
                case 'GR':
                    $tax = self::GREECE_TAX;
                    break;
                default:
                    throw new \InvalidArgumentException('Invalid country code');
            }

            $finalPrice = $productPrice * (1 + $tax);

            return $this->render('price/result.html.twig', [
                'final_price' => $finalPrice,
            ]);
        }

        return $this->render('price/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}