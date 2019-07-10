<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Admin::class, 10)->create();
        factory(App\Models\Admin::class)->create([
            'email' => 'test@gmail.com',
            'password' => '3387Ezweb',
        ]);
    }
}
