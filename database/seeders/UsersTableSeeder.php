<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = User::create([
            'name' => 'Mayuri Londhe', 
            'email' => 'mayulondhe16@gmail.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
