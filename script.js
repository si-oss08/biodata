document.addEventListener('DOMContentLoaded', () => {
initScrollReveal();
initProjectFilters();
initTouchEffects();
initBackToTop();
});
(function() {
    const canvas = document.getElementById('dotCanvas');
    const glowEl = document.getElementById('glowCircle');
    if (!canvas) return;

    const ctx = canvas.getContext('2d', { alpha: true });
    const TWO_PI = Math.PI * 2;

    // Config matching original React component props exactly
    const config = {
        dotRadius: 1.5,
        dotSpacing: 14,
        cursorRadius: 500,
        cursorForce: 0.1,
        bulgeOnly: true,
        bulgeStrength: 67,
        glowRadius: 160,
        sparkle: false,
        waveAmplitude: 0,
        gradientFrom: '#c8a96e',
        gradientTo: '#9b8254',
        glowColor: '#120F17'
    };

    let dots = [];
    let mouse = { x: -9999, y: -9999, prevX: -9999, prevY: -9999, speed: 0 };
    let rafId = null;
    let size = { w: 0, h: 0 };
    let glowOpacity = 0;
    let engagement = 0;
    let frameCount = 0;
    let resizeTimer = null;

    function doResize() {
        const dpr = Math.min(window.devicePixelRatio || 1, 2);
        const w = window.innerWidth;
        const h = window.innerHeight;

        canvas.width = w * dpr;
        canvas.height = h * dpr;
        canvas.style.width = `${w}px`;
        canvas.style.height = `${h}px`;
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

        size = { w, h };
        buildDots(w, h);
    }

    function resize() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(doResize, 100);
    }

    function buildDots(w, h) {
        const step = config.dotRadius + config.dotSpacing;
        const cols = Math.floor(w / step);
        const rows = Math.floor(h / step);
        const padX = (w % step) / 2;
        const padY = (h % step) / 2;
        const newDots = new Array(rows * cols);
        let idx = 0;

        for (let row = 0; row < rows; row++) {
            for (let col = 0; col < cols; col++) {
                const ax = padX + col * step + step / 2;
                const ay = padY + row * step + step / 2;
                newDots[idx++] = { ax, ay, sx: ax, sy: ay, vx: 0, vy: 0, x: ax, y: ay };
            }
        }
        dots = newDots;
    }

    function onMouseMove(e) {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    }

    function updateMouseSpeed() {
        const dx = mouse.prevX - mouse.x;
        const dy = mouse.prevY - mouse.y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        mouse.speed += (dist - mouse.speed) * 0.5;
        if (mouse.speed < 0.001) mouse.speed = 0;
        mouse.prevX = mouse.x;
        mouse.prevY = mouse.y;
    }

    setInterval(updateMouseSpeed, 20);

    function tick() {
        frameCount++;
        const len = dots.length;
        const t = frameCount * 0.02;

        const targetEngagement = Math.min(mouse.speed / 5, 1);
        engagement += (targetEngagement - engagement) * 0.06;
        if (engagement < 0.001) engagement = 0;
        const eng = engagement;

        glowOpacity += (eng - glowOpacity) * 0.08;

        if (glowEl) {
            glowEl.setAttribute('cx', mouse.x);
            glowEl.setAttribute('cy', mouse.y);
            glowEl.style.opacity = glowOpacity;
        }

        ctx.clearRect(0, 0, size.w, size.h);

        const grad = ctx.createLinearGradient(0, 0, size.w, size.h);
        grad.addColorStop(0, config.gradientFrom);
        grad.addColorStop(1, config.gradientTo);
        ctx.fillStyle = grad;

        const cr = config.cursorRadius;
        const crSq = cr * cr;
        const rad = config.dotRadius / 2;
        const isBulge = config.bulgeOnly;

        ctx.beginPath();

        for (let i = 0; i < len; i++) {
            const d = dots[i];
            const dx = mouse.x - d.ax;
            const dy = mouse.y - d.ay;
            const distSq = dx * dx + dy * dy;

            if (distSq < crSq && eng > 0.01) {
                const dist = Math.sqrt(distSq);
                if (isBulge) {
                    const factor = 1 - dist / cr;
                    const push = factor * factor * config.bulgeStrength * eng;
                    const angle = Math.atan2(dy, dx);
                    d.sx += (d.ax - Math.cos(angle) * push - d.sx) * 0.15;
                    d.sy += (d.ay - Math.sin(angle) * push - d.sy) * 0.15;
                } else {
                    const angle = Math.atan2(dy, dx);
                    const move = (500 / dist) * (mouse.speed * config.cursorForce);
                    d.vx += Math.cos(angle) * -move;
                    d.vy += Math.sin(angle) * -move;
                }
            } else if (isBulge) {
                d.sx += (d.ax - d.sx) * 0.1;
                d.sy += (d.ay - d.sy) * 0.1;
            }

            if (!isBulge) {
                d.vx *= 0.9;
                d.vy *= 0.9;
                d.x = d.ax + d.vx;
                d.y = d.ay + d.vy;
                d.sx += (d.x - d.sx) * 0.1;
                d.sy += (d.y - d.sy) * 0.1;
            }

            let drawX = d.sx;
            let drawY = d.sy;
            if (config.waveAmplitude > 0) {
                drawY += Math.sin(d.ax * 0.03 + t) * config.waveAmplitude;
                drawX += Math.cos(d.ay * 0.03 + t * 0.7) * config.waveAmplitude * 0.5;
            }

            if (config.sparkle) {
                const hash = ((i * 2654435761) ^ (frameCount >> 3)) >>> 0;
                if ((hash % 100) < 3) {
                    ctx.moveTo(drawX + rad * 1.8, drawY);
                    ctx.arc(drawX, drawY, rad * 1.8, 0, TWO_PI);
                } else {
                    ctx.moveTo(drawX + rad, drawY);
                    ctx.arc(drawX, drawY, rad, 0, TWO_PI);
                }
            } else {
                ctx.moveTo(drawX + rad, drawY);
                ctx.arc(drawX, drawY, rad, 0, TWO_PI);
            }
        }

        ctx.fill();

        rafId = requestAnimationFrame(tick);
    }

    // Event bindings
    window.addEventListener('resize', resize);
    window.addEventListener('mousemove', onMouseMove, { passive: true });
    
    doResize();
    rafId = requestAnimationFrame(tick);
})();
/**
 * Fungsi untuk menangani efek sentuhan (touch) pada perangkat mobile
 */
function initTouchEffects() {
document.addEventListener('touchstart', function(e) {
    const card = e.target.closest('.info-item, .contact-button, .project-card, .github-card');
    if (card) {
    card.classList.add('is-touched');
    }
}, {passive: true});

document.addEventListener('touchend', function(e) {
    const card = e.target.closest('.info-item, .contact-button, .project-card, .github-card');
    if (card) {
    setTimeout(() => {
        card.classList.remove('is-touched');
    }, 150);
    }
});

document.addEventListener('touchcancel', function(e) {
    const card = e.target.closest('.info-item, .contact-button, .project-card, .github-card');
    if (card) {
    card.classList.remove('is-touched');
    }
});
}

/**
 * Fungsi untuk memfilter dan mengelompokkan project dengan animasi halus
 */
function initProjectFilters() {
const container = document.getElementById('projectCardsContainer');
const wrapper = document.getElementById('projectsWrapper');
const filterContainer = document.getElementById('filterContainer');

if (!container || !filterContainer || !wrapper) return;

// Ambil copy semua card project dari DOM awal
const allCards = Array.from(container.querySelectorAll('.project-card'));
const uniqueMKs = [...new Set(allCards.map(card => card.getAttribute('data-mk')))];

// Generate Tombol Filter HTML (A11y friendly)
let filterHTML = `<button class="filter-btn active" data-filter="all" aria-pressed="true">Semua Project</button>`;
uniqueMKs.forEach(mk => {
    filterHTML += `<button class="filter-btn" data-filter="${mk}" aria-pressed="false">${mk}</button>`;
});
filterContainer.innerHTML = filterHTML;

const buttons = filterContainer.querySelectorAll('.filter-btn');
buttons.forEach(btn => {
    btn.addEventListener('click', (e) => {
    // Reset status active dan aria-pressed
    buttons.forEach(b => {
        b.classList.remove('active');
        b.setAttribute('aria-pressed', 'false');
    });
    
    // Set tombol terpilih menjadi aktif
    e.target.classList.add('active');
    e.target.setAttribute('aria-pressed', 'true');
    
    const selectedFilter = e.target.getAttribute('data-filter');
    
    // Terapkan animasi transisi saat memfilter
    animateFilterTransition(selectedFilter, allCards, container, wrapper, uniqueMKs);
    });
});

// Render awal (Tampilkan semua project & dividernya) tanpa animasi filter
renderProjects('all', allCards, container, uniqueMKs);
}

/**
 * Menangani animasi Fade Out -> Render ulang -> Fade In untuk filtering
 */
function animateFilterTransition(filter, allCards, container, wrapper, uniqueMKs) {
// 1. Fade Out Container Keseluruhan
wrapper.style.opacity = '0';

// 2. Tunggu sebentar sampai transisi CSS (0.4s) hampir selesai, lalu render DOM baru
setTimeout(() => {
    renderProjects(filter, allCards, container, uniqueMKs);
    
    // 3. Pancing render, lalu Fade In Container Keseluruhan kembali
    void wrapper.offsetWidth; 
    wrapper.style.opacity = '1';
}, 300); // 300ms delay agar terasa natural
}

/**
 * Menggambar ulang card project ke layar beserta pemisahnya berdasarkan filter
 */
function renderProjects(filter, allCards, container, uniqueMKs) {
container.innerHTML = ''; // Kosongkan DOM

const mksToRender = filter === 'all' ? uniqueMKs : [filter];

mksToRender.forEach(mk => {
    const cardsForMK = allCards.filter(card => card.getAttribute('data-mk') === mk);
    
    if (cardsForMK.length > 0) {
    // Pembuatan Divider per MK
    const divider = document.createElement('div');
    divider.className = 'mk-divider reveal-item active'; // Langsung aktif karena sudah dibungkus Wrapper Fade
    divider.innerHTML = `<span>${mk}</span><div class="line"></div>`;
    container.appendChild(divider);
    
    // Sisipkan Card
    cardsForMK.forEach((card, index) => {
        card.classList.remove('active'); 
        container.appendChild(card);
        
        void card.offsetWidth; // Reflow
        
        // Efek gelombang (staggered delay) yang sangat halus
        setTimeout(() => {
        card.classList.add('active');
        }, 80 * index);
    });
    }
});
}

/**
 * Fungsi untuk mengatur animasi saat elemen masuk ke dalam layar (Viewport)
 */
function initScrollReveal() {
const revealElements = document.querySelectorAll('.reveal-item');

const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.15 
};

const scrollObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
    if (entry.isIntersecting) {
        entry.target.classList.add('active');
        observer.unobserve(entry.target);
    }
    });
}, observerOptions);

revealElements.forEach(element => {
    scrollObserver.observe(element);
});
}

/**
 * Logika untuk memunculkan dan fungsi klik dari tombol Back to Top
 */
function initBackToTop() {
const backToTopBtn = document.getElementById('backToTopBtn');

if (!backToTopBtn) return;

// Deteksi scroll untuk memunculkan tombol
window.addEventListener('scroll', () => {
    if (window.scrollY > 400) {
    backToTopBtn.classList.add('show');
    } else {
    backToTopBtn.classList.remove('show');
    }
});

// Scroll ke atas saat tombol diklik
backToTopBtn.addEventListener('click', () => {
    window.scrollTo({
    top: 0,
    behavior: 'smooth'
    });
});
}
