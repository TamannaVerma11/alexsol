<?php

namespace App\Http\Controllers\API;

use App\HTTP\Requests\PackageRequest;
use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageContent;

class PackageController extends Controller
{

    public function index()
    {
        return Package::all();
    }

    public function show($id)
    {
        return Package::find($id);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(PackageRequest $request): JsonResponse
    {
        $languages = $request->input('language_ids');
        $details = $request->input('details');
        $names = $request->input('name');

        if($request->input('package_id') > 0){
            $package = Package::find((int) $request->input('package_id'));
            $package->price = $request->input('price');
            $package->user = $request->input('user');
            $package->size_min = $request->input('size_min');
            $package->size_max = $request->input('size_max');
            $package->save();
        }
        else {
            $package = Package::create([
                'price' => $request->input('price'),
                'user' => $request->input('user'),
                'size_min' => $request->input('size_min'),
                'size_max' => $request->input('size_max'),
            ]);
        }

        for($i = 0; $i < count($languages); $i++)
        {
            $language = Language::find($languages[$i]);
            if($language && !empty($language->id)){
                if($request->input('package_id') > 0){
                    if($package){
                        $package_content = PackageContent::updateOrCreate([
                            'package_id' => $request->input('package_id'),
                        ],
                        [
                            'name' => $names[$i],
                            'details' => $details[$i],
                            'language_id' => $language->id,
                        ]);
                    }
                }
                else{
                    if($package){
                        $package_content = PackageContent::create([
                            'package_id' => $package->id,
                            'name' => $names[$i],
                            'details' => $details[$i],
                            'language_id' => $language->id,
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'profile' => $package->toArray(),
            'errors' => ''
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        $user = Package::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

}
