<?php

declare(strict_types=1);

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class InvoiceFilter extends ApiFilter
{
    protected $safeParms = [
      'id' => ['eq', 'gt', 'lt', 'gte', 'lte'],
      'userId' => ['eq', 'gt', 'lt', 'gte', 'lte'],
      'amount' => ['eq', 'gt', 'lt', 'gte', 'lte'],
      'status' => ['eq', 'ne'],
      'billedDate' => ['eq', 'ne' , 'gt', 'lt', 'gte', 'lte'],
      'paidDate' => ['eq', 'ne', 'gt', 'lt', 'gte', 'lte'],
    ];

    protected $columnMap = [
        'userId' => 'user_id',
        'billedDate' => 'billed_date',
        'paidDate' => 'paid_date',
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
