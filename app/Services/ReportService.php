<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportTag;

class ReportService{
    public function syncReportTag(Report $report, array $array_tag_name){
        $tags = array_map(function($tag) {
            $fTag = ReportTag::firstOrCreate( [ 'name' => $tag, 'taxonomy' => 'place' ] );
            return $fTag->id;
        }, $array_tag_name);
        $report->report_tags()->sync($tags);
    }
}