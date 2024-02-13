<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryContent;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\IndustryContent;
use App\Models\Language;
use App\Models\Method;
use App\Models\Question;
use App\Models\QuestionDeadline;
use App\Models\QuestionMethod;
use App\Models\ResponderTicketData;
use App\Models\Support;
use App\Models\TblReportRequest;
use App\Models\TblTicketResponder;
use App\Models\Ticket;
use App\Models\User;
use Cookie;

class HomeController extends Controller
{
    /* front homepage view */
    public function index($langcode)
    {
        $company_tickets = '';
        $data_process = '';
        $support_process = '';
        $report_request_process = '';
        $companies = '';

        $con_process = User::where('user_type', 'consultant')->get();
        $com_process = Company::where('status', 'active')->get();
        $com_user_process = User::where('user_type', 'user')->get();


        if (auth()->check()) {
            $user = auth()->user();
            $company_tickets = Ticket::where('company_id', $user->company_id)->get();

            $data_process = Ticket::where([['user_id', $user->id], ['status', 'process']])->get();

            $support_process = Support::where('user_id', $user->id)->get();

            $report_request_process = TblReportRequest::where([['user_id', $user->id], ['status', 0]])->get();

            if($user->company_id != null)
                $companies = User::where('company_id', $user->company_id)->get();
        }

        return view('front.user.dashboard', compact(['company_tickets', 'data_process', 'support_process',
                                        'report_request_process', 'companies', 'con_process', 'com_process',
                                        'com_user_process',
                                        ]));
    }

    /* pricing view */
    public function pricing($langcode)
    {
        return view('front.pricing');
    }

    /* two factor authentication view */
    public function tfa($langcode)
    {
        return view('front.user.tfa');
    }

    /* terms and conditions view */
    public function terms($langcode)
    {
        return view('front.tos');
    }

    /* front homepage view */
    public function login($langcode)
    {
        $industry_types = IndustryContent::get();
        $language = Language::where('language_code', $langcode)->first();
        if($language)
            $industry_types = IndustryContent::where('language_id', $language->id)->get();

        $companies = Company::get();
        return view('front.login', compact(['industry_types', 'companies']));
    }

    /* change app locale */
    public function changeLocale($langcode, Request $request)
    {

        if ($request->lang != null) {
            $language = Language::where('language_code', $request->lang)->first();
            if ($language->id != null) {
                app()->setLocale($request->lang);
                session()->put("lang", $request->lang);
                \App::setLocale($request->lang);

                Cookie::queue(Cookie::forget('lang'));
                Cookie::queue(Cookie::make('lang', "$language->language_code", 25000));

                //return $request->fullUrl();
            }
        }
    }

    /* front homepage view */
    public function responder($langcode, Ticket $ticket, TblTicketResponder $responder, Request $request)
    {
        $pageNum = 0;
        $user_permission = false;
        $user_edit_permission = true;
        $questions = null;
        $available_categories = [];
        $question_response = null;

        $language = Language::where('language_code', $langcode)->first();

        if(auth()->check()){
            $user = User::find(auth()->user()->id);
            if($user->user_type == 'user' || $user->user_type == 'admin_super'){
                $user_edit_permission = false;
            }
        }

        if(isset($request->pageNum))
            $pageNum = $request->pageNum;

        $questions = Question::where('is_response', 1)->get();

        $categories_ = Category::orderBy('rank', 'ASC')->get();
        $category_info = null;
        if($categories_){
            foreach($categories_ as $category){
                $category_data = CategoryContent::where([['category_id', $category->id],['language_id', $language->id]])->first();
                $category_info = $category_data;

                $cat_data = array(
                    'category_id' => $category->id,
                    'category_rank' => $category->rank,
                    'category_name' => $category_info->name,
                    'category_details' => html_entity_decode($category_info->details)
                );
                array_push($available_categories, $cat_data);
            }
        }

        $responder_data = ResponderTicketData::where([['ticket_id', $ticket->id], ['responder_id', $responder->id]])->first();
        if(!empty($responder_data->id))
            $question_response = json_decode($responder_data->response, true);

        $question_deadline = QuestionDeadline::where('ticket_id', $ticket->id)->get();

        return view('front.user.responder.index', compact(['pageNum', 'user_edit_permission', 'questions', 'ticket', 'question_deadline',
                                                        'available_categories', 'question_response']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function responderUpdate($langcode, Ticket $ticket, TblTicketResponder $responder, Request $request)
    {
        $response = $request->response;
        $ticket_id = $ticket->id;
        $responder_id = $responder->id;
        $method_selection = QuestionMethod::where('is_response', 1)->get();
        $resp_array = json_decode($response, true);

        //Generate methods
        $method_array = array();
        $methods = Method::get();

        $company_id = !empty($ticket->company_id) ? $ticket->company_id : Company::first()->id;
        if ($methods) {
            foreach ($methods as $method) {
                $method_array[$method->id] = 0;
            }
        }

        foreach ($resp_array as $question_id => $resp) {
            $access = null;
            foreach ($method_selection as $selection) {
                if (
                    $selection->question_id == $question_id &&
                    $selection->company_id == $company_id
                ) {
                    $access = $selection;
                    break;
                } else if ($selection->question_id == $question_id) {
                    $access = $selection;
                }
            }
            if (!$access)
                continue;
            else {
                if ($resp['type'] == 'yes-no') {
                    if ($resp['answer'] == 2) {
                        $access_array = json_decode($access->yes);
                        if ($access_array && $access_array != null) {
                            if(is_array($access_array)){
                                foreach ($access_array as $method_id) {
                                    if ($method_id)
                                        $method_array[$method_id]++;
                                }
                            }
                            else
                                $method_array[$access_array]++;
                        }
                    } else if ($resp['answer'] == 1) {
                        $access_array = json_decode($access->no);
                        if ($access_array && $access_array != null) {
                            if(is_array($access_array)){
                                foreach ($access_array as $method_id) {
                                    if ($method_id)
                                        $method_array[$method_id]++;
                                }
                            }
                            else
                                $method_array[$access_array]++;
                        }
                    }
                } else if ($resp['type'] == 'mcq') {
                    if ($resp['answer'] == 4 || $resp['answer'] == 4) {
                        $access_array = json_decode($access->yes);
                        if ($access_array && $access_array != null) {
                            if(is_array($access_array)){
                                foreach ($access_array as $method_id) {
                                    if ($method_id)
                                        $method_array[$method_id]++;
                                }
                            }
                            else
                                $method_array[$access_array]++;
                        }
                    } else if ($resp['answer'] == 1 || $resp['answer'] == 2) {
                        $access_array = json_decode($access->no);
                        if ($access_array && $access_array != null) {
                            if(is_array($access_array)){
                                foreach ($access_array as $method_id) {
                                    if ($method_id)
                                        $method_array[$method_id]++;
                                }
                            }
                            else
                                $method_array[$access_array]++;
                        }
                    }
                }
            }
        }

        arsort($method_array);
        $generated_method = json_encode($method_array);

        $responder_ticket = ResponderTicketData::updateOrCreate([
            'responder_id' => $responder_id,
            'ticket_id' => $ticket_id,
        ], [
            'response' => $response,
            'methods' => $generated_method,
            'company_id' => $company_id,
        ]);

        if ($ticket_id && $responder_ticket) {
            $ticket->response = $responder_ticket->response;
            $ticket->save();

            return response()->json([
                "status" => 'success',
                'ticket_id' => $ticket_id,
                "redirect" => route("responder", [$langcode, $ticket->id, $responder->id])
            ]);
        } else {
            return response()->json([
                "status" => 'error',
                "message" => trans("index.option_server_phrase56"),
                'errors' =>  ''
            ]);
        }
    }


    /* set app locale */
    public function setLocaleOnHomepage(Request $request)
    {
        if((Language::where('active', 1)->get())->count() > 0){
            if (Cookie::get('lang') != null)
                return redirect(Cookie::get('lang'));
            else
                return redirect(app()->getLocale());
        }
        return redirect(route('home.index', app()->getLocale()));
    }
}
