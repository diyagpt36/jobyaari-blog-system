<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        Blog::create([
            'title' => 'SSC CGL 2026 Admit Card Released',
            // High-resolution premium stock image representing exam/writing desk
            'image' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?w=1200&auto=format&fit=crop&q=80',
            'short_description' => 'Download your region-wise SSC CGL tier-1 admit card now.',
            'content' => 'The Staff Selection Commission has officially released the admit cards for the Combined Graduate Level Examination. Candidates can access their regional portals to verify center data, shift timings, and instruction files.',
            'category' => 'Admit Card'
        ]);

        Blog::create([
            'title' => 'UPSC Civil Services 2025 Final Results Out',
            // High-resolution image representing a corporate briefing/interview panel
            'image' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=1200&auto=format&fit=crop&q=80',
            'short_description' => 'Check the complete merit list and cutoff scores inside.',
            'content' => 'The Union Public Service Commission has declared the final results for the Civil Services Examination. The official list displays recommended candidates for IAS, IFS, and IPS paths alongside official category-wise cutoffs.',
            'category' => 'Result'
        ]);

        Blog::create([
            'title' => 'IBPS PO Mains Call Letter Dispatched',
            // High-resolution image representing focused study/work environment
            'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&auto=format&fit=crop&q=80',
            'short_description' => 'Get the official link to download your banking phase-2 hall ticket.',
            'content' => 'The Institute of Banking Personnel Selection has enabled the download link for the Probationary Officers Phase II Main Examination admit cards. Ensure your registration parameters are ready.',
            'category' => 'Admit Card'
        ]);
    }
}