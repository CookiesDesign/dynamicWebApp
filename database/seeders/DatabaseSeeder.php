<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

        //Codigo para eliminar la carpeta en dado caso exista
        Storage::deleteDirectory('posts');
        //Codigo para crear una carpeta
        Storage::makeDirectory('posts');

        //Seeders para crear posts
        \App\Models\Post::factory(100)->create();

        //Seeder de usuarios
        User::create([
            'name' => 'Cookies Design',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')

        ]);
    }
}
