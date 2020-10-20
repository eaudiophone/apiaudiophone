<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call([

        	ApiAudiophoneUserSeeder::class,
        	ApiAudiophoneTermSeeder::class,
            ApiaudiophoneServiceSeeder::class,
            ApiAudiophonEventSeeder::class
        ]);
    }
}
