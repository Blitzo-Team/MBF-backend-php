<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function __construct() {
        $this->DISABLE_AUTH = true;
    }

    public function paginate_filter_sort_search($query, $ALLOWED_FILTERS, $JSON_FIELDS=[], $BOOL_FIELDS=[], $SEARCH_FIELDS=[]) {

        $q = request('q', null);
        if (request('q')) {
            $filter_queries = [];
            foreach ($SEARCH_FIELDS as $search_field) {
                array_push($filter_queries, "`$search_field` LIKE '%$q%' ");                
            }
            if (sizeof($filter_queries) > 0) {
                $all_query = '(' . implode(' or ', $filter_queries) . ')';
                $query = $query->whereRaw($all_query);    
            }
        }

        $all_filter_queries = [];
        $filters = [];
        
        foreach ($ALLOWED_FILTERS as $allowed_filter) {
            $filters[$allowed_filter] = request($allowed_filter);
            if (request($allowed_filter, null)) {
                $filter_queries = [];
                foreach (request($allowed_filter) as $filter) {
                    array_push($filter_queries, "`$allowed_filter` = '$filter' ");
                }
                if (sizeof($filter_queries) > 0) {
                    $filter_query = '(' . implode(' or ', $filter_queries) . ')';
                    array_push($all_filter_queries, $filter_query);
                }
            }
        }
        if (sizeof($all_filter_queries) > 0) {
            $all_query = '(' . implode(' and ', $all_filter_queries) . ')';

            $query = $query->whereRaw($all_query);    
        }

        // pagination
        $total = count(\DB::select($query->toSql(), $query->getBindings())); //$query->count();
        $page = (int)request('page', 1);
        $take = (int)request('take', $total);
        $skip = ($page-1) * $take;
        $query = $query->skip($skip)->take($take);        
        
        // sorting
        $sort_key = request('sort_key', 'id');
        $sort_dir = request('sort_dir', 'ascend') == 'descend' ? 'desc': 'asc';        
        $data = $query->orderBy($sort_key, $sort_dir)->get();
        
        if (sizeof($JSON_FIELDS) > 0) {
            $data->transform(function ($item, $key) use($JSON_FIELDS) {
                foreach ($JSON_FIELDS as $json_field) {
                    $item->{$json_field} = json_decode($item->{$json_field});
                }
                return $item;
            });    
        }

        if (sizeof($BOOL_FIELDS) > 0) {
            $data->transform(function ($item, $key) use($BOOL_FIELDS) {
                foreach ($BOOL_FIELDS as $bool_field) {
                    $item->{$bool_field} = boolval($item->{$bool_field});
                }
                return $item;
            });    
        }

        return array(
            'filters' => $filters,
            'sort_dir' => $sort_dir, 
            'sort_key' => $sort_key, 
            'page'=> $page, 
            'take' => $take, 
            'total' => $total,
            'q' => $q,
            'data' => $data
        );
    }

}
