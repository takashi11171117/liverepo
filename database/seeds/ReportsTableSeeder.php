<?php

use Illuminate\Database\Seeder;

class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Report::class, 10)
            ->create()
            ->each(function(App\Report $report) {
                $report->report_tags()->saveMany(factory(App\ReportTag::class, rand(0, 3))->make());
                $report->report_images()->saveMany(factory(App\ReportImage::class, 1)->make());
            });
    }
}
