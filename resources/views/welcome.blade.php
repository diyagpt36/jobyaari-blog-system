<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobYaari — Premium Career & Job Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .serif-title { font-family: 'Playfair Display', serif; }
        #blog-grid { transition: opacity 0.2s ease; }
        .carousel-slide { display: none; }
        .carousel-slide.active { display: flex; animation: fadeSlide 0.6s ease; }
        @keyframes fadeSlide { from { opacity: 0; } to { opacity: 1; } }
        .ph-admit   { background: linear-gradient(135deg,#1e3a5f,#2d6a9f); }
        .ph-result  { background: linear-gradient(135deg,#7c2d12,#ea580c); }
        .ph-jobs    { background: linear-gradient(135deg,#14532d,#16a34a); }
        .ph-syllabus{ background: linear-gradient(135deg,#4c1d95,#7c3aed); }
        .ph-answer  { background: linear-gradient(135deg,#831843,#db2777); }
        .ph-default { background: linear-gradient(135deg,#1f2937,#374151); }
        .nav-link { cursor: pointer; }
        .nav-link.active-nav { color: #111827; border-bottom: 2px solid #f97316; padding-bottom: 4px; }
    </style>
</head>
<body class="bg-[#FAF6F0] text-gray-800 antialiased selection:bg-orange-100">

<header class="bg-white/90 backdrop-blur-md border-b border-orange-100/50 sticky top-0 z-50 shadow-xs">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-2xl font-black tracking-tight text-gray-900">Job<span class="text-orange-600">Yaari.</span></a>
        <nav class="hidden md:flex space-x-8 text-xs font-bold uppercase tracking-wider text-gray-500">
            <a href="{{ route('home') }}" class="nav-link active-nav" data-category="">Home</a>
            <a href="#" class="nav-link hover:text-gray-900 transition" data-category="Admit Card">Admit Cards</a>
            <a href="#" class="nav-link hover:text-gray-900 transition" data-category="Result">Exam Results</a>
            <a href="#" class="nav-link hover:text-gray-900 transition" data-category="Jobs">Jobs</a>
            <a href="#" class="nav-link hover:text-gray-900 transition" data-category="">All Notices</a>
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

<main class="max-w-7xl mx-auto px-6 py-10">

    {{-- HERO CAROUSEL --}}
    @if($featuredBlogs->count() > 0)
    <div class="relative w-full h-[520px] rounded-[32px] overflow-hidden shadow-lg border border-orange-100/30 mb-12" id="hero-carousel">

        @foreach($featuredBlogs as $i => $slide)
            @php
                $isUrl  = filter_var($slide->image, FILTER_VALIDATE_URL);
                $clean  = ltrim($slide->image ?? '', '/');
                $isFile = !empty($slide->image) && file_exists(public_path($clean));
                $phClass = match($slide->category) {
                    'Admit Card' => 'ph-admit',
                    'Result'     => 'ph-result',
                    'Jobs'       => 'ph-jobs',
                    'Syllabus'   => 'ph-syllabus',
                    'Answer Key' => 'ph-answer',
                    default      => 'ph-default',
                };
                $phIcon = match($slide->category) {
                    'Admit Card' => '🎫', 'Result' => '📊', 'Jobs' => '💼',
                    'Syllabus'   => '📚', 'Answer Key' => '🗝️', default => '📰',
                };
            @endphp
            <div class="carousel-slide absolute inset-0 w-full h-full flex items-end {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}">
                @if($isUrl)
                    <img src="{{ $slide->image }}" class="absolute inset-0 w-full h-full object-cover">
                @elseif($isFile)
                    <img src="{{ asset($clean) }}" class="absolute inset-0 w-full h-full object-cover">
                @else
                    <div class="absolute inset-0 {{ $phClass }}">
                        <div class="absolute inset-0 opacity-5 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:28px_28px]"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-[140px] opacity-10 select-none leading-none">{{ $phIcon }}</span>
                        </div>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-900/50 to-transparent"></div>
                <div class="relative z-10 p-8 md:p-14 w-full max-w-3xl text-white pb-14">
                    <div class="mb-4">
                        <span class="bg-orange-500 text-white text-[10px] font-black uppercase tracking-widest px-3.5 py-1.5 rounded-full">
                            ★ HOT UPDATE: {{ $slide->category }}
                        </span>
                    </div>
                    <h2 class="serif-title text-3xl md:text-5xl font-medium leading-tight mb-4 tracking-tight">{{ $slide->title }}</h2>
                    <p class="text-sm text-gray-200 line-clamp-2 mb-6 font-light max-w-2xl leading-relaxed">{{ $slide->short_description }}</p>
                    <div class="flex items-center justify-between border-t border-white/10 pt-5">
                        <span class="text-xs text-gray-300 font-medium">Published: {{ $slide->created_at->format('M d, Y') }}</span>
                        <a href="{{ route('blog.show', $slide->id) }}" class="text-xs font-bold uppercase tracking-wider bg-white text-gray-900 px-6 py-3 rounded-full hover:bg-orange-500 hover:text-white transition shadow-md">Read Article</a>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Dot indicators --}}
        <div class="absolute bottom-5 right-8 z-20 flex space-x-2">
            @foreach($featuredBlogs as $i => $dot)
                <button class="carousel-dot h-2 rounded-full transition-all duration-300 {{ $i === 0 ? 'bg-orange-500 w-6' : 'bg-white/40 w-2' }}" data-target="{{ $i }}"></button>
            @endforeach
        </div>

        {{-- Arrows --}}
        <button id="carousel-prev" class="absolute left-5 top-1/2 -translate-y-1/2 z-20 bg-white/10 hover:bg-white/25 backdrop-blur-sm text-white w-10 h-10 rounded-full flex items-center justify-center transition text-lg">&#8592;</button>
        <button id="carousel-next" class="absolute right-5 top-1/2 -translate-y-1/2 z-20 bg-white/10 hover:bg-white/25 backdrop-blur-sm text-white w-10 h-10 rounded-full flex items-center justify-center transition text-lg">&#8594;</button>
    </div>
    @endif

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white border border-orange-100/40 rounded-2xl p-6 flex items-center space-x-4 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition duration-300 cursor-pointer" onclick="filterByCategory('Admit Card')">
            <div class="bg-orange-50 p-3.5 rounded-xl text-xl">🎫</div>
            <div><h4 class="text-sm font-bold text-gray-900">Admit Cards Hub</h4><p class="text-xs text-gray-400 mt-0.5">Instant downloads & dates</p></div>
        </div>
        <div class="bg-white border border-orange-100/40 rounded-2xl p-6 flex items-center space-x-4 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition duration-300 cursor-pointer" onclick="filterByCategory('Result')">
            <div class="bg-amber-50 p-3.5 rounded-xl text-xl">📊</div>
            <div><h4 class="text-sm font-bold text-gray-900">Results Tracker</h4><p class="text-xs text-gray-400 mt-0.5">Cut-off scores & scorecards</p></div>
        </div>
        <div class="bg-white border border-orange-100/40 rounded-2xl p-6 flex items-center space-x-4 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition duration-300 cursor-pointer" onclick="filterByCategory('Jobs')">
            <div class="bg-emerald-50 p-3.5 rounded-xl text-xl">💬</div>
            <div><h4 class="text-sm font-bold text-gray-900">Jobs Portal</h4><p class="text-xs text-gray-400 mt-0.5">Latest vacancies & openings</p></div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-gray-950 rounded-2xl p-4 border border-gray-800 mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 shadow-lg">
        <span class="text-xs font-black text-gray-400 uppercase tracking-widest pl-2">Filter & Sort Stream</span>
        <div class="flex flex-wrap gap-3">
            <input type="text" id="search-input" placeholder="Search notices..."
                class="bg-gray-900 border border-gray-800 rounded-xl px-4 py-2.5 text-xs font-bold text-gray-300 focus:ring-1 focus:ring-orange-500 focus:outline-none placeholder-gray-600 w-44">
            <select id="category-filter" class="bg-gray-900 border border-gray-800 rounded-xl px-4 py-2.5 text-xs font-bold text-gray-300 focus:ring-1 focus:ring-orange-500 focus:outline-none cursor-pointer">
                <option value="">All Categories</option>
                <option value="Admit Card">Admit Cards</option>
                <option value="Result">Results</option>
                <option value="Jobs">Jobs</option>
                <option value="Syllabus">Syllabus</option>
                <option value="Answer Key">Answer Key</option>
            </select>
            <select id="date-sort" class="bg-gray-900 border border-gray-800 rounded-xl px-4 py-2.5 text-xs font-bold text-gray-300 focus:ring-1 focus:ring-orange-500 focus:outline-none cursor-pointer">
                <option value="latest">Newest First</option>
                <option value="oldest">Oldest First</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

        {{-- Blog Grid --}}
        <div id="blog-grid" class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($blogs as $blog)
                @php
                    $isBlogUrl  = filter_var($blog->image, FILTER_VALIDATE_URL);
                    $cleanBlog  = ltrim($blog->image ?? '', '/');
                    $isBlogFile = !empty($blog->image) && file_exists(public_path($cleanBlog));
                    $cph = match($blog->category) {
                        'Admit Card' => 'ph-admit', 'Result' => 'ph-result', 'Jobs' => 'ph-jobs',
                        'Syllabus'   => 'ph-syllabus', 'Answer Key' => 'ph-answer', default => 'ph-default',
                    };
                    $cicon = match($blog->category) {
                        'Admit Card' => '🎫', 'Result' => '📊', 'Jobs' => '💼',
                        'Syllabus'   => '📚', 'Answer Key' => '🗝️', default => '📰',
                    };
                @endphp
                <div class="bg-white rounded-2xl border border-orange-100/20 overflow-hidden shadow-xs hover:shadow-md hover:-translate-y-1 transition duration-300 flex flex-col">
                    <div class="relative h-48 w-full overflow-hidden flex items-center justify-center">
                        @if($isBlogUrl)
                            <img src="{{ $blog->image }}" alt="Notice" class="w-full h-full object-cover">
                        @elseif($isBlogFile)
                            <img src="{{ asset($cleanBlog) }}" alt="Notice" class="w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 {{ $cph }}">
                                <div class="absolute inset-0 opacity-5 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-6xl opacity-20 select-none">{{ $cicon }}</span>
                                </div>
                            </div>
                        @endif
                        <span class="absolute top-4 left-4 bg-white/95 text-gray-900 text-[10px] font-black tracking-widest px-3 py-1.5 rounded-xl uppercase border border-gray-100 shadow-xs z-10">{{ $blog->category }}</span>
                    </div>
                    <div class="p-6 flex flex-col flex-grow justify-between min-h-[220px]">
                        <div>
                            <h3 class="serif-title text-xl font-semibold text-gray-900 leading-snug mb-3 hover:text-orange-600 transition line-clamp-2">
                                <a href="{{ route('blog.show', $blog->id) }}">{{ $blog->title }}</a>
                            </h3>
                            <p class="text-xs text-gray-400 font-light leading-relaxed mb-4 line-clamp-3">{{ $blog->short_description }}</p>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-50 pt-4 mt-auto">
                            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">{{ $blog->created_at->format('M d, Y') }}</span>
                            <a href="{{ route('blog.show', $blog->id) }}" class="text-xs font-bold text-orange-600 hover:text-gray-900 transition">Read Full Details &rarr;</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white border border-orange-100/30 text-center py-16 text-gray-400 rounded-2xl font-medium">No active updates listed under this criteria.</div>
            @endforelse
        </div>

        {{-- Sidebar --}}
        <div class="space-y-8 lg:sticky lg:top-28">
            <div class="bg-white border border-orange-100/30 rounded-2xl p-6 shadow-xs text-center relative overflow-hidden">
                <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-orange-500 to-amber-500"></div>
                <div class="w-20 h-20 bg-orange-50 rounded-full mx-auto mb-4 flex items-center justify-center border-2 border-white shadow-md">
                    <span class="serif-title font-black text-2xl text-orange-600">JY</span>
                </div>
                <h4 class="serif-title text-lg font-bold text-gray-900">JobYaari Dashboard</h4>
                <span class="text-[10px] font-bold tracking-widest text-orange-600 uppercase">Verified Verification Bureau</span>
                <p class="text-xs text-gray-400 font-light leading-relaxed mt-3 px-2">Welcome to your premium notification terminal. We actively verify daily employment alerts for your rapid success.</p>
            </div>

            <div class="bg-white border border-orange-100/30 rounded-2xl p-6 shadow-xs">
                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 border-b border-gray-50 pb-2">Category Stream</h4>
                <div class="flex flex-wrap gap-1.5">
                    @foreach(['Admit Card','Result','Jobs','Syllabus','Answer Key'] as $tag)
                        <span onclick="filterByCategory('{{ $tag }}')" class="bg-gray-50 text-gray-600 hover:bg-orange-500 hover:text-white transition cursor-pointer text-[10px] font-bold px-3.5 py-1.5 rounded-full border border-gray-200/60">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>

            <div class="bg-gray-950 text-white rounded-2xl p-6 shadow-md">
                <h4 class="serif-title text-lg font-medium tracking-tight mb-2">Subscribe for Alerts</h4>
                <p class="text-xs text-gray-400 font-light leading-relaxed mb-4">Get immediate PDF notices sent straight to your email inbox.</p>
                <form onsubmit="event.preventDefault();" class="space-y-2">
                    <input type="email" placeholder="Your email address..." class="w-full bg-white/10 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-orange-500">
                    <button class="w-full bg-orange-500 hover:bg-orange-600 text-white text-xs font-black uppercase tracking-widest py-2.5 rounded-xl transition">Join Registry</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
$(document).ready(function () {

    // ── CAROUSEL ──────────────────────────────────────────
    let cur = 0;
    const slides = $('.carousel-slide');
    const dots   = $('.carousel-dot');
    const total  = slides.length;

    function goTo(n) {
        slides.removeClass('active').hide();
        dots.removeClass('bg-orange-500 w-6').addClass('bg-white/40 w-2');
        cur = (n + total) % total;
        $(slides[cur]).addClass('active').show();
        $(dots[cur]).addClass('bg-orange-500 w-6').removeClass('bg-white/40 w-2');
    }

    goTo(0);
    let timer = setInterval(() => goTo(cur + 1), 4000);

    $('#carousel-next').on('click', function() { clearInterval(timer); goTo(cur+1); timer = setInterval(()=>goTo(cur+1),4000); });
    $('#carousel-prev').on('click', function() { clearInterval(timer); goTo(cur-1); timer = setInterval(()=>goTo(cur+1),4000); });
    dots.on('click', function() { clearInterval(timer); goTo($(this).data('target')); timer = setInterval(()=>goTo(cur+1),4000); });

    // ── AJAX FILTER ───────────────────────────────────────
    const appUrl = "{{ url('/') }}/";
    const phMap  = {
        'Admit Card': { cls:'ph-admit',    icon:'🎫' },
        'Result':     { cls:'ph-result',   icon:'📊' },
        'Jobs':       { cls:'ph-jobs',     icon:'💼' },
        'Syllabus':   { cls:'ph-syllabus', icon:'📚' },
        'Answer Key': { cls:'ph-answer',   icon:'🗝️' },
    };

    function fetchBlogs() {
        $('#blog-grid').css('opacity','0.5');
        $.ajax({
            url: "{{ route('home') }}",
            type: "GET",
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            data: {
                category: $('#category-filter').val(),
                date_sort: $('#date-sort').val(),
                search:    $('#search-input').val()
            },
            dataType: "json",
            success: function(res) {
                let grid = $('#blog-grid').empty();
                if (!res.blogs.length) {
                    grid.append('<div class="col-span-full bg-white border border-orange-100/30 text-center py-16 text-gray-400 rounded-2xl font-medium">No active updates listed under this criteria.</div>');
                } else {
                    $.each(res.blogs, function(i, blog) {
                        let date = new Date(blog.created_at).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'});
                        let imgHtml = '';
                        if (blog.image && blog.image.trim().length > 2) {
                            let src = (blog.image.startsWith('http')?blog.image:appUrl+blog.image.replace(/^\/+/,''));
                            imgHtml = `<img src="${src}" alt="Notice" class="w-full h-full object-cover">`;
                        } else {
                            let p = phMap[blog.category] || {cls:'ph-default',icon:'📰'};
                            imgHtml = `<div class="absolute inset-0 ${p.cls}"><div class="absolute inset-0 opacity-5 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div><div class="absolute inset-0 flex items-center justify-center"><span class="text-6xl opacity-20 select-none">${p.icon}</span></div></div>`;
                        }
                        grid.append(`
                            <div class="bg-white rounded-2xl border border-orange-100/20 overflow-hidden shadow-xs hover:shadow-md hover:-translate-y-1 transition duration-300 flex flex-col">
                                <div class="relative h-48 w-full overflow-hidden flex items-center justify-center">
                                    ${imgHtml}
                                    <span class="absolute top-4 left-4 bg-white/90 text-gray-900 text-[10px] font-black tracking-widest px-3 py-1.5 rounded-xl uppercase border border-gray-100 shadow-xs z-10">${blog.category}</span>
                                </div>
                                <div class="p-6 flex flex-col flex-grow justify-between min-h-[220px]">
                                    <div>
                                        <h3 class="serif-title text-xl font-semibold text-gray-900 leading-snug mb-3 hover:text-orange-600 transition line-clamp-2"><a href="/blog/${blog.id}">${blog.title}</a></h3>
                                        <p class="text-xs text-gray-400 font-light leading-relaxed mb-4 line-clamp-3">${blog.short_description}</p>
                                    </div>
                                    <div class="flex items-center justify-between border-t border-gray-50 pt-4 mt-auto">
                                        <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">${date}</span>
                                        <a href="/blog/${blog.id}" class="text-xs font-bold text-orange-600 hover:text-gray-900 transition">Read Full Details &rarr;</a>
                                    </div>
                                </div>
                            </div>`);
                    });
                }
                grid.css('opacity','1');
            },
            error: function() { $('#blog-grid').css('opacity','1'); }
        });
    }

    $('#category-filter, #date-sort').on('change', fetchBlogs);
    let st;
    $('#search-input').on('keyup', function() { clearTimeout(st); st = setTimeout(fetchBlogs, 400); });

    // ── NAV LINK FILTER ───────────────────────────────────
    // When a nav link is clicked, set the dropdown and fire the filter
    $('.nav-link').on('click', function(e) {
        e.preventDefault();
        let cat = $(this).data('category');

        // Update active style on nav
        $('.nav-link').removeClass('active-nav text-gray-900').addClass('text-gray-500');
        $(this).addClass('active-nav text-gray-900').removeClass('text-gray-500');

        // Set dropdown to match
        $('#category-filter').val(cat);

        // Fire AJAX filter
        fetchBlogs();

        // Smooth scroll down to blog grid
        $('html, body').animate({ scrollTop: $('#blog-grid').offset().top - 100 }, 400);
    });
});

// Global function so stat cards can also call it
window.filterByCategory = function(cat) {
    $('#category-filter').val(cat);

    // Update nav active state
    $('.nav-link').removeClass('active-nav text-gray-900').addClass('text-gray-500');
    $('.nav-link[data-category="' + cat + '"]').addClass('active-nav text-gray-900').removeClass('text-gray-500');

    // Trigger change to fire fetchBlogs
    $('#category-filter').trigger('change');

    // Smooth scroll to blog grid
    $('html, body').animate({ scrollTop: $('#blog-grid').offset().top - 100 }, 400);
};
</script>
</body>
</html>