<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modify Existing System Notice Log') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#FAF6F0] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs border border-orange-100/30 rounded-[24px] p-8">

                {{-- Current image preview --}}
                @if($blog->image)
                <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Current Image</p>
                    @if(filter_var($blog->image, FILTER_VALIDATE_URL))
                        <img src="{{ $blog->image }}" class="h-32 rounded-lg object-cover">
                    @else
                        <img src="{{ asset($blog->image) }}" class="h-32 rounded-lg object-cover">
                    @endif
                </div>
                @endif

                <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Notice Header Title</label>
                        <input type="text" name="title" required value="{{ old('title', $blog->title) }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-orange-500">
                        @error('title') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Category</label>
                        <select name="category" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-orange-500 cursor-pointer">
                            <option value="Admit Card" {{ $blog->category === 'Admit Card' ? 'selected' : '' }}>Admit Card</option>
                            <option value="Result"     {{ $blog->category === 'Result'     ? 'selected' : '' }}>Result</option>
                            <option value="Jobs"       {{ $blog->category === 'Jobs'       ? 'selected' : '' }}>Jobs</option>
                            <option value="Syllabus"   {{ $blog->category === 'Syllabus'   ? 'selected' : '' }}>Syllabus</option>
                            <option value="Answer Key" {{ $blog->category === 'Answer Key' ? 'selected' : '' }}>Answer Key</option>
                        </select>
                        @error('category') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Short Description</label>
                        <textarea name="short_description" rows="2" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-orange-500">{{ old('short_description', $blog->short_description) }}</textarea>
                        @error('short_description') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Full Content Body</label>
                        <textarea name="content" rows="8" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-1 focus:ring-orange-500">{{ old('content', $blog->content) }}</textarea>
                        @error('content') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Replace Image (optional)</label>
                        <input type="file" name="image" accept="image/*" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        <span class="text-[10px] text-gray-400 mt-1 block">Leave empty to keep the existing image.</span>
                        @error('image') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex items-center justify-end space-x-3 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" class="text-xs font-bold uppercase tracking-wider text-gray-500 hover:text-gray-900 transition px-4 py-2">Cancel</a>
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold uppercase tracking-widest px-6 py-3 rounded-full transition shadow-md">Save Changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
