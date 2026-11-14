<!-- BOTANICAL LUXURY PAGE OPENING & TRANSITION CURTAIN -->
<div
    id="maja-page-curtain"
    class="fixed inset-0 z-[99999] flex flex-col items-center justify-center bg-[#182318] text-cream select-none pointer-events-auto transition-transform duration-700 ease-[cubic-bezier(0.77,0,0.175,1)]"
    style="transform: translateY(0);"
    aria-hidden="true"
>
    <!-- Luxury Ambient Glow Background -->
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-secondary/20 blur-[100px] pointer-events-none animate-pulse"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-accent/20 blur-[110px] pointer-events-none animate-pulse" style="animation-delay: 1s;"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,transparent_20%,rgba(0,0,0,0.45)_100%)] pointer-events-none"></div>

    <!-- Centerpiece Brand Reveal -->
    <div class="relative z-10 flex flex-col items-center text-center px-6 max-w-md w-full">
        <!-- Logo Emblem with Glowing Halo -->
        <div class="relative mb-5">
            <!-- Decorative Dashed Orbit Ring -->
            <div class="absolute -inset-3.5 rounded-full border border-dashed border-accent/30 animate-[spin_14s_linear_infinite] pointer-events-none"></div>
            <!-- Soft Pulsing Glow -->
            <div class="absolute -inset-1.5 rounded-full bg-gradient-to-tr from-accent/30 via-cream/20 to-secondary/30 blur-md animate-pulse"></div>
            <!-- Circular White/Cream Base for Logo -->
            <div class="relative w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-cream-light/95 p-3.5 shadow-2xl flex items-center justify-center border border-accent/40">
                <img
                    src="{{ asset('general/logo.png') }}"
                    alt="Maja Flower Logo"
                    class="h-full w-auto object-contain animate-botanical-bloom"
                />
            </div>
        </div>

        <!-- Brand Name & Monogram -->
        <h1 class="font-heading text-2xl sm:text-3xl font-bold tracking-tight text-cream leading-tight">
            maja flower
        </h1>
        <div class="flex items-center gap-2 mt-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-accent animate-ping"></span>
            <span class="font-mono text-[10px] sm:text-xs tracking-[0.25em] uppercase text-accent font-semibold">
                Buket No 1 di Maja
            </span>
        </div>

        <!-- Progress Line & Status Message -->
        <div class="w-48 sm:w-60 mt-6 space-y-2">
            <!-- Shimmering Progress Bar -->
            <div class="h-1 w-full bg-white/10 rounded-full overflow-hidden p-0.5 border border-white/10 backdrop-blur-sm">
                <div
                    id="maja-progress-bar"
                    class="h-full w-0 shimmer-progress rounded-full transition-all duration-300 ease-out"
                ></div>
            </div>

            <!-- Dynamic Status Text -->
            <div class="flex items-center justify-between text-[10px] font-mono text-cream/70">
                <span id="maja-curtain-status">Merangkai Keindahan...</span>
                <span id="maja-progress-text" class="font-bold text-accent">0%</span>
            </div>
        </div>
    </div>

    <!-- Atelier Watermark -->
    <div class="absolute bottom-6 font-mono text-[9px] tracking-widest uppercase text-cream/40 flex items-center gap-2">
        <span>🌸</span>
        <span>Botanical Atelier • Live Floral Crafting</span>
    </div>
</div>

<script>
    (function() {
        const curtain = document.getElementById('maja-page-curtain');
        const progressBar = document.getElementById('maja-progress-bar');
        const progressText = document.getElementById('maja-progress-text');
        const statusText = document.getElementById('maja-curtain-status');

        if (!curtain) return;

        let isExiting = false;

        function getMotionAnimate() {
            return (window.motion && typeof window.motion.animate === 'function') ? window.motion.animate : null;
        }

        // Animate progress smoothly from start to finish
        function runInitialProgress(callback) {
            let current = 0;
            const interval = setInterval(function() {
                current += Math.floor(Math.random() * 22) + 16;
                if (current >= 100) {
                    current = 100;
                    clearInterval(interval);
                    if (progressBar) progressBar.style.width = '100%';
                    if (progressText) progressText.innerText = '100%';
                    if (statusText) statusText.innerText = 'Selamat Datang';
                    setTimeout(callback, 100);
                } else {
                    if (progressBar) progressBar.style.width = current + '%';
                    if (progressText) progressText.innerText = current + '%';
                }
            }, 30);
        }

        // Lift the curtain up using Framer Motion
        function dismissCurtain() {
            if (!curtain || isExiting) return;
            isExiting = true;

            const anim = getMotionAnimate();
            if (anim) {
                anim(
                    curtain,
                    { transform: ['translateY(0%)', 'translateY(-100%)'] },
                    { duration: 0.72, ease: [0.77, 0, 0.175, 1] }
                ).then(function() {
                    curtain.style.display = 'none';
                    curtain.style.pointerEvents = 'none';
                    isExiting = false;
                });
            } else {
                curtain.style.transition = 'transform 0.72s cubic-bezier(0.77, 0, 0.175, 1)';
                curtain.style.transform = 'translateY(-100%)';
                setTimeout(function() {
                    curtain.style.display = 'none';
                    curtain.style.pointerEvents = 'none';
                    isExiting = false;
                }, 750);
            }
        }

        // Fast dismiss for cached or bfcache visits
        function dismissFast() {
            if (!curtain) return;
            curtain.style.transform = 'translateY(-100%)';
            setTimeout(function() {
                curtain.style.display = 'none';
                curtain.style.pointerEvents = 'none';
            }, 400);
        }

        // Start progress as soon as script evaluates
        runInitialProgress(dismissCurtain);

        // Safety fallback: Never leave user stranded
        setTimeout(function() {
            if (curtain && curtain.style.display !== 'none' && !isExiting) {
                dismissCurtain();
            }
        }, 2200);

        // Browser Back/Forward navigation recovery (BFCache)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                dismissFast();
            }
        });

        // Intercept internal page navigations for inter-page transition
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;

            // Ignore modified clicks (Ctrl, Cmd, Shift, Alt, middle-click)
            if (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey || e.button !== 0) return;

            // Ignore links with target="_blank" or download
            if (link.target === '_blank' || link.hasAttribute('download')) return;

            const href = link.getAttribute('href');
            if (!href) return;

            // Ignore anchor on same page or javascript: links
            if (href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('tel:') || href.startsWith('mailto:')) return;

            // Resolve target URL
            let targetUrl;
            try {
                targetUrl = new URL(href, window.location.origin);
            } catch (err) {
                return;
            }

            // Only transition for same origin internal links
            if (targetUrl.origin !== window.location.origin) return;

            // If pointing to an anchor on current page (e.g. /#filosofi while on /), do smooth scroll if on same page
            if (targetUrl.pathname === window.location.pathname && targetUrl.search === window.location.search && targetUrl.hash) {
                return;
            }

            // Exclude logout or admin action links if needed
            if (targetUrl.pathname.includes('/logout')) return;

            // Prevent immediate navigation
            e.preventDefault();

            // Set dynamic status text based on destination
            if (statusText) {
                if (targetUrl.pathname === '/' || targetUrl.pathname === '') {
                    statusText.innerText = 'Menuju Beranda...';
                } else if (targetUrl.pathname.includes('/katalog')) {
                    statusText.innerText = 'Membuka Koleksi Buket...';
                } else if (targetUrl.pathname.includes('/lacak-pesanan')) {
                    statusText.innerText = 'Menyiapkan Live Tracking...';
                } else if (targetUrl.pathname.includes('/login') || targetUrl.pathname.includes('/admin')) {
                    statusText.innerText = 'Menuju Studio Portal...';
                } else {
                    statusText.innerText = 'Menyiapkan Halaman...';
                }
            }

            // Prepare curtain from bottom
            curtain.style.display = 'flex';
            curtain.style.pointerEvents = 'auto';
            if (progressBar) progressBar.style.width = '75%';
            if (progressText) progressText.innerText = '...';

            const anim = getMotionAnimate();
            if (anim) {
                curtain.style.transform = 'translateY(100%)';
                anim(
                    curtain,
                    { transform: ['translateY(100%)', 'translateY(0%)'] },
                    { duration: 0.42, ease: [0.77, 0, 0.175, 1] }
                ).then(function() {
                    window.location.href = targetUrl.href;
                });
            } else {
                curtain.style.transition = 'none';
                curtain.style.transform = 'translateY(100%)';
                requestAnimationFrame(function() {
                    curtain.style.transition = 'transform 0.42s cubic-bezier(0.77, 0, 0.175, 1)';
                    curtain.style.transform = 'translateY(0)';
                    setTimeout(function() {
                        window.location.href = targetUrl.href;
                    }, 380);
                });
            }
        });
    })();
</script>
