<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Method;
use App\Models\QuestionMethod;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($langcode)
    {
        $questions = Question::where('is_response', '!=', 1)->get();
        $companies = Company::get();
        $is_response = 0;
        return view('front.user.questions.question', compact(['questions', 'companies', 'is_response']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function responder($langcode)
    {
        $questions = Question::where('is_response', 1)->get();
        $companies = Company::get();
        $is_response = 1;
        return view('front.user.questions.question', compact(['questions', 'companies', 'is_response']));
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
    public function store($langcode, Request $request) : JsonResponse
    {
        $response = Http::accept('application/json')->post(route('api.question.create'), $request->all());

        $res = $response->json();
        if ($response->successful()) {
            if($request->is_response)
                $redirect = route("question.responder.index", $langcode);
            else
                $redirect = route("question.index", $langcode);
            return response()->json([
                "status" => true,
                "redirect" => $redirect,
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
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit($langcode, Question $item)
    {
        $question = $item;
        $question_access = QuestionMethod::where('question_id', $question->id)->first();
        $yes_access = '';
        $no_access = '';

        if(!$question && empty($question->id)){
            return redirect()->back()->with('error', trans("index.user_industry_phrase6"));
        }

        if($question_access){
            $yes_access = json_decode($question_access->yes);
            $no_access = json_decode($question_access->no);
        }

        $categories = Category::where('type', 'question')->get();

        $methods = Method::get();

        $follow_up_questions = Question::where('follow_up', 1)->get();

        $is_response = $item->is_response;

        return view('front.user.questions.edit', compact(['question', 'yes_access', 'no_access', 'categories',
                                                        'methods', 'follow_up_questions', 'is_response']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update($langcode, Question $item, QuestionRequest $request)
    {
        $question = $item;
        $newReq = array_merge($request->all(), ['question_id' => $question->id]);
        $response = Http::accept('application/json')->post(route('api.question.update'), $newReq);

        $res = $response->json();
        if ($response->successful()) {

            return response()->json([
                "status" => true,
                "redirect" => route("question.index", $langcode)
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($langcode, Question $item)
    {
        $item->delete();

        return redirect(route('question.index', $langcode))->with('success','Success');
    }
}
