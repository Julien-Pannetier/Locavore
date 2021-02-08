<?php

namespace Helper;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigExtension extends AbstractExtension
{
    
    public function getFilters()
    {
        return [
            new TwigFilter('latitude', [$this, 'latitude']),
            new TwigFilter('longitude', [$this, 'longitude']),
            new TwigFilter('products', [$this, 'products'])
        ];
    }

    public function latitude($value)
    {
        $splitString = preg_split('[\s]', $value);
        $latitude = substr($splitString[1], 0, -1);
        return $latitude;
    }

    public function longitude($value)
    {
        $splitString = preg_split('[\s]', $value);
        $longitude = substr($splitString[0], 6);
        return $longitude;
    }

    public function products($value)
    {
        $products = explode(", ", $value);
        return var_dump($products);
    }
}