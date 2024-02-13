<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Support;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SupportRequest;
use App\Http\Requests\OptionRequest;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($langcode)
    {
        $options = '';
        $support_info = [];
        $support_request = '';
        $request_data = '';
        $user = User::find(auth()->user()->id);

        $options = Option::get();

        if($options && !empty($options)){
            foreach($options as $option){
                if(strpos($option->key, 'support') !== false){
                    $support_info[$option->key] = $option->value;
                }
            }
        }

        if ($user->user_type == 'admin_super' || $user->user_type == 'admin_support'){
            $support_request = Support::where('parent', null)->orderBy('created_at', 'DESC')->get();
        }
        else{
            $request_data = Support::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
            if($request_data && !empty($request_data)){
                $support_request = array();
                foreach ($request_data as $key => $request) {
                    if( !$request->parent && ($request->user_type == 'user' || $request->user_type == 'company_owner'))
                        array_push($support_request, $request);
                }
            }
        }

        return view('front.user.support.index', compact(['options', 'support_info', 'support_request', 'request_data']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($langcode, SupportRequest $request) : JsonResponse
    {
        $user = User::find(auth()->user()->id);
        $newReq = array_merge($request->all(), ['user_id' => $user->id, 'user_type' => $user->user_type]);
        $response = Http::accept('application/json')->post(route('api.support.create'), $newReq);

        $res = $response->json();
        if ($response->successful()) {

            return response()->json([
                "status" => true,
                "redirect" => route("support.index", $langcode)
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
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function show($langcode, Support $item)
    {
        $support = $item;
        if($support && !empty($support->id)){
            $hasAccess = false;
            $user = User::find(auth()->user()->id);
            if ($support->parent == null || empty($support->parent)){
                if ($user->user_type == 'admin_super' || $user->user_type == 'admin_support'){
                    $hasAccess = true;
                }
                elseif($user->user_type == 'company_owner' && $support->user_type == 'company_owner' && $support->user_id == $user->id){
                    $hasAccess = true;
                }
                elseif ($user->user_type == 'user' && $support->user_id == $user->id){
                    $hasAccess = true;
                }
            }

            if(!$hasAccess)
                return redirect()->back()->with('error','You don\'t have access of this page');

            $replies = Support::where('parent', $support->id)->orderBy('created_at', 'ASC')->get();
            return view('front.user.support.edit', compact(['support', 'replies']));
        }

        return redirect()->back();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function optionUpdate($langcode, OptionRequest $request) : JsonResponse
    {
        $response = Http::accept('application/json')->post(route('api.support.option.update'), $request->all());

        $res = $response->json();
        if ($response->successful()) {

            return response()->json([
                "status" => true,
                "redirect" => route("support.index", $langcode)
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reply($langcode, SupportRequest $request) : JsonResponse
    {
        $user = User::find(auth()->user()->id);
        $newReq = array_merge($request->all(), ['user_id' => $user->id, 'user_type' => $user->user_type]);
        $response = Http::accept('application/json')->post(route('api.support.create'), $newReq);

        $res = $response->json();
        if ($response->successful()) {

            return response()->json([
                "status" => true,
                "redirect" => route("support.index", $langcode)
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Support $support)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function destroy(Support $support)
    {
        //
    }
}
