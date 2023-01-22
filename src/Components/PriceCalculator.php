<?php declare(strict_types=1);

namespace App\Components;

class PriceCalculator
{
    private const AVAILABLE_PRODUCTS = [
        'phone_case' => 20,
        'headphones' => 100
    ];
    private const AVAILABLE_COUNTRIES = [
        'GR' => 'greece',
        'DE' => 'germany',
        'IT' => 'italy'
    ];
    private const PRICE_MULTIPLIER_BY_COUNTRY = [
        'GR' => 0.24,
        'DE' => 0.19,
        'IT' => 0.22
    ];

    /**
     * @param string $taxNumber
     * @param string $productName
     * @return float|null
     */
    public function calculateProductPrice(string $taxNumber, string $productName): ?float
    {
        if (!$this->getCountryByTaxCode($taxNumber)) {
            return null;
        }

        $country = $this->getCountryByTaxCode($taxNumber);

        return $this->calculatePrice($country, $productName);
    }

    /**
     * @param string $taxNumber
     * @return string|null
     */
    private function getCountryByTaxCode(string $taxNumber): ?string
    {
        $taxNumberCountry = strtoupper(substr($taxNumber, 0, 2));

        return match ($taxNumberCountry) {
            "DE" => self::AVAILABLE_COUNTRIES['DE'],
            "GR" => self::AVAILABLE_COUNTRIES['GR'],
            "IT" => self::AVAILABLE_COUNTRIES['IT'],
            default => null,
        };
    }

    /**
     * @param string $country
     * @param string $productName
     * @return float|null
     */
    private function calculatePrice(string $country, string $productName): ?float
    {
        if (!in_array($productName, array_keys(self::AVAILABLE_PRODUCTS))) {
            return null;
        }

        $countryCode = array_search($country, self::AVAILABLE_COUNTRIES);
        $multiplier = self::PRICE_MULTIPLIER_BY_COUNTRY[$countryCode];
        $originalSellerPrice = self::AVAILABLE_PRODUCTS[$productName];

        return $originalSellerPrice + $originalSellerPrice*$multiplier;
    }
}