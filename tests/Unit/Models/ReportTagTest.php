<?php

namespace Tests\Unit\Models;

use App\Models\Report;
use App\Models\ReportTag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTagTest extends TestCase
{

    public function test_it_belongs_to_many_report_tags()
    {
        $report = factory(Report::class)->create();


        $report_tag = factory(ReportTag::class)->create();

        $report_tag->reports()->sync([$report->id]);

        $this->assertInstanceOf(Report::class, $report_tag->reports->first());
    }
}
