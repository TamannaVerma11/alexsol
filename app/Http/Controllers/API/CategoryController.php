<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\CategoryContent;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function show($id)
    {
        return Category::find($id);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $category = Category::create();

        if($category){
            $categorycontent = CategoryContent::create([
                'name' => $request->input('name'),
                'language_id' => $request->input('language_id'),
                'category_id' => $category->id,
            ]);
            return response()->json([
                'profile' => $category->toArray(),
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
    public function update(CategoryRequest $request): JsonResponse
    {
        $category = Category::find($request->category_id);
        $languages = $request->input('language_ids');
        $names = $request->input('name');
        $details = $request->input('details');


        $item = null;
        if($category){
            for($i = 0; $i < count($languages); $i++)
            {
                $language = Language::find($languages[$i]);
                if($language && !empty($language->id)){
                    $item = CategoryContent::updateOrCreate([
                        'language_id' => $language->id,
                        'category_id' =>$category->id,
                    ],[
                        'name' => $names[$i],
                        'details' => $details[$i],
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
        $user = Category::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

}
