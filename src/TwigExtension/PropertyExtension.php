<?php

namespace App\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PropertyExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('formattedPrice', [$this, 'formattedPrice'])
        ];
    }

    public function formattedPrice($number)
    {
        return number_format($number, 2, ',', ' ') . ' FC';
    }
}
