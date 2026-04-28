<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categorie;
use App\Models\Oeuvre;
use App\Models\User;
use Illuminate\Support\Str;


class OeuvreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sculpture  = Categorie::where('slug', 'sculpture')->first();
        $peinture   = Categorie::where('slug', 'peinture')->first();
        $digital    = Categorie::where('slug', 'digital')->first();
        $photo      = Categorie::where('slug', 'photographie')->first();

        $moussa = User::where('email', 'moussa@art-shop.cm')->first();
        $awa    = User::where('email', 'awa@art-shop.cm')->first();
        $sali   = User::where('email', 'sali@art-shop.cm')->first();
        $cce   = User::where('email', 'cce@art-shop.cm')->first();

        $oeuvres = [

                // Central Cee - Sculptures
               [
                 'user_id'           => $cce->id,
                 'categorie_id'      => $sculpture->id,
                 'titre'             => 'Gardien du vilage',
                 'description'       => 'Statue protectrice en ébène sculpté à la main, représentant l\'esprit gardien d\'un village traditionnel de l\'Ouest Cameroun.',
                  'price'             => 185000,
                 'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?q=80&w=800',
                 'vues'             => 320,
                ],

                // Moussa - Photographie
            [
                'user_id'          => $moussa->id,
                'categorie_id'      => $photo->id,
                'titre'            => 'Marché de Bafoussam',
                'description'      => 'Photographie argentique du célèbre marché de Bafoussam capturant l\'effervescence et les couleurs de la vie quotidienne de l\'Ouest.',
                'price'             => 55000,
                'image' => 'https://images.unsplash.com/photo-1523891707568-756bb0aca0f0?q=80&w=800',
                'vues'             => 780,
            ],

                [
                'user_id'          => $sali->id,
                'categorie_id'      => $peinture->id,
                'titre'            => 'Rêve Tropical',
                'description'      => 'Toile acrylique de grand format capturant la luxuriance de la forêt équatoriale camerounaise au lever du soleil. 100x80 cm.',
                'price'             => 120000,
                'image' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=800',
                'vues'             => 1200,
            ],

                [
                'user_id'          => $sali->id,
                'categorie_id'      => $peinture->id,
                'titre'            => 'Femme du Noun',
                'description'      => 'Portrait à l\'huile d\'une femme Bamoun dans ses habits traditionnels. Technique mixte sur toile. 60x80 cm.',
                'price'             => 95000,
                'image' => 'https://images.unsplash.com/photo-1541367777708-7905fe3296c0?q=80&w=800',
                'vues'             => 670,
            ],

                // Awa - Digital
            [
                'user_id'          => $awa->id,
                'categorie_id'      => $digital->id,
                'titre'            => 'Afro-Futurisme 237',
                'description'      => 'Œuvre digitale fusionnant les motifs géométriques Sawa avec une esthétique futuriste. Impression haute résolution disponible en A2.',
                'price'             => 45000,
                'image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=800',
                'vues'             => 2100,
            ],

                [
                'user_id'          => $awa->id,
                'categorie_id'      => $digital->id,
                'titre'            => 'Guerrière Lumière',
                'description'      => 'Illustration numérique d\'une guerrière Fang ornée de tatouages tribaux traditionnels revisités dans un univers sci-fi. Print A3.',
                'price'             => 38000,
                'image' => 'https://images.unsplash.com/photo-1561214115-f2f134cc4912?q=80&w=800',
                'vues'             => 1540,
            ],

                // Moussa - Sculptures
                [
                  'user_id'          => $moussa->id,
                  'categorie_id'      => $sculpture->id,
                  'titre'            => 'Masque Bamoun Bronze',
                  'description'      => 'Masque rituel en bronze fondu selon la technique ancestrale de la cire perdue, représentant un roi Bamoun. Pièce unique réalisée à Foumban.',
                   'price'             => 75000,
                  'image' => 'https://images.unsplash.com/photo-1566996694954-90b052c413c4?q=80&w=800',
                   'vues'             => 450,
                ],

                [
                'user_id'          => $cce->id,
                'categorie_id'      => $sculpture->id,
                'titre'            => 'Dynastie Grassfields',
                'description'      => 'Grande sculpture en bois de sapelli représentant les figures ancestrales des chefferies Bamileke. Hauteur 80 cm.',
                'price'             => 250000,
                'image' => 'https://images.unsplash.com/photo-1515405299443-f73bb32881d3?q=80&w=800',
                'vues'             => 890,
            ],


        ];

        foreach($oeuvres as $data) {

            Oeuvre::create([
                'user_id' => $data['user_id'],
                'categorie_id' => $data['categorie_id'],
                'titre' => $data['titre'],
                'slug' => Str::slug($data['titre']) . '-' . uniqid(),
                'description' => $data['description'],
                'price' => $data['price'],
                'stock' => 1,
                'statut' => 'disponible',
                'image' => $data['image'],
                'vues' => $data['vues'],
            ]);
        }
    }
}
