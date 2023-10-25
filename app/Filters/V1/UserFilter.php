<?php

declare(strict_types=1);

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class UserFilter extends ApiFilter
{
    protected $safeParms = [
      'id' => ['eq', 'gt', 'lt', 'gte', 'lte'],
      'firstName' => ['eq', 'ne'],
      'middleName' => ['eq', 'ne'],
      'lastName' => ['eq', 'ne'],
      'gender' => ['eq', 'ne'],
    ];

    protected $columnMap = [
        'firstName' => 'first_name',
        'middleName' => 'middle_name',
        'lastName' => 'last_name',
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
