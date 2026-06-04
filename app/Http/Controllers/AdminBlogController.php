<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class AdminBlogController extends Controller
{
    // Display list of all blog posts in the Dashboard panel
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->get();
        return view('dashboard', compact('blogs'));
    }

    // Show form to write a new notice post
    public function create()
    {
        return view('admin.create');
    }

    // Process and validate incoming data form submissions to store them safely
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:Admit Card,Result',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->category = $request->category;
        $blog->short_description = $request->short_description;
        $blog->content = $request->content;

        // Handle physical file updates securely
        if ($request->hasFile('image')) {
            // Stores inside storage/app/public/blogs
            $path = $request->file('image')->store('blogs', 'public');
            $blog->image = 'storage/' . $path;
        }

        $blog->save();

        return redirect()->route('dashboard')->with('success', 'Notice portal announcement deployed successfully!');
    }

    // Open an existing record database layout form for direct line modifications
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.edit', compact('blog'));
    }

    // Process an update transaction item log block inside the model entity definitions
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:Admit Card,Result',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $blog->title = $request->title;
        $blog->category = $request->category;
        $blog->short_description = $request->short_description;
        $blog->content = $request->content;

        if ($request->hasFile('image')) {
            // Delete the old file if it exists in local storage
            if ($blog->image && !filter_var($blog->image, FILTER_VALIDATE_URL)) {
                $oldPath = str_replace('storage/', '', $blog->image);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('blogs', 'public');
            $blog->image = 'storage/' . $path;
        }

        $blog->save();

        return redirect()->route('dashboard')->with('success', 'Notice entry modified updated smoothly.');
    }

    // Completely erase record logs safely along with dependencies asset files
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        // Delete its local file from storage if it exists
        if ($blog->image && !filter_var($blog->image, FILTER_VALIDATE_URL)) {
            $oldPath = str_replace('storage/', '', $blog->image);
            Storage::disk('public')->delete($oldPath);
        }

        $blog->delete();

        return redirect()->route('dashboard')->with('success', 'Notice completely removed from portal systems.');
    }
}