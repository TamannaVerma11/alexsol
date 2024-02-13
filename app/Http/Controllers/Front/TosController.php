<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\TosRequest;
use App\Models\Company;
use App\Models\Language;
use App\Models\Tos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class TosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($langcode)
    {
        $companies = Company::get();
        $tos_data = '';
        $tos_data_array = '';
        $tos_company = '';

        $language = Language::where('language_code', $langcode)->first();

        if($language && !empty($language->id)){
            if(auth()->user()->user_type == 'admin_super' || auth()->user()->user_type == 'admin_support'){
                $tos_data_array = Tos::get();
            }
            if(auth()->user()->user_type == 'company_owner' || auth()->user()->user_type == 'user'){
                $tos_data = Tos::where([['company_id', auth()->user()->company_id], ['language_id', $language->id]])->get();
                if(empty($tos_data->id)){
                    $tos_data = Tos::where('language_id', $language->id)->whereNull('company_id')->first();
                }
            }
            else{
                $tos_data = Tos::where('language_id', $language->id)->whereNull('company_id')->first();
            }
        }

        return view('front.user.tos.tos', compact(['companies', 'tos_data', 'tos_data_array', 'tos_company']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_with_comp($langcode, Request $request)
    {
        $companies = Company::get();
        $tos_data = '';
        $tos_data_array = '';
        if(isset($request->tos_company) && !empty($request->tos_company)){
            $company = Company::find($request->tos_company);

            if($company && !empty($company->id))
                $tos_company = $company;
        }

        $language = Language::where('language_code', $langcode)->first();

        if($language && !empty($language->id)){
            if(auth()->user()->user_type == 'admin_super' || auth()->user()->user_type == 'admin_support'){
                $tos_data_array = Tos::get();
            }
            if(auth()->user()->user_type == 'company_owner' || auth()->user()->user_type == 'user'){
                $tos_data = Tos::where([['company_id', auth()->user()->company_id], ['language_id', $language->id]])->get();
                if(empty($tos_data->id)){
                    $tos_data = Tos::where('language_id', $language->id)->whereNull('company_id')->first();
                }
            }
            else{
                $tos_data = Tos::where('language_id', $language->id)->whereNull('company_id')->first();
            }
        }

        return view('front.user.tos.tos', compact(['companies', 'tos_data', 'tos_data_array', 'tos_company']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($langcode, TosRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($langcode, TosRequest $request) : JsonResponse
    {
        $response = Http::accept('application/json')->post(route('api.tos.create'), $request->all());

        $res = $response->json();
        if ($response->successful()) {

            return response()->json([
                "status" => true,
                "redirect" => route("tos.index", $langcode)
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
     * @param  \App\Models\Tos  $tos
     * @return \Illuminate\Http\Response
     */
    public function show(Tos $tos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tos  $tos
     * @return \Illuminate\Http\Response
     */
    public function edit(Tos $tos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tos  $tos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tos $tos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tos  $tos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tos $tos)
    {
        //
    }
}
