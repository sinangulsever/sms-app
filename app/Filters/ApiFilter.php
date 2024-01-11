<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{

    protected array $safeParams = [];

    protected array $columnMap = [];

    protected array $operatorMap = [];


    public function transform(Request $request, $queryModel)
    {
        $eloQuery = [];
        $dateQuery = [];
        $betweenQuery = [];
        foreach ($this->safeParams as $param => $operators) {
            $query = $request->query($param);

            if (!isset($query)) {
                continue;
            }
            $column = $this->columnMap[$param] ?? $param;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    if ($this->operatorMap[$operator] === 'like') {
                        $eloQuery[] = [$column, $this->operatorMap[$operator], '%' . $query[$operator] . '%'];
                    } else
                        if (strpos($column, 'date') || strpos($column, 'Date')) {
                            if ($operator === 'btw') {
                                $date = explode('x', $query[$operator]);
                                $firstDate = date('Y-m-d', strtotime($date[0]));
                                $lastDate = date('Y-m-d', strtotime($date[1]));
                                $betweenQuery[] = [$column, $this->operatorMap[$operator], [$firstDate, $lastDate]];
                                continue;
                            } else {
                                $dateQuery[] = [$column, $this->operatorMap[$operator], date('Y-m-d', strtotime($query[$operator]))];
                                continue;
                            }
                            $dateQuery[] = [$column, $this->operatorMap[$operator], date('Y-m-d', strtotime($query[$operator]))];
                        } else
                            $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }


        if (count($eloQuery)) {
            $queryModel = $queryModel->where($eloQuery);
        }

        if (count($dateQuery)) {
            foreach ($dateQuery as $date) {
                $queryModel->whereDate($date[0], $date[1], $date[2]);
            }
        }

        if (count($betweenQuery)) {
            foreach ($betweenQuery as $between) {
                $queryModel->whereDate($between[0], '>=', $between[2][0])
                    ->whereDate($between[0], '<=', $between[2][1]);
            }
        }

        return $queryModel;
    }


}
