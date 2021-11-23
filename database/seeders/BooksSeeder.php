<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert(
            [
                ["title" => "The Way of Kings", "author" => "Brandon Sanderson", "isbn" => 9781448792757, "url" => "https://upload.wikimedia.org/wikipedia/en/8/8b/TheWayOfKings.png"],
                ["title" => "The Blade Itself", "author" => "Joe Abercrombie", "isbn" => 9781591025948, "url" => "https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1284167912l/944073._SX318_SY475_.jpg"],
                ["title" => "The Eye of The World", "author" => "Robert Jordan", "isbn" => 9780312850098, "url" => "https://upload.wikimedia.org/wikipedia/en/0/00/WoT01_TheEyeOfTheWorld.jpg"],
            ]
        );
    }
}
