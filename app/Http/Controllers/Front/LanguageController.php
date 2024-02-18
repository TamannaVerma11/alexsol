<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::get();
        return view('front.user.languages.language', compact('languages'));
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
    public function store($langcode, LanguageRequest $request) : JsonResponse
    {
      // dd(route('api.language.create'),json_encode($request->all(),true)) ;
        
      if(!empty($request->input('language_id'))){
        $language = Language::find($request->input('language_id'));
        $language->name = $request->input('name');
        $language->active = $request->input('active');
        $language->lang_default = $request->input('lang_default');
        $language->save();
    }
    else {
        $language = Language::create([
            'name' => $request->input('name'),
            'language_code' => $request->input('language_code'),
            'active' => 1,
            'lang_default' => 0
        ]);
    }



    if($language)
      return response()->json([
        "status" => true,
        "redirect" => route("language.index", $langcode)
    ]);
    else
        return response()->json([
            'profile' => '',
            'message' => 'Cannot save data. Please try again later. ',
            'errors' => ''
        ], 500);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy($langcode, Language $item)
    {
        $item->delete();

        return redirect()->back()->with('success','Success');
    }
}
