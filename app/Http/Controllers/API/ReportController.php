<?php

namespace App\Http\Controllers\API;

use App\HTTP\Requests\ReportFormatRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\MlreportFormatRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\MlreportFormat;
use App\Models\MlreportFormatContent;
use App\Models\ReportFormat;

class ReportController extends Controller
{

    public function index()
    {
        return ReportFormat::all();
    }

    public function show($id)
    {
        return ReportFormat::find($id);
    }



    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function formatStore(ReportFormatRequest $request): JsonResponse
    {
        $language = Language::where('language_code', app()->getLocale())->first();
        if($language && !empty($language->id)){
            $report_format = ReportFormat::create([
                'name' => $request->name,
                'description' => $request->description,
                'content' => $request->content,
                'image_url' => $request->image_url,
                'language_id' => $language->id,
            ]);
            if(!$report_format)
                return response()->json([
                    'profile' => '',
                    'message' => 'Cannot add the content to the database',
                    'errors' => ''
                ], 500);
            return response()->json([
                'profile' => $report_format->toArray(),
                'errors' => '',
                'message' => 'Created'
            ], 200);
        }
        else return response()->json([
            'profile' => '',
            'message' => 'Language has wrong',
            'errors' => ''
        ], 500);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function formatUpdate(ReportFormatRequest $request): JsonResponse
    {
        $report_format = ReportFormat::find($request->format_id);

        $report_format->name = $request->name;
        $report_format->description = $request->description;
        $report_format->content = $request->content;
        $report_format->image_url = $request->image_url;

        if(!$report_format->save())
            return response()->json([
                'profile' => '',
                'message' => 'Cannot update the profile. Please try again later. ',
                'errors' => ''
            ], 500);
        return response()->json([
            'profile' => $report_format->toArray(),
            'errors' => '',
            'message' => 'Updated'
        ], 200);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $mreport = MlreportFormat::create([
            'status' => 1,
        ]);

        if($mreport){
            $questioncontent = MlreportFormatContent::create([
                'report_title' => $request->input('report_title'),
                'language_id' => $request->input('language_id'),
                'report_format_id' => $mreport->id,
            ]);
            return response()->json([
                'profile' => $mreport->toArray(),
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
    public function update(MlreportFormatRequest $request): JsonResponse
    {
        $mreport = MlreportFormat::find($request->mlreport_id);
        $languages = $request->input('language_ids');
        $titles = $request->input('report_title');
        $descs = $request->input('report_desc');
        $images = $request->input('report_image');

        $item = null;
        if($mreport){
            for($i = 0; $i < count($languages); $i++)
            {
                $language = Language::find($languages[$i]);
                if($language && !empty($language->id)){
                    $item = MlreportFormatContent::updateOrCreate([
                        'language_id' => $language->id,
                        'report_format_id' =>$mreport->id,
                    ],[
                        'report_title' => $titles[$i],
                        'report_desc' => $descs[$i],
                        'report_image' => $images[$i],
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
        $user = ReportFormat::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

}
