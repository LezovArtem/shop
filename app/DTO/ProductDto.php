<?php

declare(strict_types=1);

namespace App\DTO;

final class ProductDto
{
    public string $title;
    public string $description;
    public int $quantity;
    public float $price;
    public array $category;
    public array $tags;
    public array $colors;
}
