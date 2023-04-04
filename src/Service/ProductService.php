<?php
namespace App\Service;

use App\Entity\Product;

/**
 * Сервис для создания товаров вместо использования базы данных.
 */
class ProductService
{
    /**
     * @var Product[] $products
     */
    private array $products = [];

    public function __construct()
    {
        // simulate loading products from a database
        $product1 = new Product();
        $product1->setId(1);
        $product1->setName('Наушники');
        $product1->setPrice(100);

        $product2 = new Product();
        $product2->setId(2);
        $product2->setName('Чехол для телефона');
        $product2->setPrice(20);

        $this->products = [
            $product1,
            $product2,
        ];
    }

    /**
     * @param int $productId
     * @return Product|null
     */
    public function getProductById(int $productId): ?Product
    {
        return $this->products[$productId] ?? null;
    }

    /**
     * @return Product[]
     */
    public function getAllProducts(): array
    {
        return $this->products;
    }
}
