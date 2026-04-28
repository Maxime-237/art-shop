<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catgories = [
            [
                'name'         => 'Sculpture',
                'description' => 'Œuvres sculptées en bois, bronze ou pierre issues de l\'artisanat camerounais.',
            ],

            [
                'name'         => 'Peinture',
                'description' => 'Tableaux et peintures représentant la culture et les paysages du Cameroun.',
            ],

            [
                'name'         => 'Digital',
                'description' => 'Art numérique fusionnant motifs traditionnels et esthétique moderne.',
            ],

            [
                'name'         => 'Photographie',
                'description' => 'Clichés artistiques capturant l\'âme et la beauté du peuple camerounais.',
            ],

            [
                'name'         => 'Artisanat',
                'description' => 'Bijoux, tissus et objets décoratifs faits main par des artisans locaux.',
            ],
        ];

        foreach ($catgories as $cat) {
            Categorie::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description']
            ]);
        }
    }
}
