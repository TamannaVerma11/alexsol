<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\QuestionContent;
use App\Models\QuestionMethod;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return Question::all();
    }

    public function show($id)
    {
        return Question::find($id);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $question = Question::create([
            'is_response' => $request->input('is_response'),
        ]);

        if($question){
            $questioncontent = QuestionContent::create([
                'name' => $request->input('name'),
                'language_id' => $request->input('language_id'),
                'question_id' => $question->id,
                'is_response' => $request->input('is_response'),
            ]);
            return response()->json([
                'profile' => $question->toArray(),
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
    public function update(QuestionRequest $request): JsonResponse
    {
        $question = Question::find($request->question_id);
        $languages = $request->input('language_ids');
        $names = $request->input('name');
        $tips_yes = $request->input('tips_yes');
        $tips_no = $request->input('tips_no');
        $option1 = $request->input('option1');
        $option2 = $request->input('option2');
        $option3 = $request->input('option3');
        $option4 = $request->input('option4');
        $option5 = $request->input('option5');
        $option6 = $request->input('option6');

        $item = null;
        if($question){
            if(!empty($request->input('tips'))){
                if($request->input('tips') == 'yes')
                    $question->tip_on_yes = 1;
                if($request->input('tips') == 'no')
                    $question->tip_on_no = 1;
            }
            $question->category_id = $request->input('category_id');
            $question->type = $request->input('type');
            $question->follow_up = $request->input('follow_up');
            $question->yes_follow_up = $request->input('yes_follow_up');
            $question->no_follow_up = $request->input('no_follow_up');
            $question->weight_yes = $request->input('weight_yes');
            $question->weight_no = $request->input('weight_no');
            $question->is_response = $request->input('is_response');
            $question->save();

            if(!empty($request->yes_access)){
                $questionMethod = QuestionMethod::updateOrCreate([
                    'question_id' =>$question->id,
                ],[
                    'yes' => json_encode($request->yes_access),
                    'company_id' => !empty($request->company_id) ? : null,
                    'is_response' => $request->input('is_response'),
                ]);
            }

            if(!empty($request->no_access)){
                $questionMethod = QuestionMethod::updateOrCreate([
                    'question_id' =>$question->id,
                ],[
                    'no' => json_encode($request->no_access),
                    'company_id' => !empty($request->company_id) ? : null,
                    'is_response' => $request->input('is_response'),
                ]);
            }

            for($i = 0; $i < count($languages); $i++)
            {
                $language = Language::find($languages[$i]);
                if($language && !empty($language->id)){
                    $item = QuestionContent::updateOrCreate([
                        'language_id' => $language->id,
                        'question_id' =>$question->id,
                    ],[
                        'name' => $names[$i],
                        'tips_yes' => (!empty($tips_yes[$i]) ? $tips_yes[$i] : ''),
                        'tips_no' =>  (!empty($tips_no[$i]) ? $tips_no[$i] : ''),
                        'option1' => (!empty($option1[$i]) ? $option1[$i] : ''),
                        'option2' => (!empty($option2[$i]) ? $option2[$i] : ''),
                        'option3' => (!empty($option3[$i]) ? $option3[$i] : ''),
                        'option4' => (!empty($option4[$i]) ? $option4[$i] : ''),
                        'option5' => (!empty($option5[$i]) ? $option5[$i] : ''),
                        'option6' => (!empty($option6[$i]) ? $option6[$i] : ''),
                        'is_response' => $request->input('is_response'),
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
        $user = Question::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

}
