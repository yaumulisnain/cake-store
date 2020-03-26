<?php

namespace App\Http\Helper;

class ResponseHelper
{
    public function getPaginationParams($request)
    {
        $urlQuery = $request->query->all();
        
        $page = 0;
        $limit = 0;

        if(array_key_exists('page', $urlQuery) && array_key_exists('limit', $urlQuery))
        {
            $page = ((int) $urlQuery['page']) - 1;
            $limit = (int) $urlQuery['limit'];
        }

        if($limit == 0)        
        {
            $limit = 10;
        }

        $pagination = array(
            'page' => $page,
            'limit' => $limit
        );

        return $pagination;
    }

    public function createJson($isError, $data, $code, $message, $status, $meta)
    {
        $response = array();

        if(isset($data))
        {
            if($isError)
            {
                $response["error"] = $data;
            }
            else
            {
                $response["data"] = $data;
            }
        }

        $response["code"] = $code;
        $response["message"] = $message;
        $response["status"] = $status;

        if(isset($meta))
        {
            $response["meta"] = $meta;
        }

        return response(json_encode($response))->header('Content-Type', 'application/json');
    }

    public function createPageMeta($totalPage, $totalRecord, $limit, $pageNumber)
    {
        $meta = array(
            "total_page" => $totalPage,
            "total_record" => $totalRecord,
            "limit" => $limit,
            "page_number" => $pageNumber
        );

        return $meta;
    }
    
}