<?php

namespace App\Http\Controllers\API;

use App\HTTP\Requests\SupportRequest;
use App\HTTP\Requests\OptionRequest;
use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Support;

class SupportController extends Controller
{
    public function index()
    {
        return Support::all();
    }

    public function show($id)
    {
        return Support::find($id);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(SupportRequest $request): JsonResponse
    {
        $support = Support::create([
            'user_id' => $request->input('user_id'),
            'user_type' => $request->input('user_type'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'parent' => $request->input('support_id'),
        ]);

        if($support)
            return response()->json([
                'profile' => $support->toArray(),
                'errors' => ''
            ], 200);
        return response()->json([
            'profile' => '',
            'message' => 'Cannot add the content to the database',
            'errors' => ''
        ], 500);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function optionUpdate(OptionRequest $request): JsonResponse
    {
        $option = Option::where('key', 'support_email')->first();
        if($request->input('support_email') != null){
            if($option && !empty($option->id)){
                $option->value = $request->input('support_email');
                $option->save();
            }
            else{
                Option::create([
                    'key' => 'support_email',
                    'value' => $request->input('support_email'),
                ]);
            }
        }

        $option = Option::where('key', 'support_phone')->first();
        if($request->input('support_phone') != null){
            if($option && !empty($option->id)){
                $option->value = $request->input('support_phone');
                $option->save();
            }
            else{
                Option::create([
                    'key' => 'support_phone',
                    'value' => $request->input('support_phone')
                ]);
            }
        }

        $option = Option::where('key', 'support_address')->first();
        if($request->input('support_address') != null){
            if($option && !empty($option->id)){
                $option->value = $request->input('support_address');
                $option->save();
            }
            else{
                Option::create([
                    'key' => 'support_address',
                    'value' => $request->input('support_address')
                ]);
            }
        }

        return response()->json([
            'profile' => $option->toArray(),
            'errors' => ''
        ], 200);
    }


    public function delete(Request $request, $id)
    {
        $user = Support::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

}
