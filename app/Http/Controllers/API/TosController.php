<?php

namespace App\Http\Controllers\API;

use App\HTTP\Requests\TosRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Tos;

class TosController extends Controller
{
    public function index()
    {
        return Tos::all();
    }

    public function show($id)
    {
        return Tos::find($id);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function update(TosRequest $request): JsonResponse
    {
        $languages = $request->input('language_ids');
        $contents = $request->input('content');

        for($i = 0; $i < count($languages); $i++)
        {
            $language = Language::find($languages[$i]);
            if($language && !empty($language->id)){
                $item = Tos::updateOrCreate([
                    'language_id' => $language->id,
                ],[
                    'company_id' => $request->input('company_id'),
                    'content' => $contents[$i],
                ]);
            }
        }
        if($item){
            return response()->json([
                'profile' => $item->toArray(),
                'errors' => ''
            ], 200);
        }
    }


    public function delete(Request $request, $id)
    {
        $user = Tos::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

}
