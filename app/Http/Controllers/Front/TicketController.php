<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketInviteRequest;
use App\Http\Requests\TicketRequest;
use App\Models\Category;
use App\Models\CategoryContent;
use App\Models\Company;
use App\Models\Language;
use App\Models\Method;
use App\Models\MlreportFormatContent;
use App\Models\Question;
use App\Models\QuestionDeadline;
use App\Models\QuestionMethod;
use App\Models\Report;
use App\Models\TblReportRequest;
use App\Models\TblTicketResponder;
use App\Models\Ticket;
use App\Models\TicketDeadline;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($langcode, Request $request)
    {
        $tickets = '';
        $view_process = true;
        $view_closed = true;
        $currentDate = '';

        $user = User::find(auth()->user()->id);
        if ($user->user_type == 'admin_super' || $user->user_type == 'admin_support') {
            $tickets = Ticket::orderBy('created_at', 'DESC')->get();
        } elseif ($user->user_type == 'company_owner') {
            $tickets = Ticket::where('company_id', $user->company_id)->orderBy('created_at', 'DESC')->get();
        } elseif ($user->user_type == 'user' ||  $user->user_type == 'consultant') {
            $tickets = Ticket::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        }
        if (isset($request->view) && $request->view == 'process')
            $view_closed = false;
        if (isset($request->view) && $request->view == 'closed')
            $view_process = false;

        $currentDate = Carbon::now();

        return view('front.user.ticket.tickets', compact(['tickets', 'view_closed', 'view_process', 'currentDate']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function compTicket($langcode, Company $item, Request $request)
    {
        $tickets = '';
        $view_process = true;
        $view_closed = true;
        $currentDate = '';

        $user = User::find(auth()->user()->id);
        if ($item->id == $user->company_id) {
            if ($user->user_type == 'admin_super' || $user->user_type == 'admin_support' || $user->user_type == 'consultant') {
                $tickets = Ticket::where('company_id', $item->id)->orderBy('created_at', 'DESC')->get();
            } elseif ($user->user_type == 'company_owner') {
                $tickets = Ticket::where('company_id', $user->company_id)->orderBy('created_at', 'DESC')->get();
            }
        } else return redirect()->back()->with('error', 'You cannot access this page!');

        if (isset($request->view) && $request->view == 'process')
            $view_closed = false;
        if (isset($request->view) && $request->view == 'closed')
            $view_process = false;

        $currentDate = Carbon::now();

        return view('front.user.ticket.tickets', compact(['tickets', 'view_closed', 'view_process', 'currentDate']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newAnalyse($langcode)
    {
        $report_data = '';
        $language = Language::where('language_code', $langcode)->first();
        $user = User::find(auth()->user()->id);

        if (!empty($user->id) && $language && !empty($language->id)) {
            $report_data = MlreportFormatContent::where('language_id', $language->id)->get();
            if ($user->user_type == 'user' || $user->user_type == 'consultant') {
                return view('front.user.ticket.newAnalyse', compact(['report_data']));
            } else
                return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function newAnalyseStore($langcode, Request $request): JsonResponse
    {
        $user = User::find(auth()->user()->id);
        $newReq = array_merge($request->all(), ['user_id' => $user->id]);
        $response = Http::accept('application/json')->post(route('api.ticket.newAnalyseStore'), $newReq);

        $res = $response->json();
        if ($response->successful()) {

            return response()->json([
                "status" => true,
                "redirect" => route("ticket.create", [$langcode, $response['req_id']]),
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($langcode, TblReportRequest $req_id)
    {
        $user = User::find(auth()->user()->id);

        if (!empty($user->id) && $req_id && !empty($req_id->id)) {
            if ($user->user_type == 'user' && $req_id->user_id == $user->id) {
                return view('front.user.ticket.create');
            } else if ($user->user_type == 'company_owner' && $req_id->company_id == $user->company_id) {
                return view('front.user.ticket.create');
            } else if ($user->user_type == 'consultant' && $req_id->consultant_id == $user->id) {
                return view('front.user.ticket.create');
            } else
                return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }

        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($langcode, TblReportRequest $req_id, TicketRequest $request): JsonResponse
    {
        $user = User::find(auth()->user()->id);
        $newReq = array_merge($request->all(), ['user_id' => $user->id, 'report_id' => $req_id->id]);
        $response = Http::accept('application/json')->post(route('api.ticket.store'), $newReq);

        $res = $response->json();
        if ($response->successful()) {

            return response()->json([
                "status" => true,
                "redirect" => route("ticket.intro", [$langcode, $response['ticket_id']]),
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function intro($langcode, Ticket $ticket_id)
    {
        $ticket = $ticket_id;

        $ticket_deadline = TicketDeadline::where('ticket_id', $ticket->id)->first();
        $ticket_deadline->viewed = 1;
        $ticket_deadline->emailed = 1;
        $ticket_deadline->save();

        if ($ticket_id && !empty($ticket_id->id) && $ticket_id->user_id == auth()->user()->id)
            return view('front.user.ticket.intro', compact('ticket'));

        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function question($langcode, Ticket $ticket_id, Request $request)
    {
        $ticket = $ticket_id;
        $user_edit_permission = false;
        $user_permission = false;
        $company_permission = false;
        $admin_permission = false;
        $consultant_permission = false;
        $pageNum = 0;
        $ticket_request_id = '';
        $ticket_company = Company::find($ticket->company_id);
        $ticket_user = User::find($ticket->user_id);
        $respond_tickets = '';
        $questions = '';
        $reports = '';
        $language = Language::where('language_code', app()->getLocale())->first();
        $categories = [];
        $ticket_deadline = '';
        $question_deadline = '';
        $available_categories = [];
        $active_methods = '';
        $total_selection = 0;
        $report_formats = '';
        $report_format_id = 0;

        $user = User::find(auth()->user()->id);
        if ($user->user_type == 'admin_support' || $user->user_type == 'admin_super') {
            $admin_permission = true;
        } else if ($user->user_type == 'company_owner') {
            if ($ticket->company_id == $user->company_id)
                $company_permission = true;
        } else if ($user->user_type == 'consultant') {
            $consultant_permission = true;
        } else if ($user->user_type == 'user') {
            $user_company = Company::find($user->company_id);
            if ($user_company->show_tickets && $ticket->company_id == $user_company->id)
                $user_permission = true;

            if ($ticket->status == 'process' && $ticket->user_id == auth()->user()->id) {
                $user_edit_permission = true;
            } else if ($ticket->user_id == auth()->user()->id) {
                $user_permission = true;
                if ($ticket->status == 'process')
                    $user_edit_permission = true;
            }
        }

        if (($ticket && $user && !empty($ticket->id) && $ticket->user_id == auth()->user()->id) || $admin_permission || $consultant_permission || $company_permission) {

            if (isset($request->pageNum))
                $pageNum = $request->pageNum;

            $respond_tickets = TblTicketResponder::where('ticket_id', $ticket->id)->orderBy('id', 'ASC')->get();

            $questions = Question::where('is_response', 1)->get();

            $report = Report::where([['ticket_id', $ticket->id], ['language_id', $language->id]])->first();

            $categories_data = Category::where('type', 'question')->get();
            foreach ($categories_data as $category) {
                $category_content = CategoryContent::where([['category_id', $category->id], ['language_id', $language->id]])->first();
                if ($category_content->count() < 1) {
                    $category_content = false;
                }

                if ($category_content) {
                    $category['category_name'] = $category_content->name;
                    $category['category_details'] = $category_content->details;
                }

                $single_category = [
                    'category_id' => $category['category_id'],
                    'category_name' => $category['category_name'],
                    'category_details' => $category['category_details'],
                ];
                array_push($categories, $single_category);
            }

            $ticket_deadline = TicketDeadline::where('ticket_id', $ticket->id)->first();

            $question_deadline = QuestionDeadline::where('ticket_id', $ticket->id)->get();

            $categories_ = Category::orderBy('rank', 'ASC')->get();
            $category_info = null;
            if ($categories_) {
                foreach ($categories_ as $category) {
                    $category_data = CategoryContent::where([['category_id', $category->id], ['language_id', $language->id]])->first();
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

            $methods = Method::get();
            if (strlen($ticket->methods) > 0) {
                $active_methods = json_decode($ticket->methods, true);

                foreach ($active_methods as $method_key => $method_priority) {
                    $total_selection += $method_priority;
                }
            }

            $response = $ticket->response;
            $answer_count = 0;
            if ($response) {
                $response_array = json_decode($response, true);
                foreach ($response_array as $q_id => $resp) {
                    if (isset($resp['answer']) && $resp['answer'] && !$resp['follow-up']) {
                        $answer_count++;
                    }
                }
            }

            $report_formats = MlreportFormatContent::where('language_id', $language->id)->get();

            $report_ = TblReportRequest::where('ticket_id', $ticket->id)->first();
            $report_format_id = !empty($report_->report_id) ? $report_->report_id : 0;

            $question_response = json_decode($ticket->response, true);
            return view('front.user.ticket.question', compact([
                'ticket', 'user_edit_permission', 'user_permission', 'question_response',
                'company_permission', 'admin_permission', 'pageNum', 'ticket_request_id',
                'ticket_company', 'ticket_user', 'respond_tickets', 'questions', 'report',
                'categories', 'ticket_deadline', 'question_deadline', 'available_categories',
                'active_methods', 'total_selection', 'answer_count', 'report_formats', 'report_format_id'
            ]));
        }

        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update($langcode, Ticket $item, Request $request)
    {
        $ticket = $item;
        $ticket_name = htmlspecialchars($request->ticket_name, ENT_QUOTES);
        $ticket_summary = htmlspecialchars($request->ticket_summary, ENT_QUOTES);
        $response = $request->response;
        $ticket_id = $item->id;
        $method_selection = QuestionMethod::where('is_response', 0)->get();
        $resp_array = json_decode($response, true);

        //Generate methods
        $method_array = array();
        $methods = Method::get();

        if ($methods) {
            foreach ($methods as $method) {
                $method_array[$method->id] = 0;
            }
        }

        $user_data = User::find(auth()->user()->id);

        foreach ($resp_array as $question_id => $resp) {
            $access = null;
            foreach ($method_selection as $selection) {
                if (
                    $selection->question_id == $question_id &&
                    $selection->company_id == $user_data->company_id
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
                            if (is_array($access_array)) {
                                foreach ($access_array as $method_id) {
                                    if ($method_id)
                                        $method_array[$method_id]++;
                                }
                            } else
                                $method_array[$access_array]++;
                        }
                    } else if ($resp['answer'] == 1) {
                        $access_array = json_decode($access->no);
                        if ($access_array && $access_array != null) {
                            if (is_array($access_array)) {
                                foreach ($access_array as $method_id) {
                                    if ($method_id)
                                        $method_array[$method_id]++;
                                }
                            } else
                                $method_array[$access_array]++;
                        }
                    }
                } else if ($resp['type'] == 'mcq') {
                    if ($resp['answer'] == 4 || $resp['answer'] == 4) {
                        $access_array = json_decode($access->yes);
                        if ($access_array && $access_array != null) {
                            if (is_array($access_array)) {
                                foreach ($access_array as $method_id) {
                                    if ($method_id)
                                        $method_array[$method_id]++;
                                }
                            } else
                                $method_array[$access_array]++;
                        }
                    } else if ($resp['answer'] == 1 || $resp['answer'] == 2) {
                        $access_array = json_decode($access->no);
                        if ($access_array && $access_array != null) {
                            if (is_array($access_array)) {
                                foreach ($access_array as $method_id) {
                                    if ($method_id)
                                        $method_array[$method_id]++;
                                }
                            } else
                                $method_array[$access_array]++;
                        }
                    }
                }
            }
        }

        arsort($method_array);
        $generated_method = json_encode($method_array);
        $ticket->user_id = $user_data->id;
        $ticket->company_id = $user_data->company_id;
        $ticket->name = $ticket_name;
        $ticket->summary = $ticket_summary;
        $ticket->response = $response;
        $ticket->methods = $generated_method;

        if ($ticket_id && $ticket->save()) {
            return response()->json([
                "status" => 'success',
                'ticket_id' => $ticket_id,
                "redirect" => route("ticket.question", [$langcode, $ticket->id])
            ]);
        } else {
            return response()->json([
                "status" => 'error',
                "message" => trans("index.option_server_phrase56"),
                'errors' =>  ''
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function submit($langcode, Ticket $item, Request $request)
    {
        $ticket_name = htmlspecialchars($request->ticket_name, ENT_QUOTES);
        $response = $request->response;
        $ticket_id = $request->ticket_id;
        $updated = true;
        $user_data = User::find(auth()->user()->id);
        $method_selection = QuestionMethod::where('is_response', 0)->get();
        $resp_array = json_decode($response, true);
        //Check completeness
        $total = 0;
        $answered = 0;
        foreach ($resp_array as $question_id => $resp) {
            if (!$resp['follow-up']) {
                $follow_up_type = false;
                if ((int)$resp['answer'] > 0) {
                    $answered++;
                }
                if ($resp['type'] == 'mcq') {
                    if ($resp['answer'] == 1 || $resp['answer'] == 2)
                        $follow_up_type = 'no';
                    elseif ($resp['answer'] == 4 || $resp['answer'] == 5)
                        $follow_up_type = 'yes';
                }

                if ($resp['type'] == 'yes-no') {
                    if ($resp['answer'] == 1)
                        $follow_up_type = 'no';
                    elseif ($resp['answer'] == 2)
                        $follow_up_type = 'yes';
                }

                if ($follow_up_type == 'yes') {
                    $follow_up_id = (int)$resp['yes-follow-up'];
                    if ($follow_up_id && !empty($resp_array[$follow_up_id])) {
                        if ((int)($resp_array[$follow_up_id]['answer']) > 0) {
                            $answered++;
                        }
                        $total++;
                    }
                }

                if ($follow_up_type == 'no') {
                    $follow_up_id = (int)$resp['no-follow-up'];
                    if ($follow_up_id) {
                        if ((int)$resp_array[$follow_up_id]['answer'] > 0) {
                            $answered++;
                        }
                        $total++;
                    }
                }
                $total++;
            }
        }
        $completeness = ($answered / $total) * 100;
        //Generate methods
        $method_array = array();
        $methods = Method::get();
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
                    $selection->company_id == $user_data->company_id
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
                        $access_array = explode(",", $access->yes);
                        if ($access_array) {
                            foreach ($access_array as $method_id) {
                                if ($method_id)
                                    $method_array[$method_id]++;
                            }
                        }
                    } else if ($resp['answer'] == 1) {
                        $access_array = explode(",", $access->no);
                        if ($access_array) {
                            foreach ($access_array as $method_id) {
                                if ($method_id)
                                    $method_array[$method_id]++;
                            }
                        }
                    }
                } else if ($resp['type'] == 'mcq') {
                    if ($resp['answer'] == 4 || $resp['answer'] == 4) {
                        $access_array = explode(",", $access->yes);
                        if ($access_array) {
                            foreach ($access_array as $method_id) {
                                if ($method_id)
                                    $method_array[$method_id]++;
                            }
                        }
                    } else if ($resp['answer'] == 1 || $resp['answer'] == 2) {
                        $access_array = explode(",", $access->no);
                        if ($access_array) {
                            foreach ($access_array as $method_id) {
                                if ($method_id)
                                    $method_array[$method_id]++;
                            }
                        }
                    }
                }
            }
        }
        arsort($method_array);
        $generated_method = json_encode($method_array);
        $current_time = time();
        $curent_datetime = date("Y-m-d h:i:s", $current_time);

        if ($completeness >= 100) {


            if ($ticket_id) {
                $updated = Ticket::updateOrCreate([
                    'id' => $ticket_id
                ], [
                    'user_id' => $user_data->id,
                    'company_id' => $user_data->company_id,
                    'name' => $ticket_name,
                    'response' => $response,
                    'methods' => $generated_method,
                    'status' => 'closed',
                    'close_time' => $curent_datetime
                ]);
            }
            if ($ticket_id && $updated) {
                $result = array('status' => 'success', 'url' => route('ticket.review', [$langcode, $ticket_id]), 'report_id' => $ticket_id);
                return json_encode($result);
            } else {
                $result = array('status' => 'error', 'message' => trans("index.option_server_phrase57"));
                return json_encode($result);
            }
        } else {
            $result = array('status' => 'error', 'message' => trans("index.option_server_phrase92"));
            return json_encode($result);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function revSub($langcode, Ticket $item, Request $request)
    {
        $review_text = htmlspecialchars($request->review_text, ENT_QUOTES);
        $review_status = $request->review_status;
        $ticket_id = $request->ticket_id;
        $ticket_review_status = $request->ticket_review_status;
        $updated = false;
        $data = array('review_status' => $review_status, 'review_text' => $review_text);
        $data = json_encode($data);
        if ($ticket_id) {
            $updated = Ticket::updateOrCreate([
                'id' => $ticket_id
            ], [
                'review' => $data,
                'review_status' => $ticket_review_status,
            ]);
        }
        if ($updated) {
            $result = array('status' => 'success', 'url' => route('ticket.review', [$langcode, $ticket_id]));
            echo json_encode($result);
        } else {
            $result = array('status' => 'error', 'message' => trans("index.option_server_phrase93"));
            echo json_encode($result);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function ratSub($langcode, Ticket $item, Request $request)
    {
        $rating_text_1 = htmlspecialchars($request->rating_text_1, ENT_QUOTES);
        $rating_text_2 = htmlspecialchars($request->rating_text_2, ENT_QUOTES);
        $rating_check_1 = $request->rating_check_1;
        $rating_check_2 = $request->rating_check_2;
        $rating_check_3 = $request->rating_check_3;
        $rating_check_4 = $request->rating_check_4;
        $ticket_id = $request->ticket_id;
        $ticket_rating_status = $request->ticket_rating_status;
        $updated = false;
        $data = array(
            'rating_check_1' => $rating_check_1,
            'rating_check_2' => $rating_check_2,
            'rating_check_3' => $rating_check_3,
            'rating_check_4' => $rating_check_4,
            'rating_text_1' => $rating_text_1,
            'rating_text_2' => $rating_text_2
        );
        $data = json_encode($data);
        if ($ticket_id) {
            $updated = Ticket::updateOrCreate([
                'id' => $ticket_id
            ], [
                'rating' => $data,
                'rating_status' => $ticket_rating_status,
            ]);
        }
        if ($updated) {
            $result = array('status' => 'success', 'url' => route('ticket.rating', [$langcode, $ticket_id]));
            echo json_encode($result);
        } else {
            $result = array('status' => 'error', 'message' => trans("index.option_server_phrase94"));
            echo json_encode($result);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function review($langcode, Ticket $ticket_id)
    {
        $ticket = $ticket_id;
        $user_edit_permission = false;
        $user_permission = false;
        $company_permission = false;
        $admin_permission = false;
        $consultant_permission = false;

        $user = User::find(auth()->user()->id);
        if ($user->user_type == 'admin_support' || $user->user_type == 'admin_super') {
            $admin_permission = true;
        } else if ($user->user_type == 'company_owner') {
            if ($ticket->company_id == $user->company_id)
                $company_permission = true;
        } else if ($user->user_type == 'consultant') {
            $consultant_permission = true;
        } else if ($user->user_type == 'user') {
            $user_company = Company::find($user->company_id);
            if ($user_company->show_tickets && $ticket->company_id == $user_company->id)
                $user_permission = true;

            if ($ticket->status == 'process' && $ticket->user_id == auth()->user()->id) {
                $user_edit_permission = true;
            } else if ($ticket->user_id == auth()->user()->id) {
                $user_permission = true;
                if ($ticket->status == 'process')
                    $user_edit_permission = true;
            }
        }

        if ($ticket_id && !empty($ticket_id->id) && $ticket_id->user_id == auth()->user()->id) {
            return view('front.user.ticket.review', compact('ticket', 'user_permission'));
        }
        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rating($langcode, Ticket $ticket_id)
    {
        $ticket = $ticket_id;
        $user_edit_permission = false;
        $user_permission = false;
        $company_permission = false;
        $admin_permission = false;
        $consultant_permission = false;

        $user = User::find(auth()->user()->id);
        if ($user->user_type == 'admin_support' || $user->user_type == 'admin_super') {
            $admin_permission = true;
        } else if ($user->user_type == 'company_owner') {
            if ($ticket->company_id == $user->company_id)
                $company_permission = true;
        } else if ($user->user_type == 'consultant') {
            $consultant_permission = true;
        } else if ($user->user_type == 'user') {
            $user_company = Company::find($user->company_id);
            if ($user_company->show_tickets && $ticket->company_id == $user_company->id)
                $user_permission = true;

            if ($ticket->status == 'process' && $ticket->user_id == auth()->user()->id) {
                $user_edit_permission = true;
            } else if ($ticket->user_id == auth()->user()->id) {
                $user_permission = true;
                if ($ticket->status == 'process')
                    $user_edit_permission = true;
            }
        }

        if ($ticket_id && !empty($ticket_id->id) && $ticket_id->user_id == auth()->user()->id) {
            return view('front.user.ticket.rating', compact('ticket', 'user_permission'));
        }
        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function report_main_chart($langcode, Ticket $item)
    {
        $ticket = $item;
        $question_response = json_decode($ticket->response, true);
        $questions = Question::where('is_response', 0)->get();
        return view('front.user.ticket.report_main_chart', compact(['ticket', 'question_response', 'questions']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function invite($langcode, TicketInviteRequest $request): JsonResponse
    {
        $user = User::find(auth()->user()->id);
        $newReq = array_merge($request->all(), ['user_id' => $user->id]);
        $response = Http::accept('application/json')->post(route('api.ticket.invite'), $newReq);

        $res = $response->json();
        if ($response->successful()) {
            return response()->json([
                "status" => true,
                "redirect" => route("ticket.question", [$langcode, $request->res_ticket_id]),
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
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    /**
     * Show the ticket users.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function user(Ticket $ticket)
    {
        //
    }

    /**
     * Show the pending tickets.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function pending()
    {
        $requests = TblReportRequest::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        return view('front.user.ticket.pending', compact('requests'));
    }

    /**
     * Show the summarize.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function summarize(Ticket $ticket)
    {
        //
    }

    /**
     * Activate company
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deadline($langcode, Request $request)
    {
        $ticket_id = $request->ticket_id;
        $deadline_date = date("Y-m-d", strtotime($request->deadline_date));

        $now = Carbon::now();
        $date = Carbon::createFromFormat('Y-m-d', $request->deadline_date);

        if ($date->gt($now)) {
            $deadline = TicketDeadline::updateOrCreate(['ticket_id' => $ticket_id], [
                'end_date' => $deadline_date
            ]);

            if ($deadline) {
                return response()->json([
                    "status" => true,
                    "redirect" => route("ticket.question", [$langcode, $ticket_id])
                ]);
            } else return response()->json([
                "status" => false,
                "message" => 'Cannot update!',
                'errors' =>  ''
            ]);
        } else return response()->json([
            "status" => false,
            "message" => 'The date must greater than today!',
            'errors' =>  ''
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function company($langcode, Request $request)
    {
        $report_data = '';
        $language = Language::where('language_code', $langcode)->first();
        $user = User::find(auth()->user()->id);

        if (!empty($user->id) && $language && !empty($language->id)) {
            $report_data = MlreportFormatContent::where('language_id', $language->id)->get();
            if ($user->user_type == 'company_owner' || $user->user_type == 'consultant') {
                return view('front.user.ticket.newAnalyse', compact(['report_data']));
            } else
                return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }
}
