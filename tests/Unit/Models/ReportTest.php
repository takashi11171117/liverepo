<?php

namespace Tests\Unit\Models;

use App\Models\Report;
use App\Models\ReportImage;
use App\Models\ReportTag;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTest extends TestCase
{
    public function test_it_has_many_report_images()
    {
        $report = factory(Report::class)->create();

        $report->report_images()->save(
            factory(ReportImage::class)->create([
                'report_id' => $report->id
            ])
        );

        $this->assertInstanceOf(ReportImage::class, $report->report_images->first());
    }

    public function test_it_belongs_to_many_report_tags()
    {
        $report = factory(Report::class)->create();


        $report_tag = factory(ReportTag::class)->create();

        $report->report_tags()->sync([$report_tag->id]);

        $this->assertInstanceOf(ReportTag::class, $report->report_tags->first());
    }

    public function test_it_belongs_to_a_user()
    {
        $report = factory(Report::class)->create();

        $this->assertInstanceOf(User::class, $report->user);
    }
}
