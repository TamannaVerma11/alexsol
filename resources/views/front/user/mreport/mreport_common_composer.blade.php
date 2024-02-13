@extends('front.user.layouts.app')

@section('content')
    <div class="row user-content-row">
        <div class="col-12 creport-dcomposer">
            <div class="report-composer-widget-title">Common report composer</div>
            <div class="row user-content-row">
                <div class="col-12">
                    <form action="{{ route('report.mlreport.composer.post', ['lang' => app()->getLocale(), $item->id]) }}"
                        method="POST" id="composerReportAjax">
                        @csrf
                        <div class="accordion" id="composer_accordion">
                            <!-- Front page -->
                            <div class="card">
                                <div class="card-header" id="composer_frontpage_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="front_page" id="frontpage_check" {{ ($report_content && $report_content['front_page']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#front_page" aria-expanded="true" aria-controls="front_page">
                                        {{ trans("index.pdf_text1") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="front_page" class="collapse show" aria-labelledby="composer_frontpage_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" value="username" id="composer_username" {{ ($report_content && $report_content['front_page']['username'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_username">
                                                {{ trans('index.pdf_text1a') }}
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" value="company_name" id="composer_company_name" {{ ($report_content && $report_content['front_page']['company_name'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_company_name">
                                                {{ trans('index.pdf_text1b') }}
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" value="company_logo" id="composer_company_logo" {{ ($report_content && $report_content['front_page']['logo'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_company_logo">
                                                {{ trans('index.pdf_text1c') }}
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" value="ticket_id" id="composer_ticket_id" {{ ($report_content && $report_content['front_page']['ticket_id'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_ticket_id">
                                                {{ trans('index.pdf_text1d') }}
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" value="page_break1" id="composer_page_break1" {{ ($report_content && !$report_content['front_page']['page_break1']) ? '' : 'checked' }}>
                                            <label class="form-check-label" for="composer_page_break1">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Free Text 1 -->

                            <div class="card">
                                <div class="card-header" id="composer_freetext1_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text_1" id="free_text1_check" {{ ($report_content && $report_content['free_text1']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_1" aria-expanded="true" aria-controls="free_text_1">
                                            {{ trans("index.pdf_text2") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_1" class="collapse" aria-labelledby="composer_freetext1_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_1" class="form-control composer-text">{{ ($report_content && $report_content['free_text1']['text']) ? $report_content['free_text1']['text'] : trans("index.dt_composer_text_1") }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break2" id="composer_page_break2" {{ ($report_content && $report_content['free_text1']['page_break2'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break2">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Start Page Text -->
                            <div class="card">
                                <div class="card-header" id="composer_introtext_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="intro_text" id="intro_text_check" {{ ($report_content && $report_content['intro_text']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#intro_text" aria-expanded="true" aria-controls="intro_text">
                                            {{ trans("index.pdf_text3") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="intro_text" class="collapse" aria-labelledby="composer_introtext_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <?php $dtcomp2 = trans("index.dt_composer_text_2") ?>
                                            <textarea id="composer_text_2" class="form-control composer-text">{{ ($report_content && $report_content['intro_text']['text']) ? $report_content['intro_text']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break3" id="composer_page_break3" {{ ($report_content && !$report_content['intro_text']['page_break3']) ? '' : 'checked' }}>
                                            <label class="form-check-label" for="composer_page_break3">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Free Text 2 -->

                            <div class="card">
                                <div class="card-header" id="composer_freetext2_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text_2" id="free_text2_check" {{ ($report_content && $report_content['free_text2']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_2" aria-expanded="true" aria-controls="free_text_2">
                                            {{ trans("index.pdf_text4") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_2" class="collapse" aria-labelledby="composer_freetext2_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_3" class="form-control composer-text">{{ ($report_content && $report_content['free_text2']['text']) ? $report_content['free_text2']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break4" id="composer_page_break4" {{ ($report_content && $report_content['free_text2']['page_break4'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break2">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Free Text 3 -->
                            <div class="card">
                                <div class="card-header" id="composer_freetext3_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text3" id="free_text3_check" {{ ($report_content && $report_content['free_text3']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_3" aria-expanded="true" aria-controls="free_text_3">
                                            {{ trans("index.pdf_text5") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_3" class="collapse" aria-labelledby="composer_freetext3_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_4" class="form-control composer-text">{{ ($report_content && $report_content['free_text3']['text']) ? $report_content['free_text3']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break5" id="composer_page_break5" {{ ($report_content && $report_content['free_text3']['page_break5'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break6">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Free Text 4 -->
                            <div class="card">
                                <div class="card-header" id="composer_freetext4_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text4" id="free_text4_check" {{ ($report_content && $report_content['free_text4']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_4" aria-expanded="true" aria-controls="free_text_4">
                                            {{ trans("index.pdf_text6") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_4" class="collapse" aria-labelledby="composer_freetext4_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_5" class="form-control composer-text">{{ ($report_content && $report_content['free_text4']['text']) ? $report_content['free_text4']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break6" id="composer_page_break6" {{ ($report_content && $report_content['free_text4']['page_break6'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break6">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Free Text 5 -->
                            <div class="card">
                                <div class="card-header" id="composer_freetext5_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text5" id="free_text5_check" {{ ($report_content && $report_content['free_text5']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_5" aria-expanded="true" aria-controls="free_text_5">
                                            {{ trans("index.pdf_text7") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_5" class="collapse" aria-labelledby="composer_freetext5_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_6" class="form-control composer-text">{{ ($report_content && $report_content['free_text5']['text']) ? $report_content['free_text5']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break7" id="composer_page_break7" {{ ($report_content && $report_content['free_text5']['page_break7'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break7">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Free Text 6 -->
                            <div class="card">
                                <div class="card-header" id="composer_freetext6_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text6" id="free_text6_check" {{ ($report_content && $report_content['free_text6']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_6" aria-expanded="true" aria-controls="free_text_6">
                                            {{ trans("index.pdf_text8") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_6" class="collapse" aria-labelledby="composer_freetext6_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_7" class="form-control composer-text">{{ ($report_content && $report_content['free_text6']['text']) ? $report_content['free_text6']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break8" id="composer_page_break8" {{ ($report_content && $report_content['free_text6']['page_break8'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break8">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Free Text 7 -->
                            <div class="card">
                                <div class="card-header" id="composer_freetext7_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text7" id="free_text7_check" {{ ($report_content && $report_content['free_text7']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_7" aria-expanded="true" aria-controls="free_text_7">
                                            {{ trans("index.pdf_text9") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_7" class="collapse" aria-labelledby="composer_freetext7_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_8" class="form-control composer-text">{{ ($report_content && $report_content['free_text7']['text']) ? $report_content['free_text7']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break9" id="composer_page_break9" {{ ($report_content && $report_content['free_text7']['page_break9'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break9">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Free Text 8 -->
                            <div class="card">
                                <div class="card-header" id="composer_freetext8_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text8" id="free_text8_check" {{ ($report_content && $report_content['free_text8']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_8" aria-expanded="true" aria-controls="free_text_8">
                                            {{ trans("index.pdf_text10") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_8" class="collapse" aria-labelledby="composer_freetext8_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_9" class="form-control composer-text">{{ ($report_content && $report_content['free_text8']['text']) ? $report_content['free_text8']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break10" id="composer_page_break10" {{ ($report_content && $report_content['free_text8']['page_break10'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break10">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Free Text 9 -->
                            <div class="card">
                                <div class="card-header" id="composer_freetext9_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text9" id="free_text9_check" {{ ($report_content && $report_content['free_text9']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_9" aria-expanded="true" aria-controls="free_text_9">
                                            {{ trans("index.pdf_text11") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_9" class="collapse" aria-labelledby="composer_freetext9_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_10" class="form-control composer-text">{{ ($report_content && $report_content['free_text9']['text']) ? $report_content['free_text9']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break11" id="composer_page_break11" {{ ($report_content && $report_content['free_text9']['page_break11'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break11">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Free Text 10 -->
                            <div class="card">
                                <div class="card-header" id="composer_freetext10_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text10" id="free_text10_check" {{ ($report_content && $report_content['free_text10']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_10" aria-expanded="true" aria-controls="free_text_10">
                                            {{ trans("index.pdf_text11a") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_10" class="collapse" aria-labelledby="composer_freetext10_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_11" class="form-control composer-text">{{ ($report_content && $report_content['free_text10']['text']) ? $report_content['free_text10']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break12" id="composer_page_break12" {{ ($report_content && $report_content['free_text10']['page_break12'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break12">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Free Text 11 -->
                            <div class="card">
                                <div class="card-header" id="composer_freetext11_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text11" id="free_text11_check" {{ ($report_content && $report_content['free_text11']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_11" aria-expanded="true" aria-controls="free_text_11">
                                            {{ trans("index.pdf_text11b") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_11" class="collapse" aria-labelledby="composer_freetext11_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_12" class="form-control composer-text">{{ ($report_content && $report_content['free_text11']['text']) ? $report_content['free_text11']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break13" id="composer_page_break13" {{ ($report_content && $report_content['free_text11']['page_break13'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break13">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Free Text 12 -->
                            <div class="card">
                                <div class="card-header" id="composer_freetext12_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text12" id="free_text12_check" {{ ($report_content && $report_content['free_text12']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_12" aria-expanded="true" aria-controls="free_text_12">
                                            {{ trans("index.pdf_text11c") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_12" class="collapse" aria-labelledby="composer_freetext12_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_13" class="form-control composer-text">{{ ($report_content && $report_content['free_text12']['text']) ? $report_content['free_text12']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break14" id="composer_page_break14" {{ ($report_content && $report_content['free_text12']['page_break14'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break14">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Free Text 13 -->
                            <div class="card">
                                <div class="card-header" id="composer_freetext13_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text13" id="free_text13_check" {{ ($report_content && $report_content['free_text13']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_13" aria-expanded="true" aria-controls="free_text_13">
                                            {{ trans("index.pdf_text11d") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_13" class="collapse" aria-labelledby="composer_freetext12_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_14" class="form-control composer-text">{{ ($report_content && $report_content['free_text13']['text']) ? $report_content['free_text13']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break15" id="composer_page_break15" {{ ($report_content && $report_content['free_text13']['page_break15'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break15">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Free Text 14 -->
                            <div class="card">
                                <div class="card-header" id="composer_freetext14_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text14" id="free_text14_check" {{ ($report_content && $report_content['free_text14']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_14" aria-expanded="true" aria-controls="free_text_14">
                                        {{ trans("index.pdf_text12") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_14" class="collapse" aria-labelledby="composer_freetext14_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_15" class="form-control composer-text">{{ ($report_content && $report_content['free_text14']['text']) ? $report_content['free_text14']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break16" id="composer_page_break16" {{ ($report_content && $report_content['free_text14']['page_break16'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break16">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Radar Graph Free Text 15 -->
                            <div class="card">
                                <div class="card-header" id="composer_freetext15_heading">
                                    <div style="padding: 30px 0px 30px 15px;">
                                        <input class="form-check-input section-checker" type="checkbox" value="free_text15" id="free_text15_check" {{ ($report_content && is_array($report_content) && !empty($report_content['free_text15']) && $report_content['free_text15']['enabled'] == 'true') ? 'checked' : '' }}>
                                        <h3 class="accordion-heading mb-0" data-toggle="collapse" data-target="#free_text_15" aria-expanded="true" aria-controls="free_text_15">
                                        {{ trans("index.pdf_text13") }}
                                        </h3>
                                    </div>
                                </div>

                                <div id="free_text_15" class="collapse" aria-labelledby="composer_freetext15_heading" data-parent="#composer_accordion">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea id="composer_text_16" class="form-control composer-text">{{ ($report_content && is_array($report_content) && !empty($report_content['free_text15']) && $report_content['free_text15']['text']) ? $report_content['free_text15']['text'] : "" }}</textarea>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="page_break17" id="composer_page_break17" {{ ($report_content && is_array($report_content) && !empty($report_content['free_text15']) && $report_content['free_text15']['page_break17'] == 'true') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="composer_page_break17">
                                                {{ trans('index.pdf_page_break') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <br>
                        <button type="submit" id="save_mlreport_common_format" class="btn btn-success">{{ trans('index.user_composer_phrase24') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
