<?php if(isset($isDemo) && $isDemo && !request()->has('embed') && !request()->has('preview_modal') && !request()->has('iframe')): ?>
    <!-- FLOATING DEMO PREVIEW BAR (Compact Floating Pill) -->
    <aside
        x-data="{
            bannerCopied: false,
            copyDemoLink() {
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        this.bannerCopied = true;
                        setTimeout(() => this.bannerCopied = false, 2500);
                    });
                }
            }
        }"
        class="fixed top-2.5 inset-x-0 mx-auto z-50 max-w-lg px-3 py-1.5 rounded-full bg-[#111711]/90 backdrop-blur-md border border-white/15 text-cream shadow-xl flex items-center justify-between gap-2"
        role="complementary"
        aria-label="Demo Preview Toolbar"
    >
        <!-- Left: Badge -->
        <div class="flex items-center gap-1.5 shrink-0 pl-1">
            <span class="w-2 h-2 rounded-full bg-accent animate-ping"></span>
            <span class="px-2 py-0.5 rounded-full bg-white/10 text-accent font-mono text-[9px] font-bold uppercase tracking-wider">
                Contoh Template Live
            </span>
            <span class="hidden md:inline font-heading font-bold text-cream text-xs truncate max-w-[150px]">
                <?php echo e($template->title()); ?>

            </span>
        </div>

        <!-- Right: Compact Actions -->
        <div class="flex items-center gap-1.5 shrink-0">
            <!-- Salin Link -->
            <button
                type="button"
                @click="copyDemoLink()"
                class="px-2.5 py-1 rounded-full bg-white/10 hover:bg-white/20 text-cream font-mono text-[10px] font-semibold transition flex items-center gap-1 cursor-pointer border border-white/10 active:scale-95"
                title="Salin link contoh ini"
            >
                <span x-show="!bannerCopied">🔗</span>
                <span x-show="bannerCopied" class="text-accent">✓</span>
                <span x-text="bannerCopied ? 'Tersalin' : 'Salin Link Contoh'"></span>
            </button>

            <!-- Share WA -->
            <?php
                $waText = "Halo kak! 🌸\n\nBerikut contoh tampilan interaktif template *" . $template->title() . "* dari Maja Flower:\n" . url()->current() . "\n\nBisa langsung dibuka di HP untuk mencoba fiturnya ya kak 😊";
            ?>
            <a
                href="https://wa.me/?text=<?php echo e(rawurlencode($waText)); ?>"
                target="_blank"
                rel="noopener noreferrer"
                class="px-2.5 py-1 rounded-full bg-[#25D366] hover:bg-[#20ba59] text-dark font-mono text-[10px] font-bold transition flex items-center gap-1 shadow-sm active:scale-95"
                title="Bagikan ke WhatsApp"
            >
                <i class="fa-brands fa-whatsapp text-xs"></i>
                <span class="hidden sm:inline">Share</span>
            </a>

            <?php if(auth()->guard()->check()): ?>
                <a
                    href="<?php echo e(route('admin.digital-stories.create', ['template_key' => $template->value, 'story_type' => $template->storyType()->value])); ?>"
                    class="px-2.5 py-1 rounded-full bg-primary hover:bg-primary-dark text-cream font-mono text-[10px] font-bold transition flex items-center gap-1 shadow-sm border border-white/20 active:scale-95"
                >
                    <i class="fa-solid fa-plus text-[9px]"></i>
                    <span>Pilih</span>
                </a>
            <?php endif; ?>
        </div>
    </aside>
    <!-- Slim spacer so content has breathing room -->
    <div class="h-10 w-full pointer-events-none"></div>
<?php endif; ?>
<?php /**PATH D:\ILHAM\All Project\all about my job\ALL MAJA FLOWER\SISTEM - UNDANGAN - SURAT\resources\views/digital-story/components/demo-banner.blade.php ENDPATH**/ ?>