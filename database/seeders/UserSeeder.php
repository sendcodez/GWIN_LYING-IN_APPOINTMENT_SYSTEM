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
            'firstname' => 'Admin',
            'middlename' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => '2024-08-01 09:34:57',
            'password' => Hash::make('admin123'),
            'status' => '1',
            'usertype' => '0'
        ]);
        DB::table('users')->insert([
            'firstname' => 'Staff',
            'middlename' => 'Staff',
            'lastname' => 'Staff',
            'email' => 'staff@gmail.com',
            'email_verified_at' => '2024-08-01 09:34:57',
            'password' => Hash::make('staff123'),
            'status' => '1',
            'usertype' => '1'
        ]);
        DB::table('users')->insert([
            'firstname' => 'Doctor',
            'middlename' => 'Doctor',
            'lastname' => 'Doctor',
            'email' => 'doctor@gmail.com',
            'email_verified_at' => '2024-08-01 09:34:57',
            'password' => Hash::make('doctor123'),
            'status' => '1',
            'usertype' => '2'
        ]);
        DB::table('users')->insert([
            'firstname' => 'Patient',
            'middlename' => 'Patient',
            'lastname' => 'Patient',
            'email' => 'patient@gmail.com',
            'email_verified_at' => '2024-08-01 09:34:57',
            'password' => Hash::make('patient123'),
            'status' => '1',
            'usertype' => '3'
        ]);
        /*
        DB::table('doctors')->insert([
            'user_id' => '20240001',
            'firstname' => 'Pedro',
            'middlename' => '',
            'lastname' => 'Cruz',
            'address' => 'Laguna',
            'expertise' => 'test',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam faucibus elit pulvinar nunc porttitor sagittis.',
            'contact_no' => '0909909099',
            'email' => 'docdoc@gmail.com',
            'password' => Hash::make('docdoc123'),
            'status' => '1',
            'usertype' => '2'
        ]);
        */
        DB::table('website')->insert([
            'logo' => 'gwinlogo.png',
            'business_name' => 'GWIN LYING-IN',
            'tagline' => 'Best Healthcare Solution In Your City',
            'tagline_2' => 'Best Medical Care For Yourself and Your Family',
            'address' => 'Bulihan, Silang Cavite',
            'contact_no' => '0909909099',
            'email' => 'gwin@gmail.com',
            'about_us' => 'Tempor erat elitr at rebum at at clita aliquyam consetetur. Diam dolor diam ipsum et, tempor voluptua sit consetetur sit. Aliquyam diam amet diam et eos sadipscing labore. Clita erat ipsum et lorem et sit, sed stet no labore lorem sit. Sanctus clita duo justo et tempor consetetur takimata eirmod, dolores takimata consetetur invidunt magna dolores aliquyam dolores dolore. Amet erat amet et magna',
        ]);
    }
}