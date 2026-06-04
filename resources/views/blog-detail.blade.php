<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->title }} — JobYaari</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .serif-title { font-family: 'Playfair Display', serif; }
        .ph-admit    { background: linear-gradient(135deg,#1e3a5f,#2d6a9f); }
        .ph-result   { background: linear-gradient(135deg,#7c2d12,#ea580c); }
        .ph-jobs     { background: linear-gradient(135deg,#14532d,#16a34a); }
        .ph-syllabus { background: linear-gradient(135deg,#4c1d95,#7c3aed); }
        .ph-answer   { background: linear-gradient(135deg,#831843,#db2777); }
        .ph-default  { background: linear-gradient(135deg,#1f2937,#374151); }
        .prose-content p  { margin-bottom: 1rem; line-height: 1.8; }
        .prose-content br { display: block; margin-bottom: 0.5rem; }
    </style>
</head>
<body class="bg-[#FAF6F0] text-gray-800 antialiased">

    {{-- Header --}}
    <header class="bg-white/90 backdrop-blur-md border-b border-orange-100/50 sticky top-0 z-50 shadow-xs">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-black tracking-tight text-gray-900">Job<span class="text-orange-600">Yaari.</span></a>
            <nav class="hidden md:flex space-x-8 text-xs font-bold uppercase tracking-wider text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-gray-900 transition">Home</a>
                <a href="#" class="hover:text-gray-900 transition">Admit Cards</a>
                <a href="#" class="hover:text-gray-900 transition">Exam Results</a>
                <a href="#" class="hover:text-gray-900 transition">About Portal</a>
            </nav>
            <div>
                @if(Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-xs font-bold uppercase tracking-wider bg-gray-900 text-white px-5 py-2.5 rounded-full hover:bg-orange-600 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-wider text-gray-600 hover:text-gray-900 transition">Admin Login</a>
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-12">

        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-xs text-gray-400 font-medium mb-8">
            <a href="{{ route('home') }}" class="hover:text-orange-600 transition">Home</a>
            <span>/</span>
            <span class="text-gray-600">{{ $blog->category }}</span>
            <span>/</span>
            <span class="text-gray-400 truncate max-w-[200px]">{{ $blog->title }}</span>
        </nav>

        {{-- Hero image / placeholder --}}
        @php
            $isUrl  = filter_var($blog->image, FILTER_VALIDATE_URL);
            $clean  = ltrim($blog->image ?? '', '/');
            $isFile = !empty($blog->image) && file_exists(public_path($clean));
            $phClass = match($blog->category) {
                'Admit Card' => 'ph-admit',
                'Result'     => 'ph-result',
                'Jobs'       => 'ph-jobs',
                'Syllabus'   => 'ph-syllabus',
                'Answer Key' => 'ph-answer',
                default      => 'ph-default',
            };
            $phIcon = match($blog->category) {
                'Admit Card' => '🎫', 'Result' => '📊', 'Jobs' => '💼',
                'Syllabus'   => '📚', 'Answer Key' => '🗝️', default => '📰',
            };
        @endphp

        <div class="w-full h-72 md:h-96 rounded-[24px] overflow-hidden mb-10 relative flex items-center justify-center">
            @if($isUrl)
                <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
            @elseif($isFile)
                <img src="{{ asset($clean) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
            @else
                <div class="absolute inset-0 {{ $phClass }}">
                    <div class="absolute inset-0 opacity-5 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:28px_28px]"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-[120px] opacity-10 select-none leading-none">{{ $phIcon }}</span>
                    </div>
                </div>
            @endif
            {{-- Gradient overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-gray-950/60 to-transparent"></div>
            {{-- Category badge on image --}}
            <div class="absolute bottom-6 left-6">
                <span class="bg-orange-500 text-white text-[10px] font-black uppercase tracking-widest px-3.5 py-1.5 rounded-full">
                    ★ {{ $blog->category }}
                </span>
            </div>
        </div>

        {{-- Article --}}
        <article class="bg-white rounded-[24px] border border-orange-100/20 shadow-xs p-8 md:p-12">

            {{-- Meta --}}
            <div class="flex items-center space-x-4 mb-6">
                <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">
                    {{ $blog->created_at->format('F d, Y') }}
                </span>
                <span class="text-gray-200">|</span>
                <span class="text-[10px] font-bold tracking-widest text-orange-500 uppercase">
                    {{ $blog->category }}
                </span>
            </div>

            {{-- Title --}}
            <h1 class="serif-title text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-6">
                {{ $blog->title }}
            </h1>

            {{-- Short description --}}
            <p class="text-base text-gray-500 font-light leading-relaxed border-l-4 border-orange-400 pl-5 mb-8 italic">
                {{ $blog->short_description }}
            </p>

            {{-- Divider --}}
            <hr class="border-gray-100 mb-8">

            {{-- Full content --}}
            <div class="prose-content text-gray-700 text-sm leading-relaxed">
                {!! nl2br(e($blog->content)) !!}
            </div>

        </article>

        {{-- Back button --}}
        <div class="mt-10 flex justify-between items-center">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-gray-500 hover:text-orange-600 transition">
                <span>&larr;</span> <span>Back to All Notices</span>
            </a>
            <span class="text-[10px] text-gray-300 font-medium">JobYaari — Career Portal</span>
        </div>

    </main>

    {{-- Footer --}}
    <footer class="mt-20 border-t border-gray-100 bg-white">
        <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <span class="text-xl font-black text-gray-900">Job<span class="text-orange-600">Yaari.</span></span>
            <p class="text-xs text-gray-400">© {{ date('Y') }} JobYaari. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>