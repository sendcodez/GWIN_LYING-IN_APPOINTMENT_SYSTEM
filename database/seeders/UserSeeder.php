<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
 
class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'status' => '1',
            'usertype' => '1'
        ]);
        DB::table('users')->insert([
            'name' => 'Doctor',
            'email' => 'doctor@gmail.com',
            'password' => Hash::make('doctor123'),
            'status' => '1',
            'usertype' => '2'
        ]);
        DB::table('users')->insert([
            'name' => 'Patient',
            'email' => 'patient@gmail.com',
            'password' => Hash::make('patient123'),
            'status' => '1',
            'usertype' => '3'
        ]);
    }
}