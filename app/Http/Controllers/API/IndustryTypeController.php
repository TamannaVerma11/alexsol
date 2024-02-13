<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndustryTypeRequest;
use App\Http\Requests\IndustryUpdtRequest;
use App\Models\IndustryType;
use App\Models\IndustryContent;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndustryTypeController extends Controller
{
    public function index()
    {
        return IndustryType::all();
    }

    public function show($id)
    {
        return IndustryType::find($id);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(IndustryTypeRequest $request): JsonResponse
    {
        $industry = IndustryType::create([
            'name' => $request->input('name'),
        ]);

        if($industry){
            $industry = IndustryContent::create([
                'name' => $request->input('name'),
                'language_id' => $request->input('language_id'),
                'industry_id' => $industry->id,
            ]);
            return response()->json([
                'profile' => $industry->toArray(),
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
    public function update(IndustryUpdtRequest $request): JsonResponse
    {
        $industry = IndustryType::find($request->industry_id);
        $languages = $request->input('language_ids');
        $details = $request->input('details');
        $names = $request->input('name');

        $item = null;
        if($industry){
            for($i = 0; $i < count($languages); $i++)
            {
                $language = Language::find($languages[$i]);
                if($language && !empty($language->id)){
                    $item = IndustryContent::updateOrCreate([
                        'language_id' => $language->id,
                        'industry_id' => $industry->id,
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
        $user = IndustryType::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

}
