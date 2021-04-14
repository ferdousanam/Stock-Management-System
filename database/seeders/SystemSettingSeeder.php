<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemSetting::updateOrCreate(['id' => 1], [
            'app_name' => config('app.name'),
            'created_by' => User::first()->id,
        ]);
    }
}
