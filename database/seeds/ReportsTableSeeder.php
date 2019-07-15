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
        factory(App\Models\Report::class, 10)
            ->create()
            ->each(function(App\Models\Report $report) {
                $report->report_tags()->saveMany(factory(App\Models\ReportTag::class, rand(0, 3))->make());
                $report->report_images()->saveMany(factory(App\Models\ReportImage::class, 1)->make());
                $report->user()->associate(factory(App\Models\User::class)->create());
            });

        factory(App\Models\Report::class, 1)
            ->create()
            ->each(function(App\Models\Report $report) {
                $report->report_tags()->saveMany(factory(App\Models\ReportTag::class, rand(0, 3))->make());
                $report->report_images()->saveMany(factory(App\Models\ReportImage::class, 1)->make());
                $report->user()->associate(factory(App\Models\User::class)->create([
                    'email' => 'test@gmail.com',
                    'password' => '3387Ezweb'
                ]));
            });
    }
}
