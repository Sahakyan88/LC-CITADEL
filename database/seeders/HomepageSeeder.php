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
            'title_am' => 'asdasd',
            'title_ru' => 'asdasd',
            'title_en' => 'asdasd',
            'description_am' => 'asdasd',
            'description_ru' => 'asdasd',
            'description_en' => 'asdasd',
            'image_id' => '1',
            'published' => '0',
            'ordering' => '1',
           
        ]);
        DB::table('settings')->insert([
            'key' => 'sait_settings',
            'value' => '{"email":"asdasd@asddddd.comiii","phone":"32423432","address":"adsfasdfadsf","fax":"adsfasdfadsf","facebook":"asdfasdfasd","twitter":"asdfadsf"}',
            'contact_email'=>'asd@adsa@gmail.com'
           
        ]);
       
    }
}
