<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\MlreportFormatRequest;
use App\Models\ReportFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use App\HTTP\Requests\ReportFormatRequest;
use App\Models\Category;
use App\Models\Language;
use App\Models\MlreportFormat;
use App\Models\MlreportFormatContent;
use App\Models\MlreportFormatContentd;
use App\Models\TblReportRequest;
use App\Models\User;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $report_formats = MlreportFormat::orderBy('id','ASC')->get();
        return view('front.user.mreport.mreport_format', compact(['report_formats']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requests($langcode, Request $request)
    {
        $tickets = null;
        $user = User::find(auth()->user()->id);
        if($user->user_type == 'admin_super' || $user->user_type == 'admin_support'){
            if(!empty($request->status))
                $tickets = TblReportRequest::where('status', $request->status)->get();
            else
                $tickets = TblReportRequest::get();
        }
        else if($user->user_type == 'company_owner'){
            if(!empty($request->status))
                $tickets = TblReportRequest::where([['company_id', $user->company_id], ['status', $request->status]])->get();
            else
                $tickets = TblReportRequest::where([['company_id', $user->company_id]])->get();
        }
        else if($user->user_type == 'consultant'){
            if(!empty($request->status))
                $tickets = TblReportRequest::where([['permission_by', 1], ['consultancy_id', $user->id], ['status', $request->status]])->get();
        }

        return view('front.user.report.request_reports', compact(['tickets']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRequest($langcode, TblReportRequest $item)
    {
        $user = User::find(auth()->user()->id);
        $permission_by = '0';
        $userName = '';
        if ($user->user_type == 'consultant') {
            $permission_by = '1';
        }
        $ticket = TblReportRequest::where([['permission_by', $permission_by], ['id', $item->id]])->first();

        if(isset($ticket->user_id))
            $userName = User::find($ticket->user_id)->name;

        return view('front.user.report.request_report_edit', compact(['ticket', 'userName', 'item']));
    }

    /**
     * Update report request the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateRequest($langcode, TblReportRequest $item, Request $request)
    {
        $item->status = $request->status;
        if($request->status == 1)
            $item->approval_date_time = Carbon::now();
        if($item->save())
            return redirect(route('report.request', $langcode))->with('success', 'Status changed successfully.');
        else
            return redirect(route('report.request', $langcode))->with('error', 'Cannot update');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($langcode, Request $request) : JsonResponse
    {
        // Handle image upload
        $image = '';
        if ($request->hasFile('image_url') && !empty($request->file('image_url'))){
            $image = $this->imageUpload($request->image_url, '/images/report_image');
        }

        $newReq = array_merge($request->all(), ['image_url' => $image]);
        $response = Http::accept('application/json')->post(route('api.report.mlreport.store'), $newReq);

        $res = $response->json();
        if ($response->successful()) {
            return response()->json([
                "status" => true,
                "redirect" => route("report.mlreport.index", $langcode)
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
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show($langcode, MlreportFormat $item)
    {
        $report_content = null;

        $language = Language::where('language_code', $langcode)->first();
        $report = MlreportFormatContentd::where([['report_format_id', $item->id], ['language_id', $language->id]])->first();
        $reportData = MlreportFormatContent::where([['report_format_id', $item->id], ['language_id', $language->id]])->first();

        if(!empty($report->report_content))
            $report_content = json_decode($report->report_content, true);
        return view('front.user.mreport.mreport_common_composer', compact(['report', 'reportData', 'report_content', 'item']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function composerPost($langcode, MlreportFormat $item, Request $request)
    {
        $report_formats = MlreportFormatContentd::where('report_format_id', $item->id)->get();
        $count = 0;
        foreach ($report_formats as $key => $report_format) {
            $report_format->report_content = json_encode($request->all());
            if($report_format->save())
                $count++;
        }
        if ($count == $report_formats->count()) {
            return response()->json([
                "status" => true,
                "redirect" => route("report.mlreport.composer", [$langcode, $item->id])
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => 'Cannot update',
            'errors' =>  ''
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit($langcode, MlreportFormat $item)
    {
        $report_format = $item;

        if(!$report_format && empty($report_format->id)){
            return redirect()->back()->with('error', trans("index.user_industry_phrase6"));
        }

        return view('front.user.mreport.edit', compact(['report_format']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update($langcode, MlreportFormat $item, MlreportFormatRequest $request)
    {
        $images = array();

        $formats = MlreportFormatContent::where('report_format_id', $item->id)->get();

        //die(var_dump($request->file('report_image')));
        foreach ($formats as $key => $format) {
            $image = '';
            if ($request->hasFile('report_image') && !empty($request->file('report_image')[$key])){
                $image = $this->imageUpload($request->file('report_image')[$key], '/images/mlreport_image');
                if ( isset($format->report_image) && !empty($format->report_image) && is_file($format->report_image))
                    unlink($format->report_image);
            }
            else
                $image = $format->report_image;

            array_push($images, $image);
        }

        $newReq = array_merge($request->all(), ['mlreport_id' => $item->id,'report_image' => $images]);
        $response = Http::accept('application/json')->post(route('api.report.mlreport.update'), $newReq);
        $res = $response->json();
        if ($response->successful()) {
            return response()->json([
                "status" => true,
                "redirect" => route("report.mlreport.edit", [$langcode, $item->id])
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
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy($langcode, MlreportFormat $item)
    {
        $item->delete();
        return redirect()->back()->with('success','Success');
    }


    /**
     * Show update password form
     * @return view
     */
    public function format ($langcode)
    {
        $report_formats = ReportFormat::orderBy('id', 'ASC')->get();

        return view('front.user.report.report_format', compact('report_formats'));
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function formatStore($langcode, ReportFormatRequest $request): JsonResponse
    {
        // Handle image upload
        $image = '';
        if ($request->hasFile('image_url') && !empty($request->file('image_url'))){
            $image = $this->imageUpload($request->image_url, '/images/report_image');
        }

        $newReq = array_merge($request->all(), ['image_url' => $image]);
        $response = Http::accept('application/json')->post(route('api.report.format'), $newReq);

        $res = $response->json();
        if ($response->successful()) {
            return response()->json([
                "status" => true,
                "redirect" => route("report.format", $langcode)
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => $res['message'],
            'errors' =>  $res['errors'] ?? ''
        ]);
    }

    /**
     * Show update password form
     * @return view
     */
    public function formatShow ($langcode, ReportFormat $item)
    {
        if($item && !empty($item->id)){
            $report_format = $item;
            $language = Language::find($item->language_id);
            return view('front.user.report.report_format_show', compact('report_format', 'language'));
        }
        return redirect()->back();
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function formatUpdate($langcode, ReportFormat $item, ReportFormatRequest $request): JsonResponse
    {
        // Handle image upload
        $image = '';
        if ($request->hasFile('image_url') && !empty($request->file('image_url'))){
            $image = $this->imageUpload($request->file('image_url'), '/images/report_image');
            //Remove the old image (New image uploaded)
            if ( isset($item->image_url) && !empty($item->image_url) && is_file($item->image_url))
                unlink($item->image_url);
        }
        else
            $image = $item->image_url;

        $newReq = array_merge($request->all(), ['format_id' => $item->id,'image_url' => $image]);

        $response = Http::accept('application/json')->post(route('api.report.format.update'), $newReq);

        $res = $response->json();
        if ($response->successful()) {
            return response()->json([
                "status" => true,
                "redirect" => route("report.format.show", [$langcode, $item->id])
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function formatDestroy($langcode, ReportFormat $item)
    {
        $item->delete();
        return redirect()->back()->with('success','Success');
    }


    /**
     * Show update password form
     * @return view
     */
    public function composer($langcode, ReportFormat $item)
    {
        $report_content = '';
        $categories  = '';

        if(!$item && empty($item->id))
            return redirect()->back()->with('error', trans("index.user_composer_phrase1"));

        $report_content = json_decode($item->content, true);
        $report = $item;
        $categories = Category::where('type', 'question')->get();

        return view('front.user.report.report_format_composer', compact(['report_content', 'report', 'categories', 'item']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function composerStore($langcode, ReportFormat $item, Request $request)
    {
        $report = ReportFormat::find($item->id);

        $report->content = json_encode($request->all());
        if($report->save())
            return response()->json([
                "status" => true,
                'report' => json_encode($request->all()),
                "redirect" => route("report.composer", [$langcode, $item->id])
            ]);
        return response()->json([
            "status" => false,
            "message" => 'Cannot save',
            'errors' =>  ''
        ]);
    }

    // Upload post image
    public function imageUpload($img, $prefix)
    {
        $imgName    = md5(time() . $img->getClientOriginalName()) . '.' . $img->getClientOriginalExtension();
        $upload     = $img->move(public_path('/' . $prefix), $imgName);

        if ($upload) {
            $img    = $prefix . '/' . $imgName;
            return $img;
        } else
            return '';
    }
}
