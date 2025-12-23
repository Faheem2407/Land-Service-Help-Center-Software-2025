<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::insert([
            [
                'id'             => 1,
                'title'          => 'ভুমি সেবা',
                'email'          => 'support@gmail.com',
                'system_name'    => '017xxxxxxx',
                'copyright_text' => 'ভুমি সেবা',
                'logo'           => null,
                'favicon'        => null,
                'description'    => 'The Description',
                'created_at'     => Carbon::now(),
            ],
        ]);
    }
}
