<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cake;
use App\Http\Helper\ResponseHelper;

class CakeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ResponseHelper $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }

    public function list(Request $request)
    {
        $data = array();

        try
        {
            $pageHelper = $this->responseHelper->getPaginationParams($request);
            $page = $pageHelper['page'];
            $limit = $pageHelper['limit'];

            $totalRecord = Cake::all()->count();
            $record = Cake::orderBy('id', 'asc')
                             ->offset($page * $limit)
                             ->limit($limit)
                             ->get();

            $totalPage = (int) ceil($totalRecord / $limit);
            
            $meta = $this->responseHelper->createPageMeta($totalPage, $totalRecord, $limit, $page + 1);
            $data = $this->responseHelper->createJson(false, $record, 200, 'success', true, $meta);
        }
        catch(Exception $err)
        {
            $data = $this->responseHelper->createJson(true, $err->getTraceAsString(), 400, $err->getMessage(), false, null);
        }

        return $data;
    }
 
    public function show($id)
    {
        $data = array();

        try
        {
            $record = Cake::findOrFail($id);
            
            $meta = $this->responseHelper->createPageMeta(0, 0, 0, 0);
            $data = $this->responseHelper->createJson(false, $record, 200, 'success', true, $meta);
        }
        catch(Exception $err)
        {
            $data = $this->responseHelper->createJson(true, $err->getTraceAsString(), 400, $err->getMessage(), false, null);
        }

        return $data;
    }

    public function store(Request $request)
    {
        $data = array();

        try
        {
            $requestData = json_decode($request->getContent());

            // TODO: Validate Value
            $createData = Cake::create($requestData);

            $meta = $this->responseHelper->createPageMeta(0, 0, 0, 0);
            $data = $this->responseHelper->createJson(false, $createData, 201, 'success', true, $meta);
        }
        catch(Exception $err)
        {
            $data = $this->responseHelper->createJson(true, $err->getTraceAsString(), 400, $err->getMessage(), false, null);
        }

        return $data;
    }

    public function update(Request $request, $id)
    {
        $data = array();

        try
        {
            $requestData = json_decode($request->getContent());

            // TODO: Validate Value
            $updateData = Cake::findOrFail($id);
            $updateData->update($requestData);

            $meta = $this->responseHelper->createPageMeta(0, 0, 0, 0);
            $data = $this->responseHelper->createJson(false, $updateData, 200, 'success', true, $meta);
        }
        catch(Exception $err)
        {
            $data = $this->responseHelper->createJson(true, $err->getTraceAsString(), 400, $err->getMessage(), false, null);
        }

        return $data;
    }

    public function delete($id)
    {
        $data = array();

        try
        {
            $cake = Cake::findOrFail($id);
            $cake->delete();

            $meta = $this->responseHelper->createPageMeta(0, 0, 0, 0);
            $data = $this->responseHelper->createJson(false, $cake, 200, 'success', true, $meta);
        }
        catch(Exception $err)
        {
            $data = $this->responseHelper->createJson(true, $err->getTraceAsString(), 400, $err->getMessage(), false, null);
        }

        return $data;
    }
}
