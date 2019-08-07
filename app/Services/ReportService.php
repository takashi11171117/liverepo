<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportTag;

class ReportService{
    public function syncReportTag(Report $report, array $array_tag_name, string $taxonomy){
        $tags = array_map(function($tag) use ($taxonomy) {
            $fTag = ReportTag::firstOrCreate( [ 'name' => $tag, 'taxonomy' => $taxonomy ] );
            return $fTag->id;
        }, $array_tag_name);
        $report->report_tags()->sync($tags);
    }
}