<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomepageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('home')->insert([
            'title_am' => 'ԱՌԱՋԻՆ ԻՐԱՎԱԲԱՆԱԿԱՆ ԱՊԱՀՈՎԱԳՐՈՒԹՅՈՒՆԸ ՀԱՅԱՍՏԱՆՈՒՄ',
            'title_ru' => '',
            'title_en' => '',
            'description_am' => 'Շտապիր ապահովագրել վաղվադ օրը հենց այսօր',
            'description_ru' => '',
            'description_en' => '',
            'image_id' => '1',
            'published' => '0',
            'ordering' => '1',
           
        ]);
        DB::table('settings')->insert([
            'key' => 'sait_settings',
            'value' => '{"email":"lcCitadel@gmail.com","phone":"077777777","address_en":"Yerevan","address_ru":"","address_am":"","facebook":"link","instagram":"link"}'
           
        ]);
        DB::table('about')->insert([
            'title_am' => 'armenian',
            'title_ru' => 'rusian',
            'title_en' => 'English',
            'body_am' => 'text Armenian',
            'body_en' => 'Text English',
            'body_ru' => 'Text Russian',
            'ordering' => '1',
            'image_id' => '2',
            'published' => '0',
           
        ]);
       
    }
}
