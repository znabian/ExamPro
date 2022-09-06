<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
        ->insert([
            "phone"=>"09130616299",
            "is_admin"=>true,
            "password"=>Hash::make("62991"),
            "created_at"=>Carbon::now(),
        ]);
    }
}
