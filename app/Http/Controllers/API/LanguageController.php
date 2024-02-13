<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{

    public function index()
    {
        return Language::all();
    }

    public function show($id)
    {
        return Language::find($id);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(LanguageRequest $request): JsonResponse
    {

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
                'profile' => $language->toArray(),
                'errors' => ''
            ], 200);
        else
            return response()->json([
                'profile' => '',
                'message' => 'Cannot save data. Please try again later. ',
                'errors' => ''
            ], 500);
    }

    public function delete(Request $request, $id)
    {
        $user = Language::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

}
