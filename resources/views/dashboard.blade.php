<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('JobYaari Notification Terminal') }}
            </h2>
            <a href="{{ route('admin.blogs.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold uppercase tracking-widest px-4 py-2.5 rounded-xl transition shadow-sm">
                + Create New Alert Notice
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#FAF6F0] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-medium shadow-xs">
                    ✓ {{ session('success') }}
                </div>
            @endif

            {{-- Stats Row --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="bg-white border border-orange-100/40 rounded-2xl p-5 flex items-center space-x-4 shadow-xs">
                    <div class="bg-orange-50 p-3 rounded-xl text-xl">📝</div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Blogs</p>
                        <p class="text-2xl font-black text-gray-900">{{ $blogs->count() }}</p>
                    </div>
                </div>
                <div class="bg-white border border-orange-100/40 rounded-2xl p-5 flex items-center space-x-4 shadow-xs">
                    <div class="bg-blue-50 p-3 rounded-xl text-xl">🎫</div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Admit Cards</p>
                        <p class="text-2xl font-black text-gray-900">{{ $blogs->where('category', 'Admit Card')->count() }}</p>
                    </div>
                </div>
                <div class="bg-white border border-orange-100/40 rounded-2xl p-5 flex items-center space-x-4 shadow-xs">
                    <div class="bg-amber-50 p-3 rounded-xl text-xl">📊</div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Results</p>
                        <p class="text-2xl font-black text-gray-900">{{ $blogs->where('category', 'Result')->count() }}</p>
                    </div>
                </div>
            </div>

            {{-- Blog Table --}}
            <div class="bg-white overflow-hidden shadow-xs border border-orange-100/30 rounded-[24px]">
                <div class="p-6 bg-white border-b border-gray-100">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Current Active Live Broadcast Stream</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 text-gray-400 text-[10px] font-black uppercase tracking-widest bg-gray-50/50">
                                    <th class="py-4 px-4">Preview</th>
                                    <th class="py-4 px-4">Title</th>
                                    <th class="py-4 px-4">Category</th>
                                    <th class="py-4 px-4">Date</th>
                                    <th class="py-4 px-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                @forelse($blogs as $blog)
                                    @php
                                        $badgeClass = match($blog->category) {
                                            'Admit Card' => 'bg-blue-50 text-blue-700 border border-blue-200/50',
                                            'Result'     => 'bg-amber-50 text-amber-700 border border-amber-200/50',
                                            'Jobs'       => 'bg-emerald-50 text-emerald-700 border border-emerald-200/50',
                                            'Syllabus'   => 'bg-purple-50 text-purple-700 border border-purple-200/50',
                                            'Answer Key' => 'bg-rose-50 text-rose-700 border border-rose-200/50',
                                            default      => 'bg-gray-50 text-gray-700 border border-gray-200/50',
                                        };
                                    @endphp
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="py-4 px-4">
                                            <div class="w-16 h-12 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center border border-gray-200/40">
                                                @if(filter_var($blog->image, FILTER_VALIDATE_URL))
                                                    <img src="{{ $blog->image }}" class="object-cover w-full h-full">
                                                @elseif(!empty($blog->image))
                                                    <img src="{{ asset($blog->image) }}" class="object-cover w-full h-full">
                                                @else
                                                    <span class="text-lg">🎫</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 font-medium text-gray-900 max-w-xs">
                                            <p class="truncate max-w-[220px]">{{ $blog->title }}</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5 truncate max-w-[220px]">{{ $blog->short_description }}</p>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-md {{ $badgeClass }}">
                                                {{ $blog->category }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-xs text-gray-400 font-medium">
                                            {{ $blog->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="py-4 px-4 text-right whitespace-nowrap">
                                            <div class="flex justify-end items-center space-x-2">
                                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-xs bg-gray-100 hover:bg-orange-500 hover:text-white text-gray-700 font-bold px-3 py-1.5 rounded-lg transition">Edit</a>
                                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Permanently delete this blog?');" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs bg-red-50 hover:bg-red-600 text-red-600 hover:text-white font-bold px-3 py-1.5 rounded-lg transition border border-red-200/30">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-16 text-gray-400 text-xs font-light">
                                            No notices yet. Click <strong>+ Create New Alert Notice</strong> above to get started.
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
</x-app-layout>