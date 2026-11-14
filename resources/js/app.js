import './bootstrap';
import Alpine from 'alpinejs';
import Lenis from 'lenis';
import 'lenis/dist/lenis.css';
import { animate, inView, scroll, stagger } from 'motion';
import { initHeroFlowerCanvas } from './flower-canvas';
import { freshFlowersVault } from './fresh-flowers-vault';

window.Alpine = Alpine;
window.freshFlowersVault = freshFlowersVault;
Alpine.data('freshFlowersVault', freshFlowersVault);

// Export Framer Motion and Lenis globally
window.motion = { animate, inView, scroll, stagger };

// 1. INITIALIZE LENIS SMOOTH MOMENTUM SCROLL
let lenisInstance = null;
if (typeof window !== 'undefined') {
    lenisInstance = new Lenis({
        duration: 1.25,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // Exponential luxury easing
        orientation: 'vertical',
        gestureOrientation: 'vertical',
        smoothWheel: true,
        wheelMultiplier: 1.0,
        touchMultiplier: 1.4,
        infinite: false,
    });

    window.lenis = lenisInstance;

    // Synchronize Lenis with RequestAnimationFrame for butter-smooth 60/120Hz refresh rates
    function raf(time) {
        lenisInstance.raf(time);
        requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);

    // Smooth momentum scroll for internal anchor links (with floating navbar offset)
    document.addEventListener('click', (e) => {
        const anchor = e.target.closest('a[href*="#"]');
        if (!anchor) return;

        const href = anchor.getAttribute('href');
        if (!href || href === '#' || href.startsWith('javascript:')) return;

        try {
            const url = new URL(anchor.href, window.location.href);
            if (url.pathname === window.location.pathname && url.hash && url.hash.length > 1) {
                const targetEl = document.querySelector(url.hash);
                if (targetEl) {
                    e.preventDefault();
                    lenisInstance.scrollTo(targetEl, {
                        offset: -90, // Floating navbar clearance
                        duration: 1.3,
                        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                    });
                }
            }
        } catch (err) {
            // Ignore malformed URLs
        }
    });
}

// 2. FRAMER MOTION SECTION & CARD TRANSITIONS
function initSectionMotion() {
    if (typeof window === 'undefined' || !window.motion) return;
    const { animate, inView, stagger } = window.motion;

    // Animate all sections as they enter the viewport
    const sections = document.querySelectorAll('main section, [data-motion="section"]');

    sections.forEach((section, index) => {
        // Skip hero section from hiding since it is immediately visible above the fold
        const isHero = index === 0 || section.classList.contains('hero-section');

        if (!isHero) {
            // Set initial state for below-the-fold sections
            section.style.opacity = '0';
            section.style.transform = 'translateY(36px)';
            section.style.willChange = 'opacity, transform';

            // Trigger Framer Motion reveal when section enters view
            inView(
                section,
                () => {
                    animate(
                        section,
                        { opacity: 1, transform: 'translateY(0px)' },
                        { duration: 0.85, ease: [0.22, 1, 0.36, 1] }
                    );

                    // Animate child cards / items with elegant stagger (skip dynamic Alpine fresh-flowers-vault to ensure silky 60/120fps scrolling)
                    const cards = section.id === 'fresh-flowers-vault'
                        ? []
                        : section.querySelectorAll('[data-motion-card], .motion-card, .grid > div, .stagger-item');

                    if (cards.length > 1 && cards.length <= 12) {
                        animate(
                            cards,
                            { opacity: [0, 1], transform: ['translateY(24px)', 'translateY(0px)'] },
                            {
                                delay: stagger(0.08, { startDelay: 0.1 }),
                                duration: 0.65,
                                ease: [0.22, 1, 0.36, 1],
                            }
                        );
                    }
                },
                { margin: '-60px 0px -40px 0px' }
            );
        } else {
            // For Hero: Animate smoothly on page load
            animate(
                section,
                { opacity: [0.3, 1], transform: ['translateY(18px)', 'translateY(0px)'] },
                { duration: 0.9, ease: [0.22, 1, 0.36, 1] }
            );
        }
    });

    // Animate explicit motion elements like badges, headings, CTA boxes
    const motionItems = document.querySelectorAll('[data-motion="fade-up"]');
    motionItems.forEach((el) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(28px)';
        inView(el, () => {
            animate(el, { opacity: 1, transform: 'translateY(0px)' }, { duration: 0.7, ease: [0.22, 1, 0.36, 1] });
        });
    });
}

// Run section motion & interactive flower canvas once DOM is interactive
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initSectionMotion();
        initHeroFlowerCanvas();
    });
} else {
    initSectionMotion();
    initHeroFlowerCanvas();
}

// Start Alpine
Alpine.start();
