<?php
namespace App\Service;

class TaxService
{
    public const TAX_RATES = [
        'DE' => 19, // Germany
        'IT' => 22, // Italy
        'GR' => 24, // Greece
    ];

    /**
     * @param string $countryCode
     * @return float|null
     */
    public function getTaxRate(string $countryCode): ?float
    {
        return self::TAX_RATES[$countryCode] ?? null;
    }

    /**
     * @param float $price
     * @param string $countryCode
     * @return float|null
     */
    public function calculateTax(float $price, string $countryCode): ?float
    {
        $taxRate = $this->getTaxRate($countryCode);

        if ($taxRate === null) {
            return null;
        }

        return ($price / 100 * $taxRate) + $price;
    }
}
