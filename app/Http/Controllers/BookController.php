<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;

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
        $books = Books::onlyTrashed()->with('category')->latest('deleted_at')->get();
        $categories = Categories::all();
        
        return view('trash', compact('books', 'categories'));
    }

    public function restore($id)
    {
        $book = Books::withTrashed()->findOrFail($id);
        $book->restore();
        
        return redirect()->route('books.trash')->with('success', 'Book restored successfully!');
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

    public function export(Request $request)
    {
        $query = Books::with('category');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('author', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('category_filter') && $request->category_filter != '') {
            $query->where('category_id', $request->category_filter);
        }

        $books = $query->latest()->get();

        $filename = 'books_export_' . date('Y-m-d_His') . '.pdf';

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Books Export</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    padding: 20px;
                    background-color: #f5f5f5;
                }
                .container {
                    max-width: 1200px;
                    margin: 0 auto;
                    background-color: white;
                    padding: 30px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                h1 {
                    color: #333;
                    text-align: center;
                    margin-bottom: 10px;
                }
                .export-info {
                    text-align: center;
                    color: #666;
                    margin-bottom: 30px;
                    font-size: 14px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th {
                    background-color: #4472C4;
                    color: white;
                    padding: 12px;
                    text-align: left;
                    font-weight: bold;
                    border: 1px solid #2e5c9a;
                }
                td {
                    padding: 10px 12px;
                    border: 1px solid #ddd;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                tr:hover {
                    background-color: #f0f0f0;
                }
                .footer {
                    margin-top: 20px;
                    padding: 15px;
                    background-color: #f0f0f0;
                    border-radius: 5px;
                    text-align: center;
                    font-weight: bold;
                    color: #333;
                }
                @media print {
                    body {
                        background-color: white;
                    }
                    .container {
                        box-shadow: none;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Books Export Report</h1>
                <div class="export-info">
                    Exported on: ' . date('F d, Y \a\t h:i A') . '<br>
                    Total Records: ' . $books->count() . '
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Archived Date</th>
                        </tr>
                    </thead>
                    <tbody>';

                $number = 1;
                foreach ($books as $book) {
                    $html .= '<tr>
                    <td>' . $number++ . '</td>
                    <td>' . htmlspecialchars($book->title) . '</td>
                    <td>' . htmlspecialchars($book->author) . '</td>
                    <td>' . htmlspecialchars($book->category ? $book->category->name : 'No Category') . '</td>
                    <td>' . htmlspecialchars($book->description) . '</td>
                    <td>' . $book->created_at->format('Y-m-d H:i:s') . '</td>
                </tr>';
                }

                $html .= '</tbody>
                </table>

                <div class="footer">
                    Total Books: ' . $books->count() . '
                </div>
            </div>
        </body>
        </html>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream($filename, ['Attachment' => true]);
    }
}
