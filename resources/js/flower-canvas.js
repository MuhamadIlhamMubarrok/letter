/**
 * Maja Flower - Interactive Botanical Petal Breeze & Bloom Canvas
 * High-performance 60fps petal simulation with realistic organic wind,
 * mouse-stirred aerodynamics, and interactive "Click to Bloom" blossom effect.
 */

export class FlowerBreezeCanvas {
    constructor(canvasId = 'hero-flower-canvas') {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) return;

        this.ctx = this.canvas.getContext('2d');
        if (!this.ctx) return;

        this.petals = [];
        this.blossoms = [];
        this.maxPetals = 22; // Kept lightweight for battery/CPU efficiency
        this.width = 0;
        this.height = 0;
        this.dpr = Math.min(window.devicePixelRatio || 1, 2);
        this.animationId = null;
        this.isRunning = false;

        // Mouse physics
        this.mouse = { x: -1000, y: -1000, vx: 0, vy: 0, lastX: -1000, lastY: -1000 };
        this.time = 0;

        // Botanical Petal Color Palettes (Soft Velvet Rose, Pastel Sakura, Golden Pollen)
        this.palettes = [
            { c1: '#F8B4C0', c2: '#E7748B', type: 'rose' },       // Soft Rose
            { c1: '#FCE7EB', c2: '#F4A6B7', type: 'sakura' },     // Pale Sakura
            { c1: '#FBEED9', c2: '#E8C589', type: 'golden' },     // Golden Champagne
            { c1: '#E8F5E9', c2: '#A5D6A7', type: 'botanical' },  // Fresh Sage
            { c1: '#FFFFFF', c2: '#FDE4EA', type: 'sakura' },     // Pure Blossom
        ];

        this.init();
    }

    init() {
        this.resize();
        window.addEventListener('resize', () => this.resize(), { passive: true });

        // Seed initial floating petals
        for (let i = 0; i < this.maxPetals; i++) {
            this.petals.push(this.createPetal(true));
        }

        // Setup mouse/touch interactivity on the hero section
        const heroSection = this.canvas.closest('section') || document.body;

        heroSection.addEventListener('mousemove', (e) => this.onMouseMove(e), { passive: true });
        heroSection.addEventListener('mouseleave', () => this.onMouseLeave(), { passive: true });
        heroSection.addEventListener('touchmove', (e) => this.onTouchMove(e), { passive: true });
        heroSection.addEventListener('touchend', () => this.onMouseLeave(), { passive: true });

        // Click / Tap to Bloom: Spawns a flowering blossom wherever the user clicks
        heroSection.addEventListener('pointerdown', (e) => {
            // Avoid triggering when user clicks on links or interactive buttons
            if (e.target.closest('button, a, input, [role="button"]')) return;
            const rect = this.canvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            this.createBlossom(x, y);
        });

        // Listen for global custom trigger (e.g. when user switches bouquet mood)
        window.addEventListener('hero-flower-burst', (e) => {
            const rect = this.canvas.getBoundingClientRect();
            const x = (e.detail?.x !== undefined) ? e.detail.x - rect.left : this.width / (2 * this.dpr);
            const y = (e.detail?.y !== undefined) ? e.detail.y - rect.top : this.height / (2 * this.dpr);
            this.createBlossom(x, y, 1.25);
            // Spawn 6 flutter petals
            for (let i = 0; i < 6; i++) {
                this.petals.push(this.createPetal(false, x + (Math.random() - 0.5) * 80, y + (Math.random() - 0.5) * 80));
            }
        });

        // Visibility observer: stops rendering when scrolled out of view to save 100% resources
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    this.start();
                } else {
                    this.stop();
                }
            });
        }, { threshold: 0.05 });

        observer.observe(heroSection);
    }

    resize() {
        const rect = this.canvas.getBoundingClientRect();
        this.width = rect.width * this.dpr;
        this.height = rect.height * this.dpr;

        this.canvas.width = this.width;
        this.canvas.height = this.height;
    }

    createPetal(randomY = false, spawnX = null, spawnY = null) {
        const pal = this.palettes[Math.floor(Math.random() * this.palettes.length)];
        const size = (12 + Math.random() * 12) * this.dpr;

        return {
            x: (spawnX !== null ? spawnX * this.dpr : Math.random() * this.width),
            y: (spawnY !== null ? spawnY * this.dpr : (randomY ? Math.random() * this.height : -size * 2)),
            vx: (Math.random() * 0.8 + 0.4) * this.dpr,
            vy: (Math.random() * 1.0 + 0.7) * this.dpr,
            size: size,
            angle: Math.random() * Math.PI * 2,
            vAngle: (Math.random() - 0.5) * 0.025,
            flipAngle: Math.random() * Math.PI * 2,
            vFlip: Math.random() * 0.03 + 0.015,
            swayFreq: Math.random() * 0.02 + 0.01,
            swayAmp: (Math.random() * 1.5 + 0.5) * this.dpr,
            seed: Math.random() * 100,
            color1: pal.c1,
            color2: pal.c2,
            type: pal.type,
            alpha: Math.random() * 0.35 + 0.55,
        };
    }

    createBlossom(x, y, scaleMult = 1.0) {
        const pal = this.palettes[Math.floor(Math.random() * this.palettes.length)];
        const petalsCount = Math.random() > 0.4 ? 6 : 8;

        this.blossoms.push({
            x: x * this.dpr,
            y: y * this.dpr,
            radius: (32 + Math.random() * 16) * this.dpr * scaleMult,
            petals: petalsCount,
            angle: Math.random() * Math.PI,
            rotSpeed: (Math.random() - 0.5) * 0.008,
            color1: pal.c1,
            color2: pal.c2,
            birth: performance.now(),
            life: 1800, // 1.8 seconds duration
        });

        // Scatter 3 tiny ambient petals from the bloom center
        for (let i = 0; i < 3; i++) {
            if (this.petals.length < this.maxPetals + 8) {
                const angle = (i / 3) * Math.PI * 2 + Math.random();
                const speed = (Math.random() * 2 + 1) * this.dpr;
                const p = this.createPetal(false, x, y);
                p.vx += Math.cos(angle) * speed;
                p.vy += Math.sin(angle) * speed;
                this.petals.push(p);
            }
        }
    }

    onMouseMove(e) {
        const rect = this.canvas.getBoundingClientRect();
        const currX = (e.clientX - rect.left) * this.dpr;
        const currY = (e.clientY - rect.top) * this.dpr;

        if (this.mouse.lastX !== -1000) {
            this.mouse.vx = (currX - this.mouse.lastX) * 0.35;
            this.mouse.vy = (currY - this.mouse.lastY) * 0.35;
        }

        this.mouse.x = currX;
        this.mouse.y = currY;
        this.mouse.lastX = currX;
        this.mouse.lastY = currY;
    }

    onTouchMove(e) {
        if (!e.touches || !e.touches[0]) return;
        this.onMouseMove(e.touches[0]);
    }

    onMouseLeave() {
        this.mouse.x = -1000;
        this.mouse.y = -1000;
        this.mouse.vx = 0;
        this.mouse.vy = 0;
        this.mouse.lastX = -1000;
        this.mouse.lastY = -1000;
    }

    start() {
        if (this.isRunning) return;
        this.isRunning = true;
        let lastTimestamp = performance.now();

        const loop = (now) => {
            if (!this.isRunning) return;
            const dt = Math.min((now - lastTimestamp) / 1000, 0.1);
            lastTimestamp = now;
            this.update(dt, now);
            this.draw();
            this.animationId = requestAnimationFrame(loop);
        };

        this.animationId = requestAnimationFrame(loop);
    }

    stop() {
        this.isRunning = false;
        if (this.animationId) {
            cancelAnimationFrame(this.animationId);
            this.animationId = null;
        }
    }

    update(dt, now) {
        this.time += dt;

        // Dampen mouse velocity
        this.mouse.vx *= 0.88;
        this.mouse.vy *= 0.88;

        // Ambient gentle sinusoidal breeze vector
        const windX = Math.sin(this.time * 0.7) * 0.6 * this.dpr;

        // Update Petals
        for (let i = 0; i < this.petals.length; i++) {
            const p = this.petals[i];

            // Natural movement with sway
            const sway = Math.sin(this.time * p.swayFreq * 60 + p.seed) * p.swayAmp;
            p.x += (p.vx + windX + sway);
            p.y += p.vy;

            // Rotation & 3D tumbling
            p.angle += p.vAngle;
            p.flipAngle += p.vFlip;

            // Mouse breeze physics: swirl petals when cursor approaches
            if (this.mouse.x > 0) {
                const dx = p.x - this.mouse.x;
                const dy = p.y - this.mouse.y;
                const distSq = dx * dx + dy * dy;
                const influenceRadius = 150 * this.dpr;

                if (distSq < influenceRadius * influenceRadius && distSq > 10) {
                    const dist = Math.sqrt(distSq);
                    const force = (1 - dist / influenceRadius) * 2.8;
                    p.x += (dx / dist) * force * this.dpr + this.mouse.vx * 0.2;
                    p.y += (dy / dist) * force * this.dpr + this.mouse.vy * 0.2;
                    p.angle += force * 0.05;
                }
            }

            // Recycle petals that go off screen
            if (p.y > this.height + p.size * 2 || p.x > this.width + p.size * 2 || p.x < -p.size * 2) {
                // If we have extra burst petals, remove them; otherwise recycle to top
                if (this.petals.length > this.maxPetals) {
                    this.petals.splice(i, 1);
                    i--;
                } else {
                    Object.assign(p, this.createPetal(false));
                }
            }
        }

        // Update Blossoms
        for (let i = 0; i < this.blossoms.length; i++) {
            const b = this.blossoms[i];
            const age = now - b.birth;
            if (age >= b.life) {
                this.blossoms.splice(i, 1);
                i--;
            } else {
                b.angle += b.rotSpeed;
            }
        }
    }

    draw() {
        const ctx = this.ctx;
        ctx.clearRect(0, 0, this.width, this.height);

        // 1. Draw Blossoms (Under petals)
        const now = performance.now();
        for (let i = 0; i < this.blossoms.length; i++) {
            const b = this.blossoms[i];
            const progress = (now - b.birth) / b.life; // 0 to 1

            // Elastic unfold easing: blooms open rapidly in first 25% then soft float & dissolve
            let scale;
            let alpha;

            if (progress < 0.25) {
                // Bloom open
                const t = progress / 0.25;
                scale = Math.sin((t * Math.PI) / 2) * 1.15; // slight pop
            } else if (progress < 0.4) {
                scale = 1.15 - (progress - 0.25) / 0.15 * 0.15;
            } else {
                scale = 1.0;
            }

            if (progress > 0.65) {
                alpha = 1 - (progress - 0.65) / 0.35;
            } else {
                alpha = Math.min(progress / 0.1, 1);
            }

            this.drawBlossomFlower(b.x, b.y, b.radius * scale, b.petals, b.angle, b.color1, b.color2, alpha);
        }

        // 2. Draw Floating Petals
        for (let i = 0; i < this.petals.length; i++) {
            const p = this.petals[i];
            this.drawSinglePetal(p);
        }
    }

    drawSinglePetal(p) {
        const ctx = this.ctx;
        const flip = Math.cos(p.flipAngle);

        ctx.save();
        ctx.translate(p.x, p.y);
        ctx.rotate(p.angle);
        ctx.scale(1, Math.abs(flip) < 0.05 ? 0.05 : flip); // 3D flip illusion
        ctx.globalAlpha = p.alpha;

        const s = p.size;
        const grad = ctx.createLinearGradient(0, -s, 0, s);
        grad.addColorStop(0, p.color1);
        grad.addColorStop(1, p.color2);
        ctx.fillStyle = grad;

        ctx.beginPath();
        if (p.type === 'sakura') {
            // Sakura shape with notched tip
            ctx.moveTo(0, s);
            ctx.bezierCurveTo(-s * 0.7, s * 0.3, -s * 0.8, -s * 0.7, -s * 0.25, -s);
            ctx.lineTo(0, -s * 0.78);
            ctx.lineTo(s * 0.25, -s);
            ctx.bezierCurveTo(s * 0.8, -s * 0.7, s * 0.7, s * 0.3, 0, s);
        } else {
            // Elegant curved organic rose petal
            ctx.moveTo(0, s);
            ctx.bezierCurveTo(-s * 0.75, s * 0.35, -s * 0.65, -s * 0.7, 0, -s);
            ctx.bezierCurveTo(s * 0.65, -s * 0.7, s * 0.75, s * 0.35, 0, s);
        }
        ctx.closePath();
        ctx.fill();

        // Subtle petal vein highlight
        ctx.strokeStyle = 'rgba(255, 255, 255, 0.4)';
        ctx.lineWidth = Math.max(0.7 * this.dpr, 0.8);
        ctx.beginPath();
        ctx.moveTo(0, s * 0.7);
        ctx.quadraticCurveTo(s * 0.08, 0, 0, -s * 0.65);
        ctx.stroke();

        ctx.restore();
    }

    drawBlossomFlower(cx, cy, radius, numPetals, baseAngle, col1, col2, alpha) {
        const ctx = this.ctx;
        ctx.save();
        ctx.translate(cx, cy);
        ctx.rotate(baseAngle);
        ctx.globalAlpha = Math.max(0, Math.min(1, alpha));

        // Outer soft floral aura
        const auraGrad = ctx.createRadialGradient(0, 0, 0, 0, 0, radius * 1.3);
        auraGrad.addColorStop(0, 'rgba(255, 235, 240, 0.45)');
        auraGrad.addColorStop(0.6, 'rgba(255, 200, 215, 0.2)');
        auraGrad.addColorStop(1, 'rgba(255, 255, 255, 0)');
        ctx.fillStyle = auraGrad;
        ctx.beginPath();
        ctx.arc(0, 0, radius * 1.3, 0, Math.PI * 2);
        ctx.fill();

        // Radiating petals
        const angleStep = (Math.PI * 2) / numPetals;
        const petalLen = radius;
        const petalWidth = radius * 0.48;

        for (let i = 0; i < numPetals; i++) {
            ctx.save();
            ctx.rotate(i * angleStep);

            const pGrad = ctx.createRadialGradient(0, petalLen * 0.5, 0, 0, petalLen * 0.5, petalLen);
            pGrad.addColorStop(0, col1);
            pGrad.addColorStop(1, col2);
            ctx.fillStyle = pGrad;

            ctx.beginPath();
            ctx.moveTo(0, 0);
            ctx.bezierCurveTo(-petalWidth, petalLen * 0.4, -petalWidth * 0.8, petalLen, 0, petalLen);
            ctx.bezierCurveTo(petalWidth * 0.8, petalLen, petalWidth, petalLen * 0.4, 0, 0);
            ctx.closePath();
            ctx.fill();

            // Inner translucent vein
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.4)';
            ctx.lineWidth = 1 * this.dpr;
            ctx.beginPath();
            ctx.moveTo(0, 4);
            ctx.lineTo(0, petalLen * 0.85);
            ctx.stroke();

            ctx.restore();
        }

        // Flower golden pistils & stamen center
        ctx.fillStyle = '#F59E0B'; // Warm amber golden
        ctx.beginPath();
        ctx.arc(0, 0, radius * 0.18, 0, Math.PI * 2);
        ctx.fill();

        // Stamen pollen sparkles
        for (let j = 0; j < 6; j++) {
            const stAngle = (j / 6) * Math.PI * 2;
            const dist = radius * 0.25;
            ctx.fillStyle = '#FDE68A';
            ctx.beginPath();
            ctx.arc(Math.cos(stAngle) * dist, Math.sin(stAngle) * dist, 2 * this.dpr, 0, Math.PI * 2);
            ctx.fill();
        }

        ctx.restore();
    }
}

// Auto-initialize when DOM is ready
export function initHeroFlowerCanvas() {
    if (typeof window === 'undefined') return;
    const canvas = document.getElementById('hero-flower-canvas');
    if (canvas) {
        window.heroFlowerCanvasInstance = new FlowerBreezeCanvas('hero-flower-canvas');
    }
}
