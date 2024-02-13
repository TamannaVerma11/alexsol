<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketInviteRequest;
use App\Http\Requests\TicketRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\TblReportRequest;
use App\Models\TblTicketResponder;
use App\Models\Ticket;
use App\Models\TicketDeadline;
use App\Models\User;
use Carbon\Carbon;

class TicketController extends Controller
{

    public function index()
    {
        return Ticket::all();
    }

    public function show($id)
    {
        return Ticket::find($id);
    }


    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function newAnalyseStore(Request $request): JsonResponse
    {
        $report_id =  $request->request_form_id;
        $user_id = $request->user_id;

        $user = User::find($user_id);
        if($user){
            if($user->user_type == 'company_owner'){
                $item = TblReportRequest::create([
                    'company_id' => $user->company_id,
                    'permission_by' => '0',
                    'report_id' => $report_id,
                    'request_date_time' => Carbon::now(),
                ]);
            }else if($user->user_type == 'consultant'){
                $item = TblReportRequest::create([
                    'consultancy_id' => $user_id,
                    'permission_by' => '1',
                    'report_id' => $report_id,
                    'request_date_time' => Carbon::now(),
                ]);
            }
            else{
                $item = TblReportRequest::create([
                    'user_id' => $user_id,
                    'company_id' => $user->company_id,
                    'permission_by' => '0',
                    'report_id' => $report_id,
                    'request_date_time' => Carbon::now(),
                ]);
            }
            if($item){
                return response()->json([
                    'status' => 'success',
                    'req_id' => $item->id,
                    'errors' => ''
                ], 200);
            }
            return response()->json([
                'profile' => '',
                'message' => trans("index.option_server_phrase56"),
                'errors' => ''
            ], 500);
        }
        return response()->json([
            'profile' => '',
            'message' => 'You don\'t have access this page.',
            'errors' => ''
        ], 500);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(TicketRequest $request): JsonResponse
    {
        $report_id =  $request->request_form_id;
        $user_id = $request->user_id;

        if($user_id){
            $item = Ticket::create([
                'name' => $request->name,
                'summary' => $request->summary,
                'user_id' => $user_id,
                'company_id' => !empty(User::find($user_id)->company_id) ? User::find($user_id)->company_id : null,
                'status' => 'process',
            ]);
            if($item){
                $deadline = TicketDeadline::create([
                    'ticket_id' => $item->id,
                    'summary' => $item->summary,
                    'end_date' => Carbon::now()->addDays(30),
                ]);
                return response()->json([
                    'status' => 'success',
                    'ticket_id' => $item->id,
                    'errors' => ''
                ], 200);
            }
            return response()->json([
                'profile' => '',
                'message' => trans("index.option_server_phrase56"),
                'errors' => ''
            ], 500);
        }
        return response()->json([
            'profile' => '',
            'message' => 'You don\'t have access this page.',
            'errors' => ''
        ], 500);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function invite(TicketInviteRequest $request): JsonResponse
    {
        $email = htmlspecialchars($request->input('email'), ENT_QUOTES);
        $res_ticket_id = $request->input('res_ticket_id');

        $user = User::find($request->input('user_id'));
        $tbl_ticket_responder = TblTicketResponder::updateOrCreate([
            'ticket_id' => $res_ticket_id,
            'user_id' => $user->id,
        ],[
        ]);

        if ($tbl_ticket_responder) {
            $to = $email;
            $subject = trans("index.invite_subject");
            $link = route('responder', [app()->getLocale(), $res_ticket_id, $tbl_ticket_responder->id]);
            $message = trans("index.invite_message");
            $message .= trans("index.invite_greeting");
            $message = wordwrap($message,70);

            $sended = $tbl_ticket_responder->sendMessage(
                $to,
                $subject,
                $message,
                $link,
                'Answer the survey'
            );

            if($sended){
                return response()->json([
                    'profile' => $tbl_ticket_responder->toArray(),
                    'errors' => ''
                ], 200);
            }

            return response()->json([
                'profile' => $tbl_ticket_responder->toArray(),
                'message' => 'Cannot send the e-mail. Try again later.',
                'errors' => ''
            ], 500);
        } else
            return response()->json([
                'profile' => '',
                'message' => 'Sorry, cannot save data!',
                'errors' => ''
            ], 500);
    }

    public function delete(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return response()->json(null, 204);
    }

}
