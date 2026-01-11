<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Books::with('category');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm }%")
                ->orWhere('author', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('category_filter') && $request->category_filter != '') {
            $query->where('category_id', $request->category_filter);
        }

        $books = $query->latest()->get();
        $categories = Categories::all();
        $activeCategory = Categories::count();

        // Get the most archived genre
        $mostArchivedGenre = Books::select('category_id', DB::raw('count(*) as total'))
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->first();

        $mostArchivedGenreName = $mostArchivedGenre 
            ? Categories::find($mostArchivedGenre->category_id)->name 
            : 'N/A';

        return view('dashboard', compact('books', 'categories', 'activeCategory', 'mostArchivedGenreName'));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $validated['image'] = $imagePath;
        }

        Books::create($validated);
        return redirect()->route('dashboard')->with('success', 'Book successfully archived!');
    }

    public function edit(Books $book)
    {
        $books = Books::latest()->get();
        $categories = Categories::latest()->get();

        return view('dashboard', [
            'books' => $books,
            'categories' => $categories,
            'editingBook' => $book,
        ]);
    }

    public function update(Request $request, Books $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('books', 'public');
            $validated['image'] = $imagePath;
        } 

        Books::where('id', $book->id)->update($validated);

        return redirect()->back()->with('success', 'Book updated successfully!');
    }

    public function destroy(Books $book)
    {

        $book->delete();
        return redirect()->route('dashboard')->with('success', 'Book deleted successfully!');
    }

    public function trash()
    {
        $book = Books::onlyTrashed()->with('categories')->latest('deleted_at')->get();
        $categories = Categories::all();
        
        return view('trash', compact('books', 'categories'));
    }

    public function restore($id)
    {
        $book = Books::withTrashed()->findOrFail($id);
        $books->restore();
        
        return view('books.trash')->with('success', 'Book restored successfully!');
    }

    public function forceDelete($id)
    {
        $book = Books::withTrashed()->findOrFail($id);

        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->forceDelete();

        return redirect()->route('books.trash')->with('success', 'Student permanently deleted.');
    }
}
