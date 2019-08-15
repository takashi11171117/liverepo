<?php

use Illuminate\Database\Seeder;

class ReportCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\ReportComment::class, 10)
            ->create([
                'report_id' => factory(App\Models\Report::class)
                    ->create([
                        'user_id' => factory(App\Models\User::class)->create()->id,
                        'status' => 1,
                    ])->id
            ]);
    }
}
