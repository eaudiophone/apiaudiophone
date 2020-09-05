<?php

use Illuminate\Database\Seeder;
use App\Apiaudiophonemodels\ApiAudiophoneService;


class ApiAudiophoneServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        factory(ApiAudiophoneService::class)->create();
    }
}
