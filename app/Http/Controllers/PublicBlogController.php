<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class PublicBlogController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tell Laravel to prepare to search through our 'blogs' database table
        $query = Blog::query();

        // 2. Check if the visitor clicked a category filter (e.g., 'Admit Card', 'Result') 
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // 3. MANDATORY AJAX REQUIREMENT: Filter/Sort by Date dynamically
        if ($request->has('date_sort') && $request->date_sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // 4. Search by title (AJAX + normal requests)
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 5. Fetch the final filtered records
        $blogs = $query->get();

        // 6. AJAX: return JSON only, no full page reload
        if ($request->ajax()) {
            return response()->json(['blogs' => $blogs]);
        }

        // 7. Featured blogs for hero section (initial page load only)
        $featuredBlogs = Blog::orderBy('created_at', 'desc')->take(5)->get();

        // 8. Normal page load
        return view('welcome', compact('blogs', 'featuredBlogs'));
    }

    /**
     * Blog Detail Page
     * Fetches a specific blog by its ID and shows its full content.
     */
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blog-detail', compact('blog'));
    }
}