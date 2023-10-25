<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Tag;
use App\Repositories\ProductRepository;

final class ProductService
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function store($dto)
    {
        $tags = $dto->tags;
        $category = $dto->category;
        $colors = $dto->colors;

        unset($dto->tags, $dto->category, $dto->colors);

        $tagIds = $this->getTagIds($tags);
        $colorIds = $this->getColorIds($colors);
        $categoryId = $this->getCategoryId($category);

        return $this->productRepository->store($dto, $tagIds, $colorIds, $categoryId);
    }

    public function update($product, $data){
        $category = $data['category'];
        $tags = $data['tags'];
        $colors = $data['colors'];

        unset($data['category'], $data['tags'] ,$data['colors']);

        $tagIds = $this->getUpdatedTagIds($tags);
        $colorIds = $this->getUpdatedColorIds($colors);
        $categoryId = $this->getUpdatedCategoryId($category);

        return $this->productRepository->update($product, $data, $tagIds, $colorIds, $categoryId);
    }

    private function getCategoryId($item)
    {
        if (isset($item['id'])){
            $category = Category::find($item['id']);
        } else {
            $category = Category::create($item);
        }

        return $category->id;
    }


    private function getTagIds($tags)
    {
        $tagIds = [];


        foreach ($tags as $tag) {
            if (isset($tag['id'])){
                $tag = Tag::find($tag['id']);
            } else {
                    $tag = Tag::create($tag);
                }

            $tagIds[] = $tag->id;
        }

        return $tagIds;
    }

    private function getColorIds($colors)
    {
        $colorIds = [];


        foreach ($colors as $color) {
            if (isset($color['id'])){
                $color = Color::find($color['id']);
            } else {
                $color = Color::create($color);
            }

            $colorIds[] = $color->id;
        }

        return $colorIds;
    }

    private function getUpdatedCategoryId($item)
    {
        if (isset($item['id'])){
            $category = Category::find($item['id']);
            $category->update($item);
        } else {
            $category = Category::create($item);
        }

        return $category->id;
    }

    private function getUpdatedTagIds($tags){
        $tagIds = [];

        foreach ($tags as $tag) {
            if (isset($tag['id'])){
                $currentTag = Tag::find($tag['id']);
                $currentTag->update($tag);
                $tag = $currentTag->fresh();
            } else {
                $tag = Tag::create($tag);
            }

            $tagIds[] = $tag->id;
        }
        return $tagIds;
    }

    private function getUpdatedColorIds($colors){
        $colorIds = [];

        foreach ($colors as $color) {
            if (isset($color['id'])){
                $currentColor = Color::find($color['id']);
                $currentColor->update($color);
                $color = $currentColor->fresh();
            } else {
                $color = Color::create($color);
            }

            $colorIds[] = $color->id;
        }

        return $colorIds;
    }
}
