<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all articles and categories
        $articles = Article::all();
        $categories = Category::all();

        // Assign categories to articles
        foreach ($articles as $index => $article) {
            // Assign 1-2 categories per article
            $categoryCount = rand(1, 2);
            $selectedCategories = $categories->random($categoryCount);
            
            foreach ($selectedCategories as $category) {
                $article->categories()->attach($category->id);
            }
        }

        echo "Article categories seeded successfully!\n";
    }
}
