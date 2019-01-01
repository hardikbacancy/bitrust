<?php

use Illuminate\Database\Seeder;
use App\Models\admin\AdminSetting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminSetting::truncate();

        $data = [];

        array_push($data, [
            'penalty'     => '10',
            'interest_rate'    => '5',
            'membership_fee' => '50',            
        ]);

        AdminSetting::insert($data);
    }
}
