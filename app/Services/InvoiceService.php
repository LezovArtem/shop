<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Repositories\InvoiceRepository;

class InvoiceService
{
    public function __construct(private InvoiceRepository $invoiceRepository)
    {
    }

    public function store($dto)
    {
        $products = $dto->products;
        unset($dto->products);

        $productIds = $this->getProductIds($products);

        if (($dto->status == "P" || $dto->status == "p") && !isset($dto->paid_date)){
            $paid_date = now()->toDateTimeString();
        } else {
            $paid_date = $dto->paid_date;
        }
        return $this->invoiceRepository->store($dto, $productIds, $paid_date);
    }

    public function update($invoice, $dto)
    {
        $products = $dto['products'];

        unset($dto['products']);

        $productIds = $this->getUpdatedProductIds($products);

        return $this->invoiceRepository->update($invoice, $dto, $productIds);
    }

    private function getproductIds($products){
        $productIds = [];

        foreach ($products as $product){
            if (isset($product['id'])){
                $product = Product::find($product['id']);
            }
            $productIds[] = $product->id;
        }
        return $productIds;
    }

    private function getUpdatedProductIds($products){
        $productIds = [];

        foreach ($products as $product) {
            if (isset($product['id'])){
                $currentProduct = Product::find($product['id']);
                $currentProduct->update($product);
                $product = $currentProduct->fresh();
            }

            $productIds[] = $product->id;
        }

        return $productIds;
    }
}
