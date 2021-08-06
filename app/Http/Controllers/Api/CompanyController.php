<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
   use  ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function  index(): \Illuminate\Http\JsonResponse
    {
        $data = Company::all();
        return $this->success($data,'company list');
    }
    public function detail(CompanyRequest  $request): \Illuminate\Http\JsonResponse
    {
        $data = Company::find($request->id);
        return $this->success($data,'company details');
    }



}
