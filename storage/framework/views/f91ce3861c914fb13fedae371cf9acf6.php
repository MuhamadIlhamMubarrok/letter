<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => 'Digital Story & Wedding CMS — Maja Flower',
    'header' => null
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => 'Digital Story & Wedding CMS — Maja Flower',
    'header' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title); ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('general/logo.png')); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo e(asset('general/logo.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('general/logo.png')); ?>">

    <!-- Performance: DNS Prefetch & Preconnect for External Assets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">

    <!-- Google Fonts: Majaflower Typography (Hedvig Letters Serif, Plus Jakarta Sans, Roboto Mono) -->
    <link href="https://fonts.googleapis.com/css2?family=Hedvig+Letters+Serif:opsz@12..24&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Roboto+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Free SVG & CSS Icons (BucketFlow ERP Standard) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        [x-cloak] { display: none !important; }
        html, body {
            background-color: #111711;
            color: #F8F9F7;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-tap-highlight-color: transparent;
            overflow-x: clip;
            -webkit-overflow-scrolling: touch;
        }
        .touch-target {
            min-height: 44px;
            min-width: 44px;
        }
        .safe-top {
            padding-top: env(safe-area-inset-top, 0px);
        }
        .safe-bottom {
            padding-bottom: max(env(safe-area-inset-bottom, 0px), 10px);
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .ease-spring {
            transition-timing-function: cubic-bezier(0.16, 1, 0.3, 1);
        }
        .ease-spring-in {
            transition-timing-function: cubic-bezier(0.7, 0, 0.84, 0);
        }
        /* BucketFlow Standard Subtle Scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #111711;
        }
        ::-webkit-scrollbar-thumb {
            background: #243324;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #346739;
        }
    </style>
</head>
<body
    x-data="{
        sidebarOpen: false,
        desktopSidebarOpen: (localStorage.getItem('maja_cms_sidebar_open') !== null)
            ? (localStorage.getItem('maja_cms_sidebar_open') === 'true')
            : true,
        toggleSidebar() {
            if (window.innerWidth < 768) {
                this.sidebarOpen = !this.sidebarOpen;
            } else {
                this.desktopSidebarOpen = !this.desktopSidebarOpen;
                localStorage.setItem('maja_cms_sidebar_open', this.desktopSidebarOpen);
            }
        },
        toastMsg: '',
        showToast(msg) {
            this.toastMsg = msg;
            setTimeout(() => this.toastMsg = '', 3200);
        },
        copyText(text, label = 'Teks') {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    this.showToast(label + ' berhasil disalin!');
                });
            } else {
                this.showToast(text);
            }
        },
        quickActionsOpen: false,
        touchStartX: null
    }"
    @keydown.escape="sidebarOpen = false; quickActionsOpen = false"
    class="bg-canvas text-gray-100 antialiased min-h-screen flex flex-col selection:bg-primary selection:text-cream"
>
    <!-- GLOBAL TOAST NOTIFICATION -->
    <div
        x-show="toastMsg"
        x-cloak
        x-transition:enter="transition duration-400 ease-spring transform will-change-transform"
        x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition duration-300 ease-spring-in transform will-change-transform"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
        class="fixed top-4 left-1/2 -translate-x-1/2 z-50 px-5 py-3 rounded-xl bg-primary/30 border border-secondary/40 text-cream text-xs font-mono font-semibold shadow-2xl shadow-black/60 backdrop-blur-md flex items-center gap-2.5 pointer-events-none"
    >
        <i class="fa-solid fa-circle-check text-accent text-sm"></i>
        <span x-text="toastMsg"></span>
    </div>

    <!-- 1. MOBILE OFF-CANVAS SLIDING DRAWER (BucketFlow Standard) -->
    <div
        x-cloak
        x-show="sidebarOpen"
        class="fixed inset-0 z-50 md:hidden"
        role="dialog"
        aria-modal="true"
    >
        <!-- Dark Backdrop Blur -->
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-out duration-500"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/80 backdrop-blur-md"
        ></div>

        <!-- Sliding Drawer Panel -->
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition duration-500 ease-spring transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition duration-350 ease-spring-in transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            @touchstart="touchStartX = $event.touches[0].clientX"
            @touchmove="if (touchStartX && ($event.touches[0].clientX - touchStartX) < -50) { sidebarOpen = false; touchStartX = null; }"
            @touchend="touchStartX = null"
            class="relative flex flex-col w-80 max-w-[85vw] h-full bg-surface-card border-r border-border-subtle p-5 shadow-2xl will-change-transform select-none"
        >
            <!-- Drawer Header -->
            <div class="flex items-center justify-between pb-5 border-b border-border-subtle">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-primary to-secondary flex items-center justify-center text-cream shadow-lg shadow-primary/40">
                        <i class="fa-solid fa-envelope-open-text text-lg"></i>
                    </div>
                    <div>
                        <h2 class="font-heading font-bold text-lg tracking-wider text-cream">maja flower</h2>
                        <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-primary/30 text-accent font-semibold border border-primary/40">
                            SURAT & UNDANGAN CMS
                        </span>
                    </div>
                </div>
                <button
                    @click="sidebarOpen = false"
                    type="button"
                    class="touch-target flex items-center justify-center w-10 h-10 rounded-lg text-neutral-400 hover:text-cream hover:bg-white/10 transition-colors"
                    aria-label="Tutup menu"
                >
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation Links in Drawer -->
            <nav class="flex-1 overflow-y-auto py-5 space-y-1.5">
                <div class="px-3 py-1 text-[10px] font-mono font-bold tracking-widest text-accent/70 uppercase">Konsol Utama</div>

                <a
                    href="<?php echo e(route('admin.digital-stories.index')); ?>"
                    class="flex items-center space-x-3.5 px-3.5 py-3 rounded-xl <?php echo e(request()->routeIs('admin.digital-stories.index') && !request('fulfillment_status') && !request('type') && !request('story_type') ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> transition-all text-sm"
                >
                    <i class="fa-solid fa-chart-pie w-5 <?php echo e(request()->routeIs('admin.digital-stories.index') && !request('fulfillment_status') && !request('type') && !request('story_type') ? 'text-accent' : 'text-neutral-400'); ?>"></i>
                    <span>Pipeline Pesanan</span>
                </a>

                <a
                    href="<?php echo e(route('admin.digital-stories.create')); ?>"
                    class="flex items-center space-x-3.5 px-3.5 py-3 rounded-xl <?php echo e(request()->routeIs('admin.digital-stories.create') ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> transition-all text-sm"
                >
                    <i class="fa-solid fa-circle-plus w-5 <?php echo e(request()->routeIs('admin.digital-stories.create') ? 'text-accent' : 'text-neutral-400'); ?>"></i>
                    <span>Input Pesanan Baru</span>
                </a>

                <a
                    href="<?php echo e(route('admin.digital-stories.templates')); ?>"
                    class="flex items-center space-x-3.5 px-3.5 py-3 rounded-xl <?php echo e(request()->routeIs('admin.digital-stories.templates') ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> transition-all text-sm"
                >
                    <i class="fa-solid fa-palette w-5 <?php echo e(request()->routeIs('admin.digital-stories.templates') ? 'text-accent' : 'text-neutral-400'); ?>"></i>
                    <span>8 Katalog Template</span>
                </a>

                <!-- Format Produk -->
                <div class="pt-4 px-3 py-1 text-[10px] font-mono font-bold tracking-widest text-accent/70 uppercase">Format Produk</div>

                <a
                    href="<?php echo e(route('admin.digital-stories.index', ['story_type' => 'love_letter'])); ?>"
                    class="flex items-center space-x-3.5 px-3.5 py-2.5 rounded-xl <?php echo e(in_array(request('story_type') ?? request('type'), ['love_letter']) ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> transition-all text-sm"
                >
                    <i class="fa-solid fa-heart w-5 <?php echo e(in_array(request('story_type') ?? request('type'), ['love_letter']) ? 'text-accent' : 'text-neutral-400'); ?>"></i>
                    <span>Surat Cinta Buket</span>
                </a>

                <a
                    href="<?php echo e(route('admin.digital-stories.index', ['story_type' => 'wedding_invitation'])); ?>"
                    class="flex items-center space-x-3.5 px-3.5 py-2.5 rounded-xl <?php echo e(in_array(request('story_type') ?? request('type'), ['wedding_invitation']) ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> transition-all text-sm"
                >
                    <i class="fa-solid fa-ring w-5 <?php echo e(in_array(request('story_type') ?? request('type'), ['wedding_invitation']) ? 'text-accent' : 'text-neutral-400'); ?>"></i>
                    <span>Undangan Pernikahan</span>
                </a>

                <!-- Tahap Tindak Lanjut / Fulfillment -->
                <div class="pt-4 px-3 py-1 text-[10px] font-mono font-bold tracking-widest text-accent/70 uppercase">Alur Pengerjaan CMS</div>

                <a
                    href="<?php echo e(route('admin.digital-stories.index', ['fulfillment_status' => 'pending_content'])); ?>"
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl <?php echo e(request('fulfillment_status') === 'pending_content' ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> transition-all text-sm"
                >
                    <div class="flex items-center space-x-3.5">
                        <i class="fa-solid fa-clock w-5 text-amber-400"></i>
                        <span>Perlu Konten (WA)</span>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                </a>

                <a
                    href="<?php echo e(route('admin.digital-stories.index', ['fulfillment_status' => 'drafting'])); ?>"
                    class="flex items-center space-x-3.5 px-3.5 py-2.5 rounded-xl <?php echo e(request('fulfillment_status') === 'drafting' ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> transition-all text-sm"
                >
                    <i class="fa-solid fa-pen-ruler w-5 text-neutral-400"></i>
                    <span>Sedang Draf / Desain</span>
                </a>

                <a
                    href="<?php echo e(route('admin.digital-stories.index', ['fulfillment_status' => 'customer_review'])); ?>"
                    class="flex items-center space-x-3.5 px-3.5 py-2.5 rounded-xl <?php echo e(request('fulfillment_status') === 'customer_review' ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> transition-all text-sm"
                >
                    <i class="fa-solid fa-eye w-5 text-neutral-400"></i>
                    <span>Review Client</span>
                </a>

                <a
                    href="<?php echo e(route('admin.digital-stories.index', ['fulfillment_status' => 'ready_to_print'])); ?>"
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl <?php echo e(request('fulfillment_status') === 'ready_to_print' ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> transition-all text-sm"
                >
                    <div class="flex items-center space-x-3.5">
                        <i class="fa-solid fa-print w-5 text-rose-400"></i>
                        <span>Siap Cetak QR</span>
                    </div>
                    <span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-rose-500/20 text-rose-300 border border-rose-500/30 font-semibold">A6</span>
                </a>

                <a
                    href="<?php echo e(route('admin.digital-stories.index', ['fulfillment_status' => 'completed'])); ?>"
                    class="flex items-center space-x-3.5 px-3.5 py-2.5 rounded-xl <?php echo e(request('fulfillment_status') === 'completed' ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> transition-all text-sm"
                >
                    <i class="fa-solid fa-circle-check w-5 text-emerald-400"></i>
                    <span>Pesanan Selesai</span>
                </a>

                <!-- Pengaturan Akun -->
                <div class="pt-4 px-3 py-1 text-[10px] font-mono font-bold tracking-widest text-accent/70 uppercase">Pengaturan Akun</div>

                <a
                    href="<?php echo e(route('admin.password.edit')); ?>"
                    class="flex items-center space-x-3.5 px-3.5 py-2.5 rounded-xl <?php echo e(request()->routeIs('admin.password.*') ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> transition-all text-sm"
                >
                    <i class="fa-solid fa-key w-5 <?php echo e(request()->routeIs('admin.password.*') ? 'text-accent' : 'text-neutral-400'); ?>"></i>
                    <span>Ganti Password</span>
                </a>
            </nav>

            <!-- User Drawer Footer -->
            <div class="pt-4 border-t border-border-subtle flex items-center justify-between">
                <div class="flex items-center space-x-3 truncate">
                    <div class="w-9 h-9 rounded-xl bg-primary/30 border border-primary text-cream flex items-center justify-center font-bold font-mono text-xs uppercase shrink-0">
                        <?php echo e(strtoupper(substr(auth()->user()->name ?? 'O', 0, 2))); ?>

                    </div>
                    <div class="truncate">
                        <p class="text-xs font-semibold text-cream truncate"><?php echo e(auth()->user()->name ?? 'Operator CMS'); ?></p>
                        <p class="text-[10px] text-accent flex items-center space-x-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary inline-block animate-pulse"></span>
                            <span><?php echo e(auth()->user()->role ?? 'Admin CMS'); ?></span>
                        </p>
                    </div>
                </div>
                <form action="<?php echo e(route('admin.logout')); ?>" method="POST" class="inline shrink-0">
                    <?php echo csrf_field(); ?>
                    <button type="submit" title="Keluar / Logout" class="touch-target text-neutral-400 hover:text-rose-400 p-2 transition flex items-center justify-center">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- 2. MAIN APP CONTAINER -->
    <div class="flex flex-1 min-h-screen bg-canvas">

        <!-- DESKTOP FIXED SIDEBAR (>= 768px - BucketFlow Standard) -->
        <aside
            class="hidden md:flex fixed inset-y-0 left-0 z-30 flex-col w-64 bg-surface-card border-r border-border-subtle transition-all duration-300 ease-spring select-none shadow-xl"
            :class="desktopSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <!-- Header Brand -->
            <div class="h-16 flex items-center justify-between px-5 border-b border-border-subtle">
                <a href="<?php echo e(route('admin.digital-stories.index')); ?>" class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-primary to-secondary flex items-center justify-center text-cream shadow-md shadow-primary/40 shrink-0">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </div>
                    <div class="truncate">
                        <h1 class="font-heading font-bold text-lg tracking-wider text-cream">maja flower</h1>
                        <span class="text-[9px] font-mono text-accent block -mt-1 font-semibold tracking-wider uppercase">SURAT & UNDANGAN CMS</span>
                    </div>
                </a>
                <button
                    @click="desktopSidebarOpen = false; localStorage.setItem('maja_cms_sidebar_open', 'false')"
                    type="button"
                    class="touch-target flex items-center justify-center w-8 h-8 rounded-lg text-neutral-400 hover:text-cream hover:bg-white/10 transition"
                    title="Sembunyikan Sidebar"
                    aria-label="Sembunyikan Sidebar"
                >
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                <div class="px-3 py-2 text-[10px] font-mono font-bold tracking-widest text-accent/70 uppercase">Konsol Utama</div>

                <a
                    href="<?php echo e(route('admin.digital-stories.index')); ?>"
                    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg <?php echo e(request()->routeIs('admin.digital-stories.index') && !request('fulfillment_status') && !request('type') && !request('story_type') ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> font-medium text-sm transition-colors"
                >
                    <i class="fa-solid fa-chart-pie w-4 <?php echo e(request()->routeIs('admin.digital-stories.index') && !request('fulfillment_status') && !request('type') && !request('story_type') ? 'text-accent' : 'text-neutral-400'); ?>"></i>
                    <span>Pipeline Pesanan</span>
                </a>

                <a
                    href="<?php echo e(route('admin.digital-stories.create')); ?>"
                    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg <?php echo e(request()->routeIs('admin.digital-stories.create') ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> font-medium text-sm transition-colors"
                >
                    <i class="fa-solid fa-circle-plus w-4 <?php echo e(request()->routeIs('admin.digital-stories.create') ? 'text-accent' : 'text-neutral-400'); ?>"></i>
                    <span>Input Pesanan Baru</span>
                </a>

                <a
                    href="<?php echo e(route('admin.digital-stories.templates')); ?>"
                    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg <?php echo e(request()->routeIs('admin.digital-stories.templates') ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> font-medium text-sm transition-colors"
                >
                    <i class="fa-solid fa-palette w-4 <?php echo e(request()->routeIs('admin.digital-stories.templates') ? 'text-accent' : 'text-neutral-400'); ?>"></i>
                    <span>8 Katalog Template</span>
                </a>

                <!-- Format Produk -->
                <div class="pt-4 px-3 py-2 text-[10px] font-mono font-bold tracking-widest text-accent/70 uppercase">Format Produk</div>

                <a
                    href="<?php echo e(route('admin.digital-stories.index', ['story_type' => 'love_letter'])); ?>"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo e(in_array(request('story_type') ?? request('type'), ['love_letter']) ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> font-medium text-sm transition-colors"
                >
                    <i class="fa-solid fa-heart w-4 <?php echo e(in_array(request('story_type') ?? request('type'), ['love_letter']) ? 'text-accent' : 'text-neutral-400'); ?>"></i>
                    <span>Surat Cinta Buket</span>
                </a>

                <a
                    href="<?php echo e(route('admin.digital-stories.index', ['story_type' => 'wedding_invitation'])); ?>"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo e(in_array(request('story_type') ?? request('type'), ['wedding_invitation']) ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> font-medium text-sm transition-colors"
                >
                    <i class="fa-solid fa-ring w-4 <?php echo e(in_array(request('story_type') ?? request('type'), ['wedding_invitation']) ? 'text-accent' : 'text-neutral-400'); ?>"></i>
                    <span>Undangan Pernikahan</span>
                </a>

                <!-- Tahap Tindak Lanjut -->
                <div class="pt-4 px-3 py-2 text-[10px] font-mono font-bold tracking-widest text-accent/70 uppercase">Alur Pengerjaan CMS</div>

                <a
                    href="<?php echo e(route('admin.digital-stories.index', ['fulfillment_status' => 'pending_content'])); ?>"
                    class="flex items-center justify-between px-3 py-2 rounded-lg <?php echo e(request('fulfillment_status') === 'pending_content' ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> font-medium text-sm transition-colors"
                >
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-clock w-4 text-amber-400"></i>
                        <span>Perlu Konten (WA)</span>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                </a>

                <a
                    href="<?php echo e(route('admin.digital-stories.index', ['fulfillment_status' => 'drafting'])); ?>"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo e(request('fulfillment_status') === 'drafting' ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> font-medium text-sm transition-colors"
                >
                    <i class="fa-solid fa-pen-ruler w-4 text-neutral-400"></i>
                    <span>Sedang Draf / Desain</span>
                </a>

                <a
                    href="<?php echo e(route('admin.digital-stories.index', ['fulfillment_status' => 'customer_review'])); ?>"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo e(request('fulfillment_status') === 'customer_review' ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> font-medium text-sm transition-colors"
                >
                    <i class="fa-solid fa-eye w-4 text-neutral-400"></i>
                    <span>Review Client</span>
                </a>

                <a
                    href="<?php echo e(route('admin.digital-stories.index', ['fulfillment_status' => 'ready_to_print'])); ?>"
                    class="flex items-center justify-between px-3 py-2 rounded-lg <?php echo e(request('fulfillment_status') === 'ready_to_print' ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> font-medium text-sm transition-colors"
                >
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-print w-4 text-rose-400"></i>
                        <span>Siap Cetak QR</span>
                    </div>
                    <span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-rose-500/20 text-rose-300 border border-rose-500/30 font-semibold">A6</span>
                </a>

                <a
                    href="<?php echo e(route('admin.digital-stories.index', ['fulfillment_status' => 'completed'])); ?>"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo e(request('fulfillment_status') === 'completed' ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> font-medium text-sm transition-colors"
                >
                    <i class="fa-solid fa-circle-check w-4 text-emerald-400"></i>
                    <span>Pesanan Selesai</span>
                </a>

                <!-- Pengaturan Akun -->
                <div class="pt-4 px-3 py-2 text-[10px] font-mono font-bold tracking-widest text-accent/70 uppercase">Pengaturan Akun</div>

                <a
                    href="<?php echo e(route('admin.password.edit')); ?>"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg <?php echo e(request()->routeIs('admin.password.*') ? 'bg-primary/25 text-cream font-semibold border border-primary/40 shadow-xs' : 'text-neutral-300 hover:text-cream hover:bg-white/5'); ?> font-medium text-sm transition-colors"
                >
                    <i class="fa-solid fa-key w-4 <?php echo e(request()->routeIs('admin.password.*') ? 'text-accent' : 'text-neutral-400'); ?>"></i>
                    <span>Ganti Password</span>
                </a>
            </nav>

            <!-- Footer Operator Meta -->
            <div class="p-4 border-t border-border-subtle bg-[#0e140e]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-primary/30 text-accent border border-primary/40 flex items-center justify-center font-bold font-mono text-xs shrink-0 uppercase">
                            <?php echo e(strtoupper(substr(auth()->user()->name ?? 'O', 0, 2))); ?>

                        </div>
                        <div class="truncate">
                            <p class="text-xs font-semibold text-cream truncate"><?php echo e(auth()->user()->name ?? 'Operator CMS'); ?></p>
                            <p class="text-[10px] text-accent flex items-center space-x-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-secondary inline-block animate-pulse"></span>
                                <span><?php echo e(auth()->user()->role ?? 'Admin Studio'); ?></span>
                            </p>
                        </div>
                    </div>
                    <form action="<?php echo e(route('admin.logout')); ?>" method="POST" class="shrink-0 ml-2">
                        <?php echo csrf_field(); ?>
                        <button type="submit" title="Keluar / Logout" class="p-1.5 text-neutral-400 hover:text-rose-400 hover:bg-white/5 rounded-lg transition flex items-center justify-center" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                            <i class="fa-solid fa-right-from-bracket text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT WRAPPER -->
        <div
            class="flex-1 flex flex-col min-w-0 transition-all duration-300 ease-spring w-full"
            :class="desktopSidebarOpen ? 'md:pl-64' : 'md:pl-0'"
        >
            <!-- STICKY TOP APP BAR (BucketFlow ERP Standard) -->
            <header class="sticky top-0 z-30 bg-surface-card border-b border-border-subtle safe-top shadow-md">
                <div class="h-14 sm:h-16 px-3 sm:px-6 flex items-center justify-between gap-2.5 max-w-7xl mx-auto w-full">

                    <!-- Left Section: Menu Toggle + Dynamic Title -->
                    <div class="flex items-center gap-2.5 min-w-0 flex-1">
                        <!-- Hamburger Toggle Button -->
                        <button
                            @click="toggleSidebar()"
                            type="button"
                            class="flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-white/5 hover:bg-white/10 active:scale-95 text-neutral-300 hover:text-cream border border-white/10 transition shrink-0"
                            aria-label="Toggle menu navigasi"
                            title="Buka / Tutup Menu"
                        >
                            <i class="fa-solid fa-bars-staggered text-sm sm:text-base text-accent"></i>
                        </button>

                        <!-- Page Title with Mobile Graceful Truncation -->
                        <div class="min-w-0 flex-1 flex flex-col justify-center">
                            <div class="flex items-center gap-1.5 min-w-0">
                                <span class="md:hidden text-[10px] font-mono font-bold uppercase tracking-wider text-accent/80 shrink-0">
                                    Maja Flower
                                </span>
                                <span class="md:hidden text-neutral-600 text-xs shrink-0">•</span>
                                <h1 class="text-xs sm:text-base font-heading font-bold text-cream tracking-wide truncate">
                                    <?php echo e($header ?? 'Pipeline Pesanan Surat & Undangan'); ?>

                                </h1>
                            </div>
                            <p class="hidden sm:block text-[11px] font-mono text-accent/80 truncate">
                                Surat & Undangan Digital CMS • Engine 2.0
                            </p>
                        </div>
                    </div>

                    <!-- Right Section: Fast CTA + Role Badge + Profile Dropdown -->
                    <div class="flex items-center gap-2 shrink-0">
                        <a
                            href="<?php echo e(route('admin.digital-stories.create')); ?>"
                            class="hidden sm:inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-primary hover:bg-primary-dark text-cream rounded-xl text-xs font-semibold shadow-md shadow-primary/30 transition active:scale-95 shrink-0 border border-primary-light/30"
                        >
                            <i class="fa-solid fa-plus text-xs"></i>
                            <span>Input Pesanan Baru</span>
                        </a>

                        <!-- Live Status Pill (Tablet & Desktop) -->
                        <div class="hidden md:flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 text-[10px] font-mono text-accent shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary inline-block animate-pulse"></span>
                            <span>Live Engine 2.0</span>
                        </div>

                        <!-- User Profile Dropdown Button -->
                        <div x-data="{ userMenuOpen: false }" class="relative shrink-0">
                            <button
                                @click="userMenuOpen = !userMenuOpen"
                                type="button"
                                class="flex items-center gap-2 p-1 sm:px-2.5 sm:py-1.5 rounded-xl bg-white/5 hover:bg-white/10 active:scale-95 border border-white/10 text-cream transition"
                                aria-label="Menu profil pengguna"
                            >
                                <div class="w-7 h-7 sm:w-6 sm:h-6 rounded-lg bg-gradient-to-tr from-primary to-secondary text-cream flex items-center justify-center font-bold font-mono text-[10px] uppercase shadow-sm border border-accent/20 shrink-0">
                                    <?php echo e(strtoupper(substr(auth()->user()->name ?? 'O', 0, 2))); ?>

                                </div>
                                <span class="hidden sm:inline text-xs font-medium max-w-[110px] truncate text-cream">
                                    <?php echo e(auth()->user()->name ?? 'Operator'); ?>

                                </span>
                                <i class="fa-solid fa-chevron-down text-[9px] text-accent/70 hidden sm:inline"></i>
                            </button>

                            <div
                                x-show="userMenuOpen"
                                @click.away="userMenuOpen = false"
                                x-cloak
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-56 max-w-[calc(100vw-2rem)] bg-night-surface border border-border-subtle rounded-xl shadow-2xl py-1.5 z-50 divide-y divide-border-subtle"
                            >
                                <div class="px-4 py-2.5">
                                    <p class="text-xs font-semibold text-cream truncate"><?php echo e(auth()->user()->name ?? 'Operator CMS'); ?></p>
                                    <p class="text-[11px] font-mono text-neutral-400 truncate"><?php echo e(auth()->user()->email ?? '-'); ?></p>
                                    <div class="mt-1 flex items-center space-x-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                        <span class="text-[10px] font-mono font-semibold text-accent uppercase tracking-wider"><?php echo e(auth()->user()->role ?? 'Admin Atelier'); ?></span>
                                    </div>
                                </div>
                                <div class="py-1">
                                    <a href="<?php echo e(route('admin.digital-stories.index')); ?>" class="w-full text-left px-4 py-2 text-xs text-neutral-300 hover:bg-white/5 hover:text-cream flex items-center space-x-2.5 transition">
                                        <i class="fa-solid fa-chart-pie text-accent text-xs"></i>
                                        <span>Pipeline Pesanan</span>
                                    </a>
                                    <a href="<?php echo e(route('admin.digital-stories.templates')); ?>" class="w-full text-left px-4 py-2 text-xs text-neutral-300 hover:bg-white/5 hover:text-cream flex items-center space-x-2.5 transition">
                                        <i class="fa-solid fa-palette text-secondary text-xs"></i>
                                        <span>8 Katalog Template</span>
                                    </a>
                                    <a href="<?php echo e(route('admin.password.edit')); ?>" class="w-full text-left px-4 py-2 text-xs text-neutral-300 hover:bg-white/5 hover:text-cream flex items-center space-x-2.5 transition">
                                        <i class="fa-solid fa-key text-accent text-xs"></i>
                                        <span>Ganti Password</span>
                                    </a>
                                    <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="w-full text-left px-4 py-2 text-xs text-rose-300 hover:bg-white/5 hover:text-rose-200 flex items-center space-x-2.5 transition">
                                            <i class="fa-solid fa-right-from-bracket"></i>
                                            <span>Keluar (Logout)</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- FLASH NOTIFICATION TOAST -->
            <?php if(session('success')): ?>
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 4500)"
                x-transition:enter="transition duration-400 ease-spring transform will-change-transform"
                x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition duration-300 ease-spring-in transform will-change-transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
                class="mx-4 sm:mx-6 mt-4 p-4 rounded-xl bg-primary/30 border border-secondary/40 text-cream flex items-center justify-between shadow-xl shadow-black/40 backdrop-blur-md"
            >
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-check text-accent text-lg"></i>
                    <p class="text-xs sm:text-sm font-medium"><?php echo e(session('success')); ?></p>
                </div>
                <button @click="show = false" class="text-accent hover:text-white p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 5000)"
                x-transition:enter="transition duration-400 ease-spring transform will-change-transform"
                x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition duration-300 ease-spring-in transform will-change-transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
                class="mx-4 sm:mx-6 mt-4 p-4 rounded-xl bg-rose-950/80 border border-rose-500/40 text-rose-300 flex items-center justify-between shadow-xl shadow-rose-950/30 backdrop-blur-md"
            >
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-triangle-exclamation text-rose-400 text-lg"></i>
                    <p class="text-xs sm:text-sm font-medium"><?php echo e(session('error')); ?></p>
                </div>
                <button @click="show = false" class="text-rose-400 hover:text-white p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <?php endif; ?>

            <!-- PRIMARY BODY CONTENT (Safe bottom padding pb-28 on mobile prevents bottom dock overlap) -->
            <main class="flex-1 px-3 sm:px-6 py-4 sm:py-6 pb-28 md:pb-10 max-w-7xl w-full mx-auto">
                <?php echo e($slot); ?>

            </main>
        </div>
    </div>

    <!-- 3. APP-STYLE BOTTOM NAVIGATION BAR (Smartphone Thumb-Zone - BucketFlow Standard) -->
    <nav class="md:hidden fixed bottom-0 inset-x-0 z-40 bg-night-bg border-t border-border-subtle px-2 py-1 safe-bottom select-none">
        <div class="grid grid-cols-5 items-center justify-around">
            <!-- Tab 1: Pipeline -->
            <a
                href="<?php echo e(route('admin.digital-stories.index')); ?>"
                class="flex flex-col items-center justify-center py-1 <?php echo e(request()->routeIs('admin.digital-stories.index') && !request('fulfillment_status') ? 'text-accent font-semibold' : 'text-neutral-400 hover:text-white'); ?> transition active:scale-95"
            >
                <i class="fa-solid fa-chart-pie text-base mb-1 <?php echo e(request()->routeIs('admin.digital-stories.index') && !request('fulfillment_status') ? 'text-accent' : ''); ?>"></i>
                <span class="text-[10px] tracking-tight">Pipeline</span>
            </a>

            <!-- Tab 2: Template Showcase -->
            <a
                href="<?php echo e(route('admin.digital-stories.templates')); ?>"
                class="flex flex-col items-center justify-center py-1 <?php echo e(request()->routeIs('admin.digital-stories.templates') ? 'text-accent font-semibold' : 'text-neutral-400 hover:text-white'); ?> transition active:scale-95"
            >
                <i class="fa-solid fa-palette text-base mb-1 <?php echo e(request()->routeIs('admin.digital-stories.templates') ? 'text-accent' : ''); ?>"></i>
                <span class="text-[10px] tracking-tight">Template</span>
            </a>

            <!-- Tab 3 (CENTER ELEVATED FAB): Input Pesanan Baru -->
            <a
                href="<?php echo e(route('admin.digital-stories.create')); ?>"
                class="flex flex-col items-center justify-center -translate-y-3.5 group transition active:scale-90"
            >
                <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-primary to-secondary border-2 border-[#131b13] flex items-center justify-center text-cream shadow-xl shadow-primary/40 group-hover:scale-105 transition">
                    <i class="fa-solid fa-plus text-base"></i>
                </div>
                <span class="text-[10px] font-bold text-accent font-mono tracking-tight mt-0.5">+ Pesanan</span>
            </a>

            <!-- Tab 4: Siap Cetak QR -->
            <a
                href="<?php echo e(route('admin.digital-stories.index', ['fulfillment_status' => 'ready_to_print'])); ?>"
                class="flex flex-col items-center justify-center py-1 <?php echo e(request('fulfillment_status') === 'ready_to_print' ? 'text-accent font-semibold' : 'text-neutral-400 hover:text-white'); ?> transition active:scale-95"
            >
                <i class="fa-solid fa-print text-base mb-1 <?php echo e(request('fulfillment_status') === 'ready_to_print' ? 'text-accent' : ''); ?>"></i>
                <span class="text-[10px] tracking-tight">Cetak QR</span>
            </a>

            <!-- Tab 5: Menu / Drawer Toggle -->
            <button
                @click="sidebarOpen = true"
                type="button"
                class="touch-target flex flex-col items-center justify-center py-1 text-neutral-400 hover:text-white transition active:scale-95"
                aria-label="Menu navigasi lengkap"
            >
                <i class="fa-solid fa-bars-staggered text-base mb-1"></i>
                <span class="text-[10px] font-medium tracking-tight">Menu</span>
            </button>
        </div>
    </nav>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\ILHAM\All Project\all about my job\ALL MAJA FLOWER\SISTEM - UNDANGAN - SURAT\resources\views/components/layouts/admin.blade.php ENDPATH**/ ?>