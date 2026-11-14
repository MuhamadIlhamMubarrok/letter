<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Dashboard CMS Surat & Undangan — Maja Flower']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dashboard CMS Surat & Undangan — Maja Flower']); ?>
     <?php $__env->slot('header', null, []); ?> 
        Dashboard Eksekutif & CMS Surat-Undangan
     <?php $__env->endSlot(); ?>

    <?php
        $storiesList = $stories ?? $digitalStories ?? collect();
    ?>

    <div
        x-data="{
            extendModalOpen: false,
            currentStoryId: null,
            currentStoryTitle: '',
            currentPlan: '1_month',
            qrModalOpen: false,
            currentQrUrl: '',
            currentQrSvg: '',
            currentQrCode: '',
            currentQrStoryTitle: '',
            currentQrPrintUrl: '',
            currentQrPublicUrl: '',
            copiedTextState: false,

            // Quick Guest Link Generator Modal State
            guestModalOpen: false,
            guestStoryId: null,
            guestStoryTitle: '',
            guestStorySlug: '',
            guestStoryMempelai: '',
            guestInputText: '',
            guestCopiedToast: '',
            guestShowToast: false,

            openGuestModal(id, title, slug, mempelai, existingGuests = '') {
                this.guestStoryId = id;
                this.guestStoryTitle = title;
                this.guestStorySlug = slug;
                this.guestStoryMempelai = mempelai;
                this.guestInputText = existingGuests;
                this.guestModalOpen = true;
            },
            closeGuestModal() {
                this.guestModalOpen = false;
            },
            get parsedGuests() {
                if (!this.guestInputText) return [];
                return this.guestInputText.split(/\r?\n/).map(l => l.trim()).filter(l => l.length > 0);
            },
            getGuestUrl(name) {
                return '<?php echo e(url('/s')); ?>/' + this.guestStorySlug + '?to=' + encodeURIComponent(name);
            },
            copyAllGuestLinks() {
                if (this.parsedGuests.length === 0) {
                    alert('Silakan masukkan nama tamu terlebih dahulu.');
                    return;
                }
                const lines = this.parsedGuests.map((g, idx) => `${idx + 1}. ${g}\n${this.getGuestUrl(g)}`);
                navigator.clipboard.writeText(lines.join('\n\n')).then(() => {
                    this.guestCopiedToast = `📋 ${this.parsedGuests.length} link tamu berhasil disalin!`;
                    this.guestShowToast = true;
                    setTimeout(() => { this.guestShowToast = false; }, 2500);
                });
            },
            copyGuestSpreadsheet() {
                if (this.parsedGuests.length === 0) {
                    alert('Silakan masukkan nama tamu terlebih dahulu.');
                    return;
                }
                const header = 'No\tNama Tamu\tLink Undangan Personal\n';
                const rows = this.parsedGuests.map((g, idx) => `${idx + 1}\t${g}\t${this.getGuestUrl(g)}`).join('\n');
                navigator.clipboard.writeText(header + rows).then(() => {
                    this.guestCopiedToast = `📑 Format Excel untuk ${this.parsedGuests.length} tamu berhasil disalin!`;
                    this.guestShowToast = true;
                    setTimeout(() => { this.guestShowToast = false; }, 2500);
                });
            },

            openExtendModal(id, title, plan) {
                this.currentStoryId = id;
                this.currentStoryTitle = title;
                this.currentPlan = plan;
                this.extendModalOpen = true;
            },
            closeExtendModal() {
                this.extendModalOpen = false;
                this.currentStoryId = null;
            },
            deleteModalOpen: false,
            deleteStoryId: null,
            deleteStoryTitle: '',
            deleteStoryCode: '',
            deleteActionUrl: '',
            openDeleteModal(id, title, code, url) {
                this.deleteStoryId = id;
                this.deleteStoryTitle = title;
                this.deleteStoryCode = code;
                this.deleteActionUrl = url;
                this.deleteModalOpen = true;
            },
            closeDeleteModal() {
                this.deleteModalOpen = false;
                this.deleteStoryId = null;
                this.deleteStoryTitle = '';
                this.deleteStoryCode = '';
                this.deleteActionUrl = '';
            },
            openQrModal(storyTitle, orderCode, publicUrl, printUrl, svgContent) {
                this.currentQrStoryTitle = storyTitle;
                this.currentQrCode = orderCode;
                this.currentQrPublicUrl = publicUrl;
                this.currentQrPrintUrl = printUrl;
                this.currentQrSvg = svgContent;
                this.qrModalOpen = true;
            },
            closeQrModal() {
                this.qrModalOpen = false;
                this.currentQrSvg = '';
            },
            copyToClipboard(text, label = 'Teks') {
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text).then(() => {
                        this.copiedTextState = true;
                        showToast(label + ' berhasil disalin!');
                        setTimeout(() => this.copiedTextState = false, 2500);
                    });
                }
            }
        }"
        class="space-y-6"
    >
        <!-- 1. WELCOME BANNER & DATE (BucketFlow Standard) -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-primary-dark via-night-surface to-night-surface border border-primary/40 p-5 sm:p-7 shadow-2xl">
            <div class="absolute -right-8 -top-8 w-44 h-44 rounded-full bg-primary/25 blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary/40 text-cream text-xs font-mono font-semibold border border-accent/30">
                            <i class="fa-solid fa-spa text-accent text-[11px]"></i>
                            <span>Panel CMS Surat & Undangan Digital</span>
                        </span>
                        <span class="text-xs font-mono text-accent/80 flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-black/20 border border-white/5">
                            <i class="fa-regular fa-calendar text-[10px]"></i>
                            <span><?php echo e(\Carbon\Carbon::now()->translatedFormat('l, d F Y')); ?></span>
                        </span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-heading font-bold text-cream tracking-wide">Pusat Kendali Surat & Undangan</h2>
                    <p class="text-xs sm:text-sm text-neutral-300 mt-1 max-w-xl">
                        Kelola alur pembuatan surat cinta buket, tindak lanjut konten pemesan via WhatsApp, cetak kartu QR Code A6, dan pratinjau live multi-template.
                    </p>
                </div>
                <!-- Quick CTAs -->
                <div class="flex items-center gap-2.5 shrink-0 w-full sm:w-auto">
                    <a href="<?php echo e(route('admin.digital-stories.create')); ?>" class="touch-target flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-cream font-semibold text-xs sm:text-sm shadow-lg shadow-primary/40 transition active:scale-95">
                        <i class="fa-solid fa-plus"></i>
                        <span>Input Pesanan Baru</span>
                    </a>
                    <a href="<?php echo e(route('admin.digital-stories.templates')); ?>" class="touch-target inline-flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl bg-night-bg hover:bg-white/10 text-cream font-semibold text-xs sm:text-sm border border-border-subtle transition active:scale-95">
                        <i class="fa-solid fa-palette text-accent"></i>
                        <span class="hidden sm:inline">8 Katalog Template</span>
                        <span class="sm:hidden">Template</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- 2. 4 METRIC KPI CARDS (BucketFlow Box Standard) -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <!-- Metric 1: Total Pesanan -->
            <a
                href="<?php echo e(route('admin.digital-stories.index')); ?>"
                class="bg-night-surface border border-border-subtle rounded-2xl p-4 sm:p-5 flex flex-col justify-between hover:border-secondary/40 transition-colors group cursor-pointer"
            >
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-neutral-300">Total Pesanan CMS</span>
                    <div class="w-8 h-8 rounded-lg bg-primary/30 text-accent border border-primary/50 flex items-center justify-center text-xs group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-lg sm:text-2xl font-bold font-mono text-cream tracking-tight"><?php echo e($stats['total_orders']); ?></p>
                    <p class="text-[11px] text-accent mt-1 flex items-center gap-1 font-mono truncate">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        <span><?php echo e($stats['love_letter_count']); ?> Surat • <?php echo e($stats['wedding_count']); ?> Undangan</span>
                    </p>
                </div>
            </a>

            <!-- Metric 2: Perlu Konten (WA Follow Up) -->
            <a
                href="<?php echo e(route('admin.digital-stories.index', ['fulfillment_status' => 'pending_content'])); ?>"
                class="bg-night-surface border <?php echo e(request('fulfillment_status') === 'pending_content' ? 'border-amber-500 ring-1 ring-amber-500' : 'border-border-subtle'); ?> rounded-2xl p-4 sm:p-5 flex flex-col justify-between hover:border-amber-400/60 transition-colors group cursor-pointer"
            >
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-neutral-300 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                        <span>Perlu Konten</span>
                    </span>
                    <div class="w-8 h-8 rounded-lg bg-amber-950 text-amber-400 border border-amber-800/60 flex items-center justify-center text-xs group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-lg sm:text-2xl font-bold font-mono text-amber-400 tracking-tight"><?php echo e($pipelineCounts['pending_content']); ?></p>
                    <p class="text-[11px] text-amber-300/80 mt-1 font-mono truncate">
                        ⚡ Butuh Follow-Up WhatsApp
                    </p>
                </div>
            </a>

            <!-- Metric 3: Siap Cetak QR Buket -->
            <a
                href="<?php echo e(route('admin.digital-stories.index', ['fulfillment_status' => 'ready_to_print'])); ?>"
                class="bg-night-surface border <?php echo e(request('fulfillment_status') === 'ready_to_print' ? 'border-rose-500 ring-1 ring-rose-500' : 'border-border-subtle'); ?> rounded-2xl p-4 sm:p-5 flex flex-col justify-between hover:border-rose-400/60 transition-colors group cursor-pointer"
            >
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-neutral-300">Siap Cetak QR</span>
                    <div class="w-8 h-8 rounded-lg bg-rose-950 text-rose-300 border border-rose-800/60 flex items-center justify-center text-xs group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-print"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-lg sm:text-2xl font-bold font-mono text-cream tracking-tight"><?php echo e($pipelineCounts['ready_to_print']); ?></p>
                    <p class="text-[11px] text-rose-300/80 mt-1 font-mono truncate">
                        ✂️ Kartu Buket A6 & Standee
                    </p>
                </div>
            </a>

            <!-- Metric 4: Total Scan & Interaksi -->
            <div class="bg-night-surface border border-border-subtle rounded-2xl p-4 sm:p-5 flex flex-col justify-between hover:border-secondary/40 transition-colors">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-neutral-300">Total Scan & Buka</span>
                    <div class="w-8 h-8 rounded-lg bg-secondary/20 text-accent border border-secondary/40 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-lg sm:text-2xl font-bold font-mono text-cream tracking-tight"><?php echo e(number_format($stats['total_views'])); ?></p>
                    <p class="text-[11px] text-neutral-400 mt-1 font-mono truncate">
                        ✓ <?php echo e($pipelineCounts['completed']); ?> Pesanan Selesai
                    </p>
                </div>
            </div>
        </div>

        <!-- 3. PIPELINE STATUS NAVIGATION TABS -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar text-xs font-mono">
            <a
                href="<?php echo e(route('admin.digital-stories.index', request()->except('fulfillment_status', 'page'))); ?>"
                class="px-3.5 py-2 rounded-xl transition shrink-0 flex items-center gap-2 border <?php echo e(!request('fulfillment_status') ? 'bg-primary/25 text-cream font-semibold border-primary/40 shadow-xs' : 'bg-night-surface text-neutral-400 hover:text-cream hover:bg-white/5 border-border-subtle'); ?>"
            >
                <i class="fa-solid fa-list-check text-xs"></i>
                <span>Semua Status</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] <?php echo e(!request('fulfillment_status') ? 'bg-primary text-cream font-bold' : 'bg-night-bg text-neutral-400 border border-border-subtle'); ?>">
                    <?php echo e($pipelineCounts['all']); ?>

                </span>
            </a>

            <?php $__currentLoopData = $fulfillmentStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $isActiveTab = request('fulfillment_status') === $fs->value;
                    $count = $pipelineCounts[$fs->value] ?? 0;
                ?>
                <a
                    href="<?php echo e(route('admin.digital-stories.index', array_merge(request()->query(), ['fulfillment_status' => $fs->value, 'page' => 1]))); ?>"
                    class="px-3.5 py-2 rounded-xl transition shrink-0 flex items-center gap-2 border <?php echo e($isActiveTab ? 'bg-primary/25 text-cream font-semibold border-primary/40 shadow-xs' : 'bg-night-surface text-neutral-400 hover:text-cream hover:bg-white/5 border-border-subtle'); ?>"
                >
                    <span><?php echo e($fs->icon()); ?></span>
                    <span><?php echo e($fs->label()); ?></span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold <?php echo e($isActiveTab ? 'bg-primary text-cream' : 'bg-night-bg text-neutral-400 border border-border-subtle'); ?>">
                        <?php echo e($count); ?>

                    </span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- 4. SEARCH & UNIFIED FILTER TOOLBAR -->
        <div class="bg-night-surface border border-border-subtle rounded-2xl p-4 sm:p-5 shadow-xl">
            <form method="GET" action="<?php echo e(route('admin.digital-stories.index')); ?>" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                <?php if(request('fulfillment_status')): ?>
                    <input type="hidden" name="fulfillment_status" value="<?php echo e(request('fulfillment_status')); ?>">
                <?php endif; ?>

                <!-- Search Input -->
                <div class="sm:col-span-5">
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="<?php echo e(request('search')); ?>"
                            placeholder="Cari No. Pesanan (MF-...), Nama Pelanggan, atau Slug..."
                            class="w-full bg-night-bg border border-border-subtle text-cream placeholder-neutral-500 rounded-xl pl-9 pr-4 py-2.5 text-xs font-body focus:outline-none focus:border-primary transition"
                        >
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-xs text-neutral-500"></i>
                    </div>
                </div>

                <!-- Story Type Filter -->
                <div class="sm:col-span-3">
                    <select
                        name="story_type"
                        onchange="this.form.submit()"
                        class="w-full bg-night-bg border border-border-subtle text-cream rounded-xl px-3.5 py-2.5 text-xs font-body focus:outline-none focus:border-primary transition cursor-pointer"
                    >
                        <option value="">Semua Format Produk</option>
                        <?php $__currentLoopData = $storyTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type->value); ?>" <?php echo e((request('story_type') ?? request('type')) === $type->value ? 'selected' : ''); ?>>
                                <?php echo e($type->label()); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Active Status Filter -->
                <div class="sm:col-span-2">
                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="w-full bg-night-bg border border-border-subtle text-cream rounded-xl px-3.5 py-2.5 text-xs font-body focus:outline-none focus:border-primary transition cursor-pointer"
                    >
                        <option value="">Masa Aktif: Semua</option>
                        <?php $__currentLoopData = $storyStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status->value); ?>" <?php echo e(request('status') === $status->value ? 'selected' : ''); ?>>
                                <?php echo e($status->label()); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Action Button -->
                <div class="sm:col-span-2 flex items-center gap-2">
                    <button
                        type="submit"
                        class="w-full py-2.5 px-4 rounded-xl bg-primary hover:bg-primary-dark text-cream text-xs font-mono font-semibold transition cursor-pointer shadow-xs active:scale-95"
                    >
                        <i class="fa-solid fa-filter text-[11px] mr-1"></i>
                        <span>Filter</span>
                    </button>
                    <?php if(request()->anyFilled(['search', 'story_type', 'type', 'status', 'fulfillment_status'])): ?>
                        <a
                            href="<?php echo e(route('admin.digital-stories.index')); ?>"
                            class="py-2.5 px-3 rounded-xl bg-night-bg hover:bg-white/10 text-neutral-400 hover:text-cream border border-border-subtle text-xs font-mono transition"
                            title="Reset Semua Filter"
                        >
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- 5. ORDERS DATA TABLE (BucketFlow Standardized) -->
        <div class="bg-night-surface border border-border-subtle rounded-2xl p-5 shadow-xl flex flex-col justify-between">
            <div class="flex items-center justify-between pb-4 border-b border-border-subtle">
                <div>
                    <h3 class="font-heading font-bold text-cream text-base flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-accent"></i>
                        <span>Daftar Pesanan Surat & Undangan</span>
                    </h3>
                    <p class="text-xs text-neutral-400">Kelola alur pengerjaan dan tindak lanjut pesanan buket</p>
                </div>
                <div class="text-xs font-mono text-accent">
                    Total: <?php echo e(method_exists($storiesList, 'total') ? $storiesList->total() : $storiesList->count()); ?> Pesanan
                </div>
            </div>

            <!-- Desktop / Tablet Table View (>= 640px) -->
            <div class="mt-4 hidden sm:block overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="text-neutral-400 border-b border-border-subtle text-[11px] uppercase tracking-wider bg-night-bg font-mono">
                        <tr>
                            <th class="py-3 px-4">Kode & Akses</th>
                            <th class="py-3 px-4">Pelanggan & Pesan</th>
                            <th class="py-3 px-4">Template Desain</th>
                            <th class="py-3 px-4">Tahap Pengerjaan CMS</th>
                            <th class="py-3 px-4">Tindak Lanjut WA</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-subtle">
                        <?php $__empty_1 = true; $__currentLoopData = $storiesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $story): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-white/5 transition">
                            <!-- Column 1: Order Code & Access/QR -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <?php if($story->story_type === \App\Domains\DigitalStory\Enums\StoryType::WEDDING_INVITATION): ?>
                                        <div class="w-10 h-10 rounded-xl bg-amber-500/15 text-amber-300 flex items-center justify-center border border-amber-500/30 shrink-0 text-base" title="Undangan Pernikahan Online (Cukup Bagikan Link)">
                                            <i class="fa-solid fa-ring"></i>
                                        </div>
                                    <?php else: ?>
                                        <button
                                            type="button"
                                            @click="openQrModal('<?php echo e(addslashes($story->title)); ?>', '<?php echo e($story->order_code ?? $story->slug); ?>', '<?php echo e($story->getPublicUrl()); ?>', '<?php echo e($story->getPrintCardUrl()); ?>', '<?php echo e(addslashes(str_replace(["\r", "\n"], '', $story->generateQrSvg()))); ?>')"
                                            class="w-10 h-10 rounded-xl bg-white p-1 shadow-sm border border-white/20 shrink-0 hover:scale-110 transition-transform cursor-pointer"
                                            title="Klik untuk pratinjau & salin QR Code Kartu Buket"
                                        >
                                            <div class="w-full h-full flex items-center justify-center overflow-hidden">
                                                <?php echo $story->generateQrSvg(); ?>

                                            </div>
                                        </button>
                                    <?php endif; ?>
                                    <div>
                                        <span class="font-mono font-bold text-accent hover:underline block">
                                            <?php echo e($story->order_code ?? 'NO-CODE'); ?>

                                        </span>
                                        <span class="font-mono text-[10px] text-neutral-400 block mt-0.5">
                                            /s/<?php echo e($story->slug); ?>

                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Column 2: Customer & Story Details -->
                            <td class="py-3.5 px-4">
                                <p class="font-medium text-cream tracking-tight"><?php echo e($story->title); ?></p>
                                <div class="text-[11px] text-neutral-400 mt-0.5 flex items-center gap-1.5 flex-wrap">
                                    <span>Dari: <strong class="text-neutral-300"><?php echo e($story->sender_name); ?></strong></span>
                                    <span>•</span>
                                    <span>Untuk: <strong class="text-neutral-300"><?php echo e($story->recipient_name); ?></strong></span>
                                </div>
                                <div class="mt-1 flex items-center gap-2">
                                    <span class="text-[10px] font-mono px-2 py-0.5 rounded-md bg-night-bg border border-border-subtle text-accent">
                                        <?php echo e($story->story_type->label()); ?>

                                    </span>
                                    <?php if($story->is_expired): ?>
                                        <span class="text-[10px] font-mono px-1.5 py-0.5 rounded bg-rose-950/80 text-rose-300 border border-rose-800/60 font-semibold">
                                            Kadaluarsa
                                        </span>
                                    <?php else: ?>
                                        <span class="text-[10px] font-mono text-neutral-400">
                                            Sisa: <?php echo e($story->expired_at ? $story->expired_at->diffForHumans(null, true) : 'Selamanya'); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Column 3: Template Style -->
                            <td class="py-3.5 px-4 font-mono">
                                <span class="text-neutral-300 font-semibold text-xs block">
                                    <?php echo e($story->template_key ? $story->template_key->title() : 'Vintage Envelope'); ?>

                                </span>
                                <span class="text-[10px] text-neutral-500 block mt-0.5">
                                    Tema: <?php echo e($story->theme ? $story->theme->label() : 'Default'); ?>

                                </span>
                            </td>

                            <!-- Column 4: Fulfillment Stage (Quick Interactive Update) -->
                            <td class="py-3.5 px-4">
                                <form action="<?php echo e(route('admin.digital-stories.fulfillment', $story)); ?>" method="POST" class="inline-block">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <select
                                        name="fulfillment_status"
                                        onchange="this.form.submit()"
                                        class="bg-night-bg border border-border-subtle text-cream text-[11px] font-mono font-semibold rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-primary transition cursor-pointer"
                                    >
                                        <?php $__currentLoopData = $fulfillmentStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($fs->value); ?>" <?php echo e($story->fulfillment_status === $fs ? 'selected' : ''); ?>>
                                                <?php echo e($fs->icon()); ?> <?php echo e($fs->labelForStory($story)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </form>
                            </td>

                            <!-- Column 5: WhatsApp Direct Follow Up -->
                            <td class="py-3.5 px-4">
                                <?php if($story->customer_phone): ?>
                                    <a
                                        href="<?php echo e($story->getWhatsAppFollowUpUrl()); ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-950/60 hover:bg-emerald-900/80 text-emerald-300 border border-emerald-700/60 text-xs font-mono font-medium transition"
                                        title="Buka WhatsApp untuk follow-up pelanggan"
                                    >
                                        <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                                        <span>Chat WA</span>
                                    </a>
                                <?php else: ?>
                                    <span class="text-neutral-500 text-[11px] font-mono">No Telp Kosong</span>
                                <?php endif; ?>
                            </td>

                            <!-- Column 6: Studio Actions -->
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <?php if($story->story_type === \App\Domains\DigitalStory\Enums\StoryType::WEDDING_INVITATION): ?>
                                        <!-- Generator Undangan Personal / Tamu (Khusus Wedding) -->
                                        <button
                                            type="button"
                                            @click="openGuestModal('<?php echo e($story->id); ?>', '<?php echo e(addslashes($story->title)); ?>', '<?php echo e($story->slug); ?>', '<?php echo e(addslashes($story->sender_name . ' & ' . $story->recipient_name)); ?>', '<?php echo e(addslashes(implode("\n", $story->getGuestList()))); ?>')"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-emerald-950/80 hover:bg-emerald-900 text-emerald-300 hover:text-emerald-200 border border-emerald-600/70 transition text-xs font-mono font-semibold"
                                            title="Generator Link Tamu Personal & Salin Masal (Tanpa Barcode)"
                                        >
                                            <i class="fa-solid fa-users-viewfinder"></i>
                                            <span class="hidden md:inline">Link Tamu</span>
                                        </button>

                                        <!-- Salin Link Langsung Undangan -->
                                        <button
                                            type="button"
                                            @click="copyToClipboard('<?php echo e($story->getPublicUrl()); ?>', 'Link Undangan Pernikahan')"
                                            class="p-2 rounded-lg bg-night-bg hover:bg-white/10 text-accent hover:text-cream border border-border-subtle transition text-xs"
                                            title="Salin Link Langsung Undangan"
                                        >
                                            <i class="fa-solid fa-link"></i>
                                        </button>
                                    <?php else: ?>
                                        <!-- Print A6 QR Card (Khusus Buket Bunga / Love Letter) -->
                                        <a
                                            href="<?php echo e($story->getPrintCardUrl()); ?>"
                                            target="_blank"
                                            class="p-2 rounded-lg bg-night-bg hover:bg-white/10 text-neutral-300 hover:text-cream border border-border-subtle transition text-xs"
                                            title="Cetak Kartu Buket QR A6"
                                        >
                                            <i class="fa-solid fa-print"></i>
                                        </a>
                                    <?php endif; ?>

                                    <!-- Public Link Viewer -->
                                    <a
                                        href="<?php echo e($story->getPublicUrl()); ?>"
                                        target="_blank"
                                        class="p-2 rounded-lg bg-night-bg hover:bg-white/10 text-neutral-300 hover:text-cream border border-border-subtle transition text-xs"
                                        title="Buka Halaman Live"
                                    >
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>

                                    <!-- Edit Order -->
                                    <a
                                        href="<?php echo e(route('admin.digital-stories.edit', $story)); ?>"
                                        class="p-2 rounded-lg bg-primary/30 hover:bg-primary/50 text-accent border border-primary/40 transition text-xs"
                                        title="Edit Pesanan & Konten"
                                    >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <!-- Extend Duration -->
                                    <button
                                        type="button"
                                        @click="openExtendModal('<?php echo e($story->id); ?>', '<?php echo e(addslashes($story->title)); ?>', '<?php echo e($story->duration_plan?->value ?? '1_month'); ?>')"
                                        class="p-2 rounded-lg bg-night-bg hover:bg-white/10 text-neutral-300 hover:text-cream border border-border-subtle transition text-xs"
                                        title="Perpanjang Masa Aktif"
                                    >
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                    </button>

                                    <!-- Delete Order -->
                                    <button
                                        type="button"
                                        @click="openDeleteModal($event.currentTarget.dataset.id, $event.currentTarget.dataset.title, $event.currentTarget.dataset.code, $event.currentTarget.dataset.url)"
                                        data-id="<?php echo e($story->id); ?>"
                                        data-title="<?php echo e($story->title); ?>"
                                        data-code="<?php echo e($story->order_code ?? $story->slug); ?>"
                                        data-url="<?php echo e(route('admin.digital-stories.destroy', $story)); ?>"
                                        class="p-2 rounded-lg bg-night-bg hover:bg-rose-950/70 text-neutral-400 hover:text-rose-400 border border-border-subtle hover:border-rose-800/60 transition text-xs cursor-pointer"
                                        title="Hapus Pesanan"
                                    >
                                        <i class="fa-solid fa-trash-can pointer-events-none"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="py-10 text-center text-neutral-400 text-xs">
                                <i class="fa-solid fa-inbox text-3xl mb-2 text-neutral-600 block"></i>
                                Belum ada data pesanan surat atau undangan digital yang cocok dengan filter.
                                <div class="mt-3">
                                    <a href="<?php echo e(route('admin.digital-stories.create')); ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-primary text-cream font-semibold text-xs">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>Input Pesanan Baru Sekarang</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards View (< 640px) -->
            <div class="mt-4 sm:hidden space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $storiesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $story): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-night-bg border border-border-subtle rounded-xl p-4 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-2.5">
                            <?php if($story->story_type === \App\Domains\DigitalStory\Enums\StoryType::WEDDING_INVITATION): ?>
                                <div class="w-10 h-10 rounded-xl bg-amber-500/15 text-amber-300 flex items-center justify-center border border-amber-500/30 shrink-0 text-sm" title="Undangan Pernikahan (Cukup Link)">
                                    <i class="fa-solid fa-ring"></i>
                                </div>
                            <?php else: ?>
                                <button
                                    type="button"
                                    @click="openQrModal('<?php echo e(addslashes($story->title)); ?>', '<?php echo e($story->order_code ?? $story->slug); ?>', '<?php echo e($story->getPublicUrl()); ?>', '<?php echo e($story->getPrintCardUrl()); ?>', '<?php echo e(addslashes(str_replace(["\r", "\n"], '', $story->generateQrSvg()))); ?>')"
                                    class="w-10 h-10 rounded-xl bg-white p-1 shrink-0 cursor-pointer"
                                    title="QR Code Kartu Buket"
                                >
                                    <div class="w-full h-full flex items-center justify-center overflow-hidden">
                                        <?php echo $story->generateQrSvg(); ?>

                                    </div>
                                </button>
                            <?php endif; ?>
                            <div>
                                <span class="font-mono font-bold text-accent text-xs block"><?php echo e($story->order_code ?? 'NO-CODE'); ?></span>
                                <p class="text-xs font-semibold text-cream"><?php echo e($story->title); ?></p>
                            </div>
                        </div>
                        <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-night-surface border border-border-subtle text-accent">
                            <?php echo e($story->story_type->label()); ?>

                        </span>
                    </div>

                    <div class="text-[11px] text-neutral-400 flex items-center justify-between">
                        <span>Untuk: <strong class="text-neutral-200"><?php echo e($story->recipient_name); ?></strong></span>
                        <span class="font-mono text-[10px]"><?php echo e($story->template_key ? $story->template_key->title() : 'Template'); ?></span>
                    </div>

                    <!-- Fulfillment update & actions -->
                    <div class="pt-2 border-t border-border-subtle flex items-center justify-between gap-2">
                        <form action="<?php echo e(route('admin.digital-stories.fulfillment', $story)); ?>" method="POST" class="flex-1">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <select
                                name="fulfillment_status"
                                onchange="this.form.submit()"
                                class="w-full bg-night-surface border border-border-subtle text-cream text-[10px] font-mono rounded-lg px-2 py-1.5"
                            >
                                <?php $__currentLoopData = $fulfillmentStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($fs->value); ?>" <?php echo e($story->fulfillment_status === $fs ? 'selected' : ''); ?>>
                                        <?php echo e($fs->icon()); ?> <?php echo e($fs->labelForStory($story)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </form>

                        <?php if($story->customer_phone): ?>
                            <a
                                href="<?php echo e($story->getWhatsAppFollowUpUrl()); ?>"
                                target="_blank"
                                class="p-2 rounded-lg bg-emerald-950/60 text-emerald-300 border border-emerald-700/60 text-xs"
                                title="Chat WA"
                            >
                                <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                            </a>
                        <?php endif; ?>

                        <?php if($story->story_type === \App\Domains\DigitalStory\Enums\StoryType::WEDDING_INVITATION): ?>
                            <button
                                type="button"
                                @click="copyToClipboard('<?php echo e($story->getPublicUrl()); ?>', 'Link Undangan Pernikahan')"
                                class="p-2 rounded-lg bg-night-surface text-accent border border-border-subtle text-xs"
                                title="Salin Link Langsung"
                            >
                                <i class="fa-solid fa-link"></i>
                            </button>

                            <button
                                type="button"
                                @click="openGuestModal('<?php echo e($story->id); ?>', '<?php echo e(addslashes($story->title)); ?>', '<?php echo e($story->slug); ?>', '<?php echo e(addslashes($story->sender_name . ' & ' . $story->recipient_name)); ?>', '<?php echo e(addslashes(implode("\n", $story->getGuestList()))); ?>')"
                                class="p-2 rounded-lg bg-emerald-950/60 text-emerald-300 border border-emerald-700/60 text-xs"
                                title="Generator Link Tamu Personal"
                            >
                                <i class="fa-solid fa-users-viewfinder"></i>
                            </button>
                        <?php else: ?>
                            <a
                                href="<?php echo e($story->getPrintCardUrl()); ?>"
                                target="_blank"
                                class="p-2 rounded-lg bg-night-surface text-neutral-300 border border-border-subtle text-xs"
                                title="Cetak A6"
                            >
                                <i class="fa-solid fa-print"></i>
                            </a>
                        <?php endif; ?>

                        <a
                            href="<?php echo e(route('admin.digital-stories.edit', $story)); ?>"
                            class="p-2 rounded-lg bg-primary/30 text-accent border border-primary/40 text-xs"
                            title="Edit"
                        >
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <button
                            type="button"
                            @click="openDeleteModal($event.currentTarget.dataset.id, $event.currentTarget.dataset.title, $event.currentTarget.dataset.code, $event.currentTarget.dataset.url)"
                            data-id="<?php echo e($story->id); ?>"
                            data-title="<?php echo e($story->title); ?>"
                            data-code="<?php echo e($story->order_code ?? $story->slug); ?>"
                            data-url="<?php echo e(route('admin.digital-stories.destroy', $story)); ?>"
                            class="p-2 rounded-lg bg-night-surface hover:bg-rose-950/70 text-neutral-400 hover:text-rose-400 border border-border-subtle hover:border-rose-800/60 text-xs cursor-pointer"
                            title="Hapus"
                        >
                            <i class="fa-solid fa-trash-can pointer-events-none"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="py-8 text-center text-neutral-400 text-xs">
                    Belum ada data pesanan yang cocok.
                </div>
                <?php endif; ?>
            </div>

            <!-- Pagination Bar -->
            <?php if(method_exists($storiesList, 'hasPages') && $storiesList->hasPages()): ?>
                <div class="mt-5 pt-4 border-t border-border-subtle">
                    <?php echo e($storiesList->links()); ?>

                </div>
            <?php endif; ?>
        </div>

        <!-- 6. QR CODE MODAL DIALOG (BucketFlow Standard) -->
        <div
            x-show="qrModalOpen"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
            role="dialog"
            aria-modal="true"
        >
            <div
                @click.away="closeQrModal()"
                x-show="qrModalOpen"
                x-transition:enter="transition duration-400 ease-spring transform"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition duration-200 ease-spring-in transform"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-night-surface border border-border-subtle rounded-2xl shadow-2xl p-6 text-cream max-w-sm w-full space-y-4"
            >
                <div class="flex items-center justify-between pb-3 border-b border-border-subtle">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-qrcode text-accent"></i>
                        <h3 class="font-heading font-bold text-cream text-base">QR Code Kartu Buket</h3>
                    </div>
                    <button @click="closeQrModal()" class="text-neutral-400 hover:text-white p-1">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="text-center space-y-2">
                    <p class="font-mono text-accent text-xs font-bold" x-text="currentQrCode"></p>
                    <p class="text-xs text-neutral-300" x-text="currentQrStoryTitle"></p>

                    <div class="w-48 h-48 mx-auto bg-white p-3 rounded-2xl shadow-inner border border-white/20 flex items-center justify-center">
                        <div class="w-full h-full flex items-center justify-center overflow-hidden" x-html="currentQrSvg"></div>
                    </div>
                    <p class="text-[11px] font-mono text-neutral-400 truncate mt-2" x-text="currentQrPublicUrl"></p>
                </div>

                <div class="pt-3 border-t border-border-subtle grid grid-cols-2 gap-2">
                    <button
                        type="button"
                        @click="copyToClipboard(currentQrPublicUrl, 'Link Pesanan')"
                        class="px-3 py-2 rounded-xl bg-night-bg hover:bg-white/10 text-neutral-300 border border-border-subtle text-xs font-mono font-semibold transition"
                    >
                        <i class="fa-solid fa-link mr-1"></i> Salin Link
                    </button>

                    <a
                        :href="currentQrPrintUrl"
                        target="_blank"
                        class="px-3 py-2 rounded-xl bg-primary hover:bg-primary-dark text-cream text-xs font-mono font-semibold transition flex items-center justify-center gap-1.5"
                    >
                        <i class="fa-solid fa-print"></i> Cetak A6
                    </a>
                </div>
            </div>
        </div>

        <!-- 7. EXTEND DURATION MODAL DIALOG -->
        <div
            x-show="extendModalOpen"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
            role="dialog"
            aria-modal="true"
        >
            <div
                @click.away="closeExtendModal()"
                x-show="extendModalOpen"
                x-transition:enter="transition duration-400 ease-spring transform"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition duration-200 ease-spring-in transform"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-night-surface border border-border-subtle rounded-2xl shadow-2xl p-6 text-cream max-w-sm w-full space-y-4"
            >
                <div class="flex items-center justify-between pb-3 border-b border-border-subtle">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-accent"></i>
                        <h3 class="font-heading font-bold text-cream text-base">Perpanjang Durasi</h3>
                    </div>
                    <button @click="closeExtendModal()" class="text-neutral-400 hover:text-white p-1">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form :action="'/admin/digital-stories/' + currentStoryId + '/extend'" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <div>
                        <p class="text-xs text-neutral-300 mb-1" x-text="currentStoryTitle"></p>
                        <label class="block text-[11px] font-mono text-neutral-400 mb-1">Pilih Paket Perpanjangan</label>
                        <select
                            name="duration_plan"
                            class="w-full bg-night-bg border border-border-subtle text-cream rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-primary"
                        >
                            <?php $__currentLoopData = $durationPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($plan->value); ?>">
                                    <?php echo e($plan->label()); ?> — <?php echo e($plan->durationDays() ? '+' . $plan->durationDays() . ' Hari' : 'Selamanya'); ?> (<?php echo e($plan->priceFormatted()); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="pt-3 border-t border-border-subtle flex items-center justify-end gap-2">
                        <button
                            type="button"
                            @click="closeExtendModal()"
                            class="px-4 py-2 rounded-xl bg-night-bg hover:bg-white/10 text-neutral-400 hover:text-cream border border-border-subtle text-xs font-mono"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 rounded-xl bg-primary hover:bg-primary-dark text-cream text-xs font-mono font-semibold transition"
                        >
                            Simpan Perpanjangan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 8. QUICK GUEST LINK GENERATOR MODAL DIALOG -->
        <div
            x-show="guestModalOpen"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
            role="dialog"
            aria-modal="true"
        >
            <div
                @click.away="closeGuestModal()"
                x-show="guestModalOpen"
                x-transition:enter="transition duration-400 ease-spring transform"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition duration-200 ease-spring-in transform"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-night-surface border border-border-subtle rounded-2xl shadow-2xl p-6 text-cream max-w-2xl w-full space-y-4 max-h-[90vh] overflow-y-auto"
            >
                <div class="flex items-center justify-between pb-3 border-b border-border-subtle">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-users-viewfinder text-accent text-lg"></i>
                        <div>
                            <h3 class="font-heading font-bold text-cream text-base">Generator Link Tamu Personal</h3>
                            <p class="text-[11px] text-neutral-400 font-mono" x-text="guestStoryTitle"></p>
                        </div>
                    </div>
                    <button @click="closeGuestModal()" class="text-neutral-400 hover:text-white p-1">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Input Textarea -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-mono text-neutral-300 font-bold">
                            Tempel Daftar Nama Tamu (1 Nama Per Baris)
                        </label>
                        <span class="px-2 py-0.5 rounded-full bg-primary/30 text-accent font-mono text-xs font-bold" x-text="parsedGuests.length + ' Tamu'"></span>
                    </div>
                    <textarea
                        x-model="guestInputText"
                        rows="6"
                        placeholder="Contoh:&#10;Bpk. Budi Santoso &amp; Keluarga&#10;dr. Hendra Pratama&#10;Siti Aminah&#10;Dimas &amp; Partner"
                        class="w-full bg-night-bg border border-border-subtle rounded-xl p-3 text-xs font-mono text-cream focus:outline-none focus:border-primary transition leading-relaxed"
                    ></textarea>
                </div>

                <!-- Bulk Action Buttons -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <button
                        type="button"
                        @click="copyAllGuestLinks()"
                        class="px-4 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-cream font-mono text-xs font-bold shadow-md transition flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <i class="fa-solid fa-copy"></i>
                        <span>Salin Semua Link (List)</span>
                    </button>

                    <button
                        type="button"
                        @click="copyGuestSpreadsheet()"
                        class="px-4 py-2.5 rounded-xl bg-night-bg hover:bg-white/10 text-cream border border-border-subtle hover:border-brand-amber/40 font-mono text-xs font-bold transition flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <i class="fa-solid fa-table"></i>
                        <span>Salin Format Excel (TSV)</span>
                    </button>
                </div>

                <!-- Toast in Modal -->
                <div
                    x-show="guestShowToast"
                    x-transition
                    class="p-2.5 rounded-xl bg-primary/40 border border-brand-amber/40 text-accent font-mono text-xs text-center font-bold"
                    x-text="guestCopiedToast"
                ></div>

                <!-- Live Mini Table -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-mono text-neutral-400">Pratinjau Link Dihasilkan:</span>
                        <a
                            :href="'/admin/digital-stories/' + guestStoryId + '/guests'"
                            target="_blank"
                            class="text-accent hover:underline font-mono text-[11px] flex items-center gap-1"
                        >
                            <span>Buka Halaman Lengkap Generator Tamu</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                        </a>
                    </div>

                    <div class="max-h-48 overflow-y-auto rounded-xl border border-border-subtle bg-night-bg divide-y divide-border-subtle">
                        <template x-for="(g, idx) in parsedGuests" :key="g + idx">
                            <div class="p-2.5 flex items-center justify-between gap-3 text-xs hover:bg-white/5 transition">
                                <div class="min-w-0">
                                    <span class="font-semibold text-cream block truncate" x-text="(idx + 1) + '. ' + g"></span>
                                    <span class="text-[10px] font-mono text-accent block truncate" x-text="getGuestUrl(g)"></span>
                                </div>
                                <div class="flex items-center gap-1 shrink-0">
                                    <button
                                        type="button"
                                        @click="navigator.clipboard.writeText(getGuestUrl(g)); guestCopiedToast = '✅ Link ' + g + ' tersalin!'; guestShowToast = true; setTimeout(() => guestShowToast = false, 2000);"
                                        class="p-1.5 rounded-lg bg-night-surface hover:bg-white/10 text-neutral-300 hover:text-cream border border-border-subtle text-xs transition"
                                        title="Salin Link"
                                    >
                                        <i class="fa-solid fa-copy"></i>
                                    </button>
                                    <a
                                        :href="getGuestUrl(g)"
                                        target="_blank"
                                        class="p-1.5 rounded-lg bg-night-surface hover:bg-white/10 text-neutral-300 hover:text-cream border border-border-subtle text-xs transition"
                                        title="Buka Live"
                                    >
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                </div>
                            </div>
                        </template>

                        <template x-if="parsedGuests.length === 0">
                            <div class="py-6 text-center text-neutral-500 font-mono text-xs">
                                Tempel nama tamu pada kotak di atas untuk melihat preview link.
                            </div>
                        </template>
                    </div>
                </div>

                <div class="pt-3 border-t border-border-subtle flex items-center justify-between">
                    <span class="text-[11px] font-mono text-neutral-400">
                        *Format otomatis menambahkan parameter <code>?to=Nama+Tamu</code>
                    </span>
                    <button
                        type="button"
                        @click="closeGuestModal()"
                        class="px-4 py-2 rounded-xl bg-night-bg hover:bg-white/10 text-neutral-300 border border-border-subtle text-xs font-mono font-semibold"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- 7. DELETE CONFIRMATION MODAL -->
        <div
            x-show="deleteModalOpen"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
            role="dialog"
            aria-modal="true"
            @keydown.escape.window="closeDeleteModal()"
        >
            <div
                @click.away="closeDeleteModal()"
                x-show="deleteModalOpen"
                x-transition:enter="transition duration-200 ease-out transform"
                x-transition:enter-start="scale-95 opacity-0"
                x-transition:enter-end="scale-100 opacity-100"
                x-transition:leave="transition duration-150 ease-in transform"
                x-transition:leave-start="scale-100 opacity-100"
                x-transition:leave-end="scale-95 opacity-0"
                class="w-full max-w-md bg-night-surface border border-rose-500/30 rounded-2xl p-6 shadow-2xl space-y-4"
            >
                <div class="flex items-start gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-rose-950/80 border border-rose-500/40 text-rose-400 flex items-center justify-center shrink-0 text-xl shadow-lg shadow-rose-950/50">
                        <i class="fa-solid fa-trash-can"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-heading font-bold text-cream text-lg">Hapus Pesanan</h3>
                        <p class="text-xs text-neutral-300 mt-1 leading-relaxed">
                            Apakah Anda yakin ingin menghapus pesanan ini?
                        </p>
                        <div class="mt-2.5 p-3 rounded-xl bg-night-bg/80 border border-border-subtle text-xs font-mono space-y-1">
                            <div class="text-cream font-bold truncate" x-text="deleteStoryTitle"></div>
                            <div class="text-neutral-400 text-[11px]" x-text="'Kode: ' + deleteStoryCode"></div>
                        </div>
                        <p class="text-[11px] text-rose-400/90 mt-2">
                            <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                            Data pesanan, galeri foto, dan link undangan akan dihapus dari sistem.
                        </p>
                    </div>
                </div>

                <form :action="deleteActionUrl" method="POST" class="flex items-center justify-end gap-2.5 pt-3 border-t border-border-subtle">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button
                        type="button"
                        @click="closeDeleteModal()"
                        class="px-4 py-2 rounded-xl bg-night-bg hover:bg-white/10 text-neutral-300 font-mono text-xs font-semibold transition border border-border-subtle cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-mono text-xs font-bold transition shadow-lg shadow-rose-600/30 flex items-center gap-1.5 cursor-pointer active:scale-95"
                    >
                        <i class="fa-solid fa-trash-can text-xs"></i>
                        <span>Ya, Hapus Pesanan</span>
                    </button>
                </form>
            </div>
        </div>

    </div> <!-- Close main x-data container -->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $attributes = $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $component = $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php /**PATH D:\ILHAM\All Project\all about my job\ALL MAJA FLOWER\SISTEM - UNDANGAN - SURAT\resources\views/digital-story/admin/index.blade.php ENDPATH**/ ?>