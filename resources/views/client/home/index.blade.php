<x-layouts.client>
    {{-- 1. Hero Living Atelier Section --}}
    @include('client.home.sections.hero')

    {{-- 2. Alur Pemesanan / Order Stepper --}}
    @include('client.home.sections.order-stepper')

    {{-- 3. Katalog Pilihan / Bestsellers --}}
    @include('client.home.sections.bestsellers')

    {{-- 4. Ketersediaan Bunga Segar / Fresh Flower Vault --}}
    @include('client.home.sections.fresh-flowers')

    {{-- 5. Rekomendasi Sesuai Momen & Filosofi Bunga --}}
    @include('client.home.sections.recommendations')

    {{-- 6. Bespoke Custom Bouquet Studio --}}
    @include('client.home.sections.custom-studio')

    {{-- 7. Testimoni Momen Bahagia & Polaroid Photos --}}
    @include('client.home.sections.testimonials')

    {{-- 8. FAQ Tanya Jawab Botani --}}
    @include('client.home.sections.faq')

    {{-- 9. Kontak Studio, Jam Operasional & Peta Interaktif --}}
    @include('client.home.sections.contact')
</x-layouts.client>