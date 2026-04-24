<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            ['name' => "Dexter Zone (Men's)", 'slug' => 'dexter-zone-mens', 'category' => 'shoes', 'variant_type' => 'size', 'variant_options' => ['7 UK', '8 UK', '9 UK', '10 UK', '11 UK'], 'price' => 109.90, 'image_path' => 'images/Store/shoes/men_shoes.png'],
            ['name' => "Dexter Royal (Men's)", 'slug' => 'dexter-royal-mens', 'category' => 'shoes', 'variant_type' => 'size', 'variant_options' => ['7 UK', '8 UK', '9 UK', '10 UK', '11 UK'], 'price' => 139.90, 'image_path' => 'images/Store/shoes/men_shoes2.png'],
            ['name' => "Dexter Dani (Women's)", 'slug' => 'dexter-dani-womens', 'category' => 'shoes', 'variant_type' => 'size', 'variant_options' => ['7 UK', '8 UK', '9 UK', '10 UK', '11 UK'], 'price' => 129.90, 'image_path' => 'images/Store/shoes/women_shoes.png'],
            ['name' => "Dexter Power Frame (Women's)", 'slug' => 'dexter-power-frame-womens', 'category' => 'shoes', 'variant_type' => 'size', 'variant_options' => ['7 UK', '8 UK', '9 UK', '10 UK', '11 UK'], 'price' => 159.90, 'image_path' => 'images/Store/shoes/women_shoes2.png'],
            ['name' => 'Bowl Crown Victory', 'slug' => 'bowl-crown-victory', 'category' => 'bowling_ball', 'variant_type' => 'weight', 'variant_options' => ['3 kg', '5 kg', '7 kg', '10 kg'], 'price' => 125.90, 'image_path' => 'images/Store/blue_bowling.png'],
            ['name' => 'Bowl Viz-a-ball Unicorn', 'slug' => 'bowl-viz-a-ball-unicorn', 'category' => 'bowling_ball', 'variant_type' => 'weight', 'variant_options' => ['3 kg', '5 kg', '7 kg', '10 kg'], 'price' => 155.90, 'image_path' => 'images/Store/unicorn_bowling.png'],
            ['name' => 'Bowl The Hitter Pearl', 'slug' => 'bowl-the-hitter-pearl', 'category' => 'bowling_ball', 'variant_type' => 'weight', 'variant_options' => ['3 kg', '5 kg', '7 kg', '10 kg'], 'price' => 135.90, 'image_path' => 'images/Store/red_bowling.png'],
            ['name' => 'Bowl The Raptor Power', 'slug' => 'bowl-the-raptor', 'category' => 'bowling_ball', 'variant_type' => 'weight', 'variant_options' => ['3 kg', '5 kg', '7 kg', '10 kg'], 'price' => 145.90, 'image_path' => 'images/Store/yellow_bowling.png'],
            ['name' => 'Bowling Wrist Band', 'slug' => 'bowling-wrist-band', 'category' => 'accessory', 'variant_type' => 'size', 'variant_options' => ['S - SMALL', 'M - MEDIUM', 'L - LARGE'], 'price' => 43.90, 'image_path' => 'images/Store/wrist_band.png'],
            ['name' => 'Bowling Unisex Socks', 'slug' => 'bowling-unisex-socks', 'category' => 'accessory', 'variant_type' => 'size', 'variant_options' => ['S - SMALL', 'M - MEDIUM', 'L - LARGE'], 'price' => 20.90, 'image_path' => 'images/Store/socks_bowling.png'],
            ['name' => 'Motiv Bowl Tote Roller', 'slug' => 'motiv-bowl-tote-roller', 'category' => 'accessory', 'variant_type' => 'size', 'variant_options' => ['M - MEDIUM'], 'price' => 66.90, 'image_path' => 'images/Store/bag_bowling.png'],
            ['name' => 'BowlZone Royal Blue Cap', 'slug' => 'bowlzone-royal-blue-cap', 'category' => 'accessory', 'variant_type' => 'size', 'variant_options' => ['S - SMALL', 'M - MEDIUM', 'L - LARGE'], 'price' => 35.90, 'image_path' => 'images/Store/cap_bowling.png'],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['slug' => $product['slug']], $product);
        }
    }
}
