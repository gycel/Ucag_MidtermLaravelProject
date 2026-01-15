<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

    @if(session('success'))
        <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif
        <!-- Stats Cards -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Archived Books</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $books->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-red-600/50 p-3 dark:bg-red-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-700 dark:text-red-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-heart-icon lucide-book-heart">
                            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"/><path d="M8.62 9.8A2.25 2.25 0 1 1 12 6.836a2.25 2.25 0 1 1 3.38 2.966l-2.626 2.856a.998.998 0 0 1-1.507 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Existing Genres</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $categories->count() }}</h3>
                    </div> 
                    <div class="rounded-full bg-blue-200 p-3 dark:bg-blue-800/30">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-blue-600 dark:text-blue-300">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                        </svg>
                    </div>
                </div> 
            </div>
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Most Archived Genre</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $mostArchivedGenreName }}</h3>
                    </div>
                    <div class="rounded-full bg-purple-100 p-3 dark:bg-purple-900/30">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Book Management Section -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-800">
            <div class="flex h-full flex-col p-6">
                <div class="mb-4 flex justify-end">
                    <form method="GET" action="{{ route('books.export') }}" class="inline">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="category_filter" value="{{ request('category_filter') }}">

                        <button type="submit"
                                class="flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-green-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export to PDF
                        </button>
                    </form>
                </div>
                
                <!-- Add New Book Form -->
                <div class="mb-6 rounded-lg border border-neutral-200 bg-neutral-50 p-6 dark:border-neutral-700 dark:bg-neutral-900/50">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                        Add New Book
                    </h2>
                    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
                        @csrf
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter book title" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('title') 
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Author</label>
                            <input type="text" name="author" value="{{ old('author') }}" placeholder="Enter book author" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('author') 
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Genre</label>
                            <select name="category_id" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                <option value="" {{ old('category_id') == null ? 'selected' : '' }} disabled>Choose book genre</option>
                               @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ (string) old('category_id') === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') 
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Description</label>
                            <textarea name="description" placeholder="Enter book description" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">{{ old('description') }}</textarea>
                            @error('description') 
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Book Cover</label>
                            <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg" class="w-full rounded-lg border-neutral-300 bg-white px-4 py-2 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('image') 
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="rounded-lg bg-red-800 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-500/50 dark:hover:bg-red-300 dark:hover:text-gray-800">
                                Archive Book
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Search & Filter Section -->
                <div class="rounded-xl border mb-10 border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Search & Filter Books</h2>

                    <form action="{{ route('dashboard') }}" method="GET" class="grid gap-4 md:grid-cols-3">
                        <!-- Search Input -->
                        <div class="md:col-span-1">
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Search</label>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search by title or author"
                                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"
                            >
                        </div>

                        <!-- Category Filter Dropdown -->
                        <div class="md:col-span-1">
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Filter by Genre</label>
                            <select
                                name="category_filter"
                                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                <option value="">All Genres</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_filter') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-end gap-2 md:col-span-1">
                            <button
                                type="submit"
                                class="flex-1 rounded-lg bg-red-800 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-500/50 dark:hover:bg-red-300 dark:hover:text-gray-800"
                            >
                                Apply Filters
                            </button>
                            <a
                                href="{{ route('dashboard') }}"
                                class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Archived Book List -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Book List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">#</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Cover</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Title</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Author</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Genre</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300 max-w-xs">Description</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300 whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                @forelse($books as $book)
                                <tr class="transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                                    <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400"><img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="w-10 h-16"></td>
                                    <td class="px-4 py-3 text-sm text-neutral-900 dark:text-neutral-100">{{ $book->title }}</td>
                                    <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $book->author }}</td>
                                    <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $book->category->name }}</td>
                                    <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400 max-w-xs">
                                        <div class="line-clamp-2">{{ $book->description }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm whitespace-nowrap">
                                        <span class="text-violet-800 dark:text-violet-400 cursor-pointer opacity-60" onclick="editBook({{ $book->id }}, {{ json_encode($book->title) }}, {{ json_encode($book->author) }}, {{ $book->category_id }}, {{ json_encode($book->description) }}, {{ json_encode($book->image) }})">Edit</span>
                                        <span class="mx-1 text-neutral-400">|</span>
                                        <form method="POST" action="{{ route('books.destroy', $book->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?')">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <button type="submit" class="text-red-800 dark:text-red-400 cursor-pointer opacity-60">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                        No books found. Archive now!
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Book Modal -->
    <div id="editBookModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="w-full max-w-2xl rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Edit Book</h2>

            <form id="editBookForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Title</label>
                        <input type="text" id="edit_title" name="title" required
                               class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Author</label>
                        <input type="text" id="edit_author" name="author" required
                               class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Genre</label>
                        <select id="edit_category_id" name="category_id" required
                                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            <option value="">Select a genre</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Description</label>
                        <textarea id="edit_description" name="description" required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                        </textarea>
                    </div>
                </div>

                <!-- Book Cover Upload in Edit Modal -->
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                        Select A New Book Cover
                    </label>

                    <!-- Current Book Cover Preview -->
                    <div id="currentImagePreview" class="mb-3"></div>

                    <input
                        type="file"
                        id="edit_image"
                        name="image"
                        accept="image/jpeg,image/png,image/jpg"
                        class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-red-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-red-500 hover:file:bg-red-100 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100 dark:file:bg-red-900/20 dark:file:text-gray">
                    <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                        Leave empty to keep current book cover. JPG, PNG or JPEG. Max 2MB.
                    </p>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditBookModal()"
                            class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-200 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Cancel
                    </button>
                    <button type="submit"
                            class="rounded-lg bg-red-800 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-500/50 dark:hover:bg-red-300 dark:hover:text-gray-800">
                        Update Book
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
            function editBook(id, title, author, category_id, description, image) {
            document.getElementById('editBookModal').classList.remove('hidden');
            document.getElementById('editBookModal').classList.add('flex');
            document.getElementById('editBookForm').action = `/books/${id}`;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_author').value = author;
            document.getElementById('edit_category_id').value = category_id || '';
            document.getElementById('edit_description').value = description;

            const imagePreview = document.getElementById('currentImagePreview');
            if (image && typeof image === 'string' && image.trim() !== '') {
                imagePreview.innerHTML = `
                    <div class="flex items-center gap-3 rounded-lg border border-neutral-200 p-3 dark:border-neutral-700">
                        <img src="/storage/${image}" alt="${title}" class="h-16 w-16 rounded object-cover">
                        <div>
                            <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Current Book Cover</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Upload new book cover to replace</p>
                        </div>
                    </div>
                `;
            } else {
                imagePreview.innerHTML = `
                    <div class="rounded-lg border border-dashed border-neutral-300 p-4 text-center dark:border-neutral-600">
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">No book cover uploaded</p>
                    </div>
                `;
            }
        }

        function closeEditBookModal() {
            document.getElementById('editBookModal').classList.add('hidden');
            document.getElementById('editBookModal').classList.remove('flex');
        }
    </script>

</x-layouts.app>