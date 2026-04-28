<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function Psy\bin;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création d'un utilisateur admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@art-shop.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'bio' => 'Administrateur de la plateforme.',

        ]);

        // Création d'un utilisateur artiste
        $artistes = [
            [
                'name' => 'Central Cee',
                'email' => 'cce@art-shop.cm',
                
                'bio' => 'Sculpteur Bamileke perpétuant les traditions des Grassfields.',
            ],

            [
                'name' => 'Awa Ndongo',
                'email' => 'awa@art-shop.cm',

                'bio' => 'Artiste digitale basée à Douala, fusionnant les motifs Sawa et l\'art numérique.',
            ],

            [
                'name'  => 'Moussa Fouda',
                'email' => 'moussa@art-shop.cm',

                'bio'   => 'Sculpteur de Foumban, spécialiste des bronzes Bamoun.',
            ],

            [
                'name'  => 'Sali Hamidou',
                'email' => 'sali@art-shop.cm',
                'bio'   => 'Peintre autodidacte de Yaoundé, inspiré par les forêts tropicales camerounaises.',
            ],

        ];

        foreach ($artistes as $artiste) {
            User::create([
                'name' => $artiste['name'],
                'email' => $artiste['email'],
                'password' => Hash::make('password'),
                'role' => 'artiste',
                'bio' => $artiste['bio'],
            ]);
        }

        //Création d'un utilisateur client
        $clients = [
            ['name' => 'jean Bekolo', 'email' => 'jean@exemple.cm'],
            ['name' => 'Marie Lobe',   'email' => 'marie@example.cm'],
            ['name' => 'Eric Mbarga',  'email' => 'eric@example.cm'],
        ];

        foreach ($clients as $client) {
            User::create([
                'name' => $client['name'],
                'email' => $client['email'],
                'password' => Hash::make('password'),
                'role' => 'client',
            ]);
        }
    }
}
