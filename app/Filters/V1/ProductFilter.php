<?php

declare(strict_types=1);

namespace App\Filters\V1;

use App\Filters\ApiFilter;

final class ProductFilter extends ApiFilter
{
    protected $safeParms = [
      'id' => ['eq', 'gt', 'lt', 'gte', 'lte'],
      'quantity' => ['eq', 'gt', 'lt', 'gte', 'lte'],
      'price' => ['eq', 'gt', 'lt', 'gte', 'lte'],
    ];


    protected $operatorMap = [
        'eq' => '=',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
        'ne' => '!='
    ];
}
