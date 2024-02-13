<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MethodRequest;
use App\Models\Method;
use App\Models\MethodContent;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MethodController extends Controller
{
    public function index()
    {
        return Method::all();
    }

    public function show($id)
    {
        return Method::find($id);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $method = Method::create();

        if($method){
            $methodcontent = MethodContent::create([
                'name' => $request->input('name'),
                'language_id' => $request->input('language_id'),
                'method_id' => $method->id,
            ]);
            return response()->json([
                'profile' => $method->toArray(),
                'errors' => ''
            ], 200);
        }
        else
            return response()->json([
                'profile' => '',
                'message' => 'Cannot save data. Please try again later. ',
                'errors' => ''
            ], 500);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function update(MethodRequest $request): JsonResponse
    {
        $method = Method::find($request->method_id);
        $languages = $request->input('language_ids');
        $details = $request->input('details');
        $names = $request->input('name');

        $item = null;
        if($method){
            $method->color = $request->input('color');
            $method->company_id = $request->input('company_id');
            $method->restriction = $request->input('restriction');
            $method->save();
            for($i = 0; $i < count($languages); $i++)
            {
                $language = Language::find($languages[$i]);
                if($language && !empty($language->id)){
                    $item = MethodContent::updateOrCreate([
                        'language_id' => $language->id,
                        'method_id' =>$method->id
                    ],[
                        'details' => $details[$i],
                        'name' => $names[$i],
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
        else
            return response()->json([
                'profile' => '',
                'message' => 'Cannot save data. Please try again later. ',
                'errors' => ''
            ], 500);
    }

    public function delete(Request $request, $id)
    {
        $user = Method::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

}
