<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Login CMS Surat & Undangan — Maja Flower</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('general/logo.png')); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo e(asset('general/logo.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('general/logo.png')); ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hedvig+Letters+Serif:opsz@12..24&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Roboto+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Free SVG & CSS Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-canvas text-gray-100 min-h-screen flex items-center justify-center p-4 selection:bg-primary selection:text-cream">

    <div class="max-w-md w-full bg-night-surface rounded-2xl border border-border-subtle shadow-2xl p-7 sm:p-9 relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-36 h-36 rounded-full bg-primary/25 blur-3xl pointer-events-none"></div>

        <!-- Logo & Header -->
        <div class="text-center mb-6 relative z-10">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-primary to-secondary p-1 mx-auto mb-3 shadow-lg shadow-primary/40 flex items-center justify-center text-cream">
                <i class="fa-solid fa-envelope-open-text text-2xl"></i>
            </div>
            <h1 class="font-heading text-2xl font-bold text-cream tracking-wide">maja flower</h1>
            <p class="font-mono text-xs text-accent uppercase tracking-wider mt-1 font-semibold">SURAT & UNDANGAN CMS</p>
            <p class="text-xs text-neutral-400 mt-1">Sistem kendali pesanan surat cinta buket & undangan nikah</p>
        </div>

        <?php if($errors->any()): ?>
            <div class="mb-5 p-3.5 rounded-xl bg-rose-950/80 border border-rose-500/40 text-rose-300 text-xs flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-400"></i>
                <p class="font-semibold"><?php echo e($errors->first()); ?></p>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.login.submit')); ?>" method="POST" class="space-y-4 relative z-10">
            <?php echo csrf_field(); ?>

            <div>
                <label class="block text-xs font-mono text-neutral-300 mb-1 font-semibold">Email Operator / Admin</label>
                <div class="relative">
                    <input
                        type="email"
                        name="email"
                        value="<?php echo e(old('email')); ?>"
                        required
                        autocomplete="username"
                        placeholder="operator@majaflower.com"
                        class="w-full bg-night-bg border border-border-subtle rounded-xl pl-9 pr-4 py-2.5 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary transition"
                    >
                    <i class="fa-solid fa-envelope absolute left-3 top-3 text-xs text-neutral-500"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs font-mono text-neutral-300 mb-1 font-semibold">Kata Sandi (Password)</label>
                <div class="relative">
                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full bg-night-bg border border-border-subtle rounded-xl pl-9 pr-4 py-2.5 text-xs text-cream placeholder-neutral-500 focus:outline-none focus:border-primary transition"
                    >
                    <i class="fa-solid fa-lock absolute left-3 top-3 text-xs text-neutral-500"></i>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-neutral-400">
                    <input type="checkbox" name="remember" class="rounded accent-primary text-primary h-4 w-4 bg-night-bg border-border-subtle">
                    <span>Ingat sesi saya</span>
                </label>
                <span class="font-mono text-[11px] text-accent/80 flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-halved text-xs"></i>
                    <span>Terenkripsi</span>
                </span>
            </div>

            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-primary hover:bg-primary-dark text-cream font-mono text-xs font-bold uppercase tracking-wider transition shadow-lg shadow-primary/30 flex items-center justify-center gap-2 cursor-pointer active:scale-95"
                >
                    <span>Masuk ke CMS</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>
        </form>

        <div class="mt-6 pt-4 border-t border-border-subtle text-center relative z-10">
            <span class="text-[11px] font-mono text-neutral-500">
                Maja Flower • Florist Ecosystem Standard
            </span>
        </div>
    </div>

</body>
</html>
<?php /**PATH D:\ILHAM\All Project\all about my job\ALL MAJA FLOWER\SISTEM - UNDANGAN - SURAT\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>