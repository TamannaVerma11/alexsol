<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\IndustryType;
use App\Http\Requests\IndustryTypeRequest;
use App\Http\Requests\IndustryUpdtRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class IndustryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($langcode)
    {
        $industries = IndustryType::get();
        return view('front.user.industries.industry', compact('industries'));
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
    public function store($langcode, IndustryTypeRequest $request) : JsonResponse
    {
        $response = Http::accept('application/json')->post(route('api.industry.create'), $request->all());

        $res = $response->json();
        if ($response->successful()) {

            return response()->json([
                "status" => true,
                "redirect" => route("industry.index", $langcode)
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
     * @param  \App\Models\IndustryType  $industryType
     * @return \Illuminate\Http\Response
     */
    public function show($langcode, IndustryType $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IndustryType  $industryType
     * @return \Illuminate\Http\Response
     */
    public function edit($langcode, IndustryType $item)
    {
        $industry = $item;
        if(!$industry && empty($industry->id)){
            return redirect()->back()->with('error', trans("index.user_industry_phrase6"));
        }

        return view('front.user.industries.edit', compact(['industry']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IndustryType  $industryType
     * @return \Illuminate\Http\Response
     */
    public function update($langcode, IndustryType $item, IndustryUpdtRequest $request)
    {
        $industry = $item;
        $newReq = array_merge($request->all(), ['industry_id' => $industry->id]);
        $response = Http::accept('application/json')->post(route('api.industry.update'), $newReq);

        $res = $response->json();
        if ($response->successful()) {

            return response()->json([
                "status" => true,
                "redirect" => route("industry.index", $langcode)
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
     * @param  \App\Models\IndustryType  $industryType
     * @return \Illuminate\Http\Response
     */
    public function destroy($langcode, IndustryType $item)
    {
        $item->delete();

        return redirect()->back()->with('success','Success');
    }
}
