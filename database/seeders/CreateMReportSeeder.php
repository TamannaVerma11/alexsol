<?php

namespace Database\Seeders;

use App\Models\MlreportFormat;
use App\Models\MlreportFormatContent;
use App\Models\MlreportFormatContentd;
use Illuminate\Database\Seeder;

class CreateMReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $report_format = MlreportFormat::create([
            'status' => 1,
        ]);
        MlreportFormatContent::create([
            'report_format_id' => $report_format->id,
            'report_title' => 'Main Report',
            'report_desc' => '&lt;p&gt;MainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMainMain1&lt;/p&gt;',
            'report_image' => 'example.png',
            'language_id' => 1,
        ]);
        MlreportFormatContent::create([
            'report_format_id' => $report_format->id,
            'report_title' => 'Hovedrapport',
            'report_desc' => '&lt;p&gt;Lederens eller HMS-r&amp;aring;dgivers analyse av arbeidsmilj&amp;oslash;situasjonen. Inkludert medarbeideres syn p&amp;aring; situasjonen i arbeidsmilj&amp;oslash;et.&amp;nbsp;&lt;/p&gt;
            &lt;p&gt;&lt;strong&gt;Brukes n&amp;aring;r&lt;/strong&gt;: Gruppen trenger &amp;aring; endre arbeidsmilj&amp;oslash;situasjonen som inneholder samarbeidsproblem eller konflikt. BHT r&amp;aring;dgiver eller leder &amp;oslash;nsker en veiviser for beslutningsst&amp;oslash;tte og dokumentasjon i den videre prosessen. Det foreligger informasjon om hovedtrekkene i den oppst&amp;aring;tte arbeidsmilj&amp;oslash;situasjonen. Rapport danner dokumentasjon p&amp;aring; at situasjon og prosess vies oppmerksomhet.&lt;/p&gt;
            &lt;p&gt;&lt;strong&gt;Bruk:&lt;/strong&gt; Fyll ut sp&amp;oslash;rreskjema med saksbeskrivelse. Ber&amp;oslash;rte medarbeidere inviteres (2 eller flere) til &amp;aring; fylle ut sp&amp;oslash;rreskjemaer som sendes som elektronisk lenke via e-post.&lt;/p&gt;
            &lt;p&gt;&lt;strong&gt;Rapportens innhold:&lt;/strong&gt;&lt;/p&gt;
            &lt;ul&gt;
            &lt;li&gt;Sammendrag&lt;/li&gt;
            &lt;li&gt;Bakgrunn&lt;/li&gt;
            &lt;li&gt;Mandat&lt;/li&gt;
            &lt;li&gt;Profil &amp;ndash; oversikt&lt;/li&gt;
            &lt;li&gt;Profil &amp;amp; analyse&lt;/li&gt;
            &lt;li&gt;Motivasjonsprofiler&lt;/li&gt;
            &lt;li&gt;Anbefalt metode og hvordan du g&amp;aring;r frem&lt;/li&gt;
            &lt;li&gt;Risikoanalyse&lt;/li&gt;
            &lt;/ul&gt;',
            'report_image' => 'example2.png',
            'language_id' => 2,
        ]);
        MlreportFormatContentd::create([
            'report_format_id' => $report_format->id,
            'report_content' => '{"front_page":{"enabled":true,"username":true,"company_name":true,"logo":false,"ticket_id":false,"page_break1":true},"free_text1":{"enabled":true,"text":"<h3 class=\"accordion-heading mb-0\" style=\"box-sizing: border-box; margin-top: 0px; font-weight: 500; line-height: 1.2; font-size: 1.75rem; color: #181c32; font-family: system-ui, -apple-system, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', \'Liberation Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; background-color: #ffffff; margin-bottom: 0px !important;\" data-toggle=\"collapse\" data-target=\"#free_text_1\" aria-expanded=\"true\" aria-controls=\"free_text_1\">InnholdEng</h3>\n<p>&nbsp;</p>\n<h3 class=\"accordion-heading mb-0\" style=\"box-sizing: border-box; margin-top: 0px; font-weight: 500; line-height: 1.2; font-size: 1.75rem; color: #181c32; font-family: system-ui, -apple-system, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', \'Liberation Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; background-color: #ffffff; margin-bottom: 0px !important;\" data-toggle=\"collapse\" data-target=\"#free_text_1\" aria-expanded=\"true\" aria-controls=\"free_text_1\">InnholdEng</h3>","page_break2":false},"intro_text":{"enabled":true,"text":"<h3 class=\"accordion-heading mb-0\" style=\"box-sizing: border-box; margin-top: 0px; font-weight: 500; line-height: 1.2; font-size: 1.75rem; color: #181c32; font-family: system-ui, -apple-system, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', \'Liberation Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; background-color: #ffffff; margin-bottom: 0px !important;\" data-toggle=\"collapse\" data-target=\"#intro_text\" aria-expanded=\"true\" aria-controls=\"intro_text\">SammendragENG</h3>\n<p>&nbsp;</p>\n<h3 class=\"accordion-heading mb-0\" style=\"box-sizing: border-box; margin-top: 0px; font-weight: 500; line-height: 1.2; font-size: 1.75rem; color: #181c32; font-family: system-ui, -apple-system, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', \'Liberation Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; background-color: #ffffff; margin-bottom: 0px !important;\" data-toggle=\"collapse\" data-target=\"#intro_text\" aria-expanded=\"true\" aria-controls=\"intro_text\">SammendragENG</h3>","page_break3":false},"free_text2":{"enabled":true,"text":"","page_break4":false},"free_text3":{"enabled":true,"text":"","page_break5":false},"free_text4":{"enabled":true,"text":"","page_break6":false},"free_text5":{"enabled":true,"text":"","page_break7":false},"free_text6":{"enabled":true,"text":"","page_break8":false},"free_text7":{"enabled":false,"text":"","page_break9":false},"free_text8":{"enabled":false,"text":"","page_break10":false},"free_text9":{"enabled":false,"text":"","page_break11":false},"free_text10":{"enabled":false,"text":"","page_break12":false},"free_text11":{"enabled":true,"text":"","page_break13":false},"free_text12":{"enabled":false,"text":"","page_break14":false},"free_text13":{"enabled":false,"text":"","page_break15":false},"free_text14":{"enabled":false,"text":"","page_break16":false},"free_text15":{"enabled":true,"text":"<p><strong>Radar Graph Eng</strong></p>","page_break17":false}}',
            'language_id' => 1,
        ]);
        MlreportFormatContentd::create([
            'report_format_id' => $report_format->id,
            'report_content' => '{"front_page":{"enabled":true,"username":true,"company_name":true,"logo":true,"ticket_id":true,"page_break1":false},"free_text1":{"enabled":true,"text":"<h3 class=\"accordion-heading mb-0 collapsed\" style=\"box-sizing: border-box; margin-top: 0px; font-weight: 500; line-height: 1.2; font-size: 1.75rem; color: #181c32; font-family: system-ui, -apple-system, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', \'Liberation Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; background-color: #ffffff; margin-bottom: 0px !important;\" data-toggle=\"collapse\" data-target=\"#free_text_1\" aria-expanded=\"false\" aria-controls=\"free_text_1\">InnholdNor</h3>\n<p>&nbsp;</p>\n<h3 class=\"accordion-heading mb-0 collapsed\" style=\"box-sizing: border-box; margin-top: 0px; font-weight: 500; line-height: 1.2; font-size: 1.75rem; color: #181c32; font-family: system-ui, -apple-system, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', \'Liberation Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; background-color: #ffffff; margin-bottom: 0px !important;\" data-toggle=\"collapse\" data-target=\"#free_text_1\" aria-expanded=\"false\" aria-controls=\"free_text_1\">InnholdNor</h3>","page_break2":false},"intro_text":{"enabled":false,"text":"","page_break3":true},"free_text2":{"enabled":false,"text":"","page_break4":false},"free_text3":{"enabled":false,"text":"","page_break5":false},"free_text4":{"enabled":false,"text":"","page_break6":false},"free_text5":{"enabled":false,"text":"","page_break7":false},"free_text6":{"enabled":false,"text":"","page_break8":false},"free_text7":{"enabled":false,"text":"","page_break9":false},"free_text8":{"enabled":false,"text":"","page_break10":false},"free_text9":{"enabled":false,"text":"","page_break11":false},"free_text10":{"enabled":false,"text":"","page_break12":false},"free_text11":{"enabled":false,"text":"","page_break13":false},"free_text12":{"enabled":false,"text":"","page_break14":false},"free_text13":{"enabled":false,"text":"","page_break15":false},"free_text14":{"enabled":false,"text":"","page_break16":false},"free_text15":{"enabled":true,"text":"<p><strong>RadarGraph Nor</strong></p>","page_break17":false}}',
            'language_id' => 2,
        ]);
    }
}
