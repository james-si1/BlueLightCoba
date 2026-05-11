<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::updateOrCreate(['nama_kategori' => 'Ikan']);
        Category::updateOrCreate(['nama_kategori' => 'Pakan']);
        Category::updateOrCreate(['nama_kategori' => 'Perlengkapan']);
    }
}
