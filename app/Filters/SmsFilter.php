<?php

namespace App\Filters;


class SmsFilter extends ApiFilter
{

    protected array $safeParams = [
        'id' => ['eq', 'lt', 'lte', 'gt', 'gte'],
        'createDate' => ['eq', 'lt', 'lte', 'gt', 'gte', 'btw'],
        'sendDate' => ['eq', 'lt', 'lte', 'gt', 'gte', 'btw'],
        'statusCode' => ['eq'],
    ];

    protected array $columnMap = [
        'id' => 'id',
        'createDate' => 'created_at',
        'sendDate' => 'send_date',
        'statusCode' => 'status',
    ];

    protected array $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'btw' => 'between',
    ];

}
