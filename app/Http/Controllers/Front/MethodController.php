<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Method;
use Illuminate\Http\Request;
use App\Http\Requests\MethodRequest;
use App\Models\Company;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class MethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($langcode)
    {
        $methods = Method::get();
        $companies = Company::get();
        return view('front.user.methods.method', compact(['methods', 'companies']));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($langcode, Request $request) : JsonResponse
    {
        $response = Http::accept('application/json')->post(route('api.method.create'), $request->all());

        $res = $response->json();
        if ($response->successful()) {

            return response()->json([
                "status" => true,
                "redirect" => route("method.index", $langcode)
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function show(Method $method)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function edit($langcode, Method $item)
    {
        $method = $item;
        $companies = Company::get();

        if(!$method && empty($method->id)){
            return redirect()->back()->with('error', trans("index.user_industry_phrase6"));
        }

        return view('front.user.methods.edit', compact(['method', 'companies']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function update($langcode, Method $item, MethodRequest $request)
    {
        $method = $item;
        $newReq = array_merge($request->all(), ['method_id' => $method->id]);
        $response = Http::accept('application/json')->post(route('api.method.update'), $newReq);

        $res = $response->json();

        if ($response->successful()) {

            return response()->json([
                "status" => true,
                "redirect" => route("method.index", $langcode)
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function destroy($langcode, Method $item)
    {
        $item->delete();

        return redirect(route('method.index', $langcode))->with('success','Success');
    }
}
