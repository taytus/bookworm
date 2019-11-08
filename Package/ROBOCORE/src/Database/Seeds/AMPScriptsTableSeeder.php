<?php

use Illuminate\Database\Seeder;
use ROBOAMP\DB; as myDB;
use ROBOAMP\MyArray;


class AMPScriptsTableSeeder extends Seeder{

    public function run(){

        $table = "ampscripts";
        myDB::truncate($table);
        $now = time();

        $scripts_array = [
            ['name' => 'amp-sidebar', 'path' => 'https://cdn.ampproject.org/v0/amp-sidebar-0.1.js', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'amp-form', 'path' => 'https://cdn.ampproject.org/v0/amp-form-0.1.js', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'amp-carousel', 'path' => 'https://cdn.ampproject.org/v0/amp-carousel-0.1.js', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'amp-selector', 'path' => 'https://cdn.ampproject.org/v0/amp-selector-0.1.js', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'amp-lightbox-gallery', 'path' => 'https://cdn.ampproject.org/v0/amp-lightbox-gallery-0.1.js', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'amp-iframe', 'path' => 'https://cdn.ampproject.org/v0/amp-iframe-0.1.js', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'amp-social-share', 'path' => 'https://cdn.ampproject.org/v0/amp-social-share-0.1.js', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'amp-bind', 'path' => 'https://cdn.ampproject.org/v0/amp-bind-0.1.js', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'amp-accordion', 'path' => 'https://cdn.ampproject.org/v0/amp-accordion-0.1.js', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'amp-facebook-like', 'path' => 'https://cdn.ampproject.org/v0/amp-facebook-like-0.1.js', 'created_at' => $now, 'updated_at' => $now],

        ];

        MyArray::create_items_from_array("App\Ampscript", $scripts_array);
    }
}
