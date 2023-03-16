<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class CreateDatosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        var_dump("Registros usuarios Maestros");

        DB::table('users')->delete();

        User::create([
            'name' => 'Deivi Ibarra Negrette',
            'email' => 'deivibarra@softdin.com',
            'password' => Hash::make('Din22031974'),
        ]);

        User::create([
            'name' => 'Erick Cantillo',
            'email' => 'erick.cantillo97@gmail.com',
            'password' => Hash::make('123456789'),
        ]);



    }
}

// php artisan migrate:fresh --seed    // So funciono
// php artisan db:seed --class=CreateAdminUserSeeder  // Es si
