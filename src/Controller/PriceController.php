<?php
namespace App\Controller;

use App\Form\ProductType;
use App\Service\TaxService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ProductService;

class PriceController extends AbstractController
{
    /**
     * @param Request $request
     * @param ProductService $productService
     * @param TaxService $taxService
     * @return Response
     */
    public function index(Request $request, ProductService $productService, TaxService $taxService): Response
    {
        $form = $this->createForm(ProductType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $selectedProduct = $form->get('product')->getData();

            // Получаем страну покупателя из tax номера
            $countryCode = substr($data['taxNumber'], 0, 2);

            $price = $selectedProduct->getPrice();
            $taxAmount = $taxService->calculateTax($price, $countryCode);

            return $this->render('price/result.html.twig', [
                'product' => $selectedProduct,
                'priceWithTax' => $taxAmount,
            ]);
        }

        return $this->render('price/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
