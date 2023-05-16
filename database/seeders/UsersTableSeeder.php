<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin Restoran 1',
            'email' => 'resto1@tomo.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'remember_token' => Str::random(10),
            'role' => 'RESTO',
        ]);
        DB::table('users')->insert([
            'name' => 'Kurir 1',
            'email' => 'kurir1@tomo.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'remember_token' => Str::random(10),
            'role' => 'KURIR',
        ]);
        DB::table('users')->insert([
            'name' => 'Konsumen 1',
            'email' => 'konsumen1@tomo.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'remember_token' => Str::random(10),
            'role' => 'KONSUMEN',
        ]);
    }
}
