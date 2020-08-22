<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateOrUpdateOrder;
use Facades\App\Http\Services\OrderService;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OrderService::list();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateOrUpdateOrder  $request
     * @return \Illuminate\Http\Response
     */
    public function updateOrCreate(CreateOrUpdateOrder $request)
    {
        $data = $request->only([
            'id', 'user_fname', 'user_lname', 'user_phone', 'user_address', 'zip_code', 'quantity', 'total'
        ]);

        return OrderService::updateOrCreate($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
