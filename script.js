// ==========================================
// CONFIGURATION
// ==========================================

const ANIMATION_CONFIG = {
    threshold: [0, 0.1, 0.2, 0.3, 0.4, 0.5], // Multiple thresholds pour plus de fluidité
    rootMargin: '0px'
};

// ==========================================
// UTILITY FUNCTIONS
// ==========================================

function clamp(value, min, max) {
    return Math.min(Math.max(value, min), max);
}

function getVisibilityRatio(entry) {
    return entry.intersectionRatio;
}

// ==========================================
// NAV HIDE ON SCROLL
// ==========================================

function initNavHide() {
    const navLinks = document.querySelector(".main-nav ul:not(.nav-links)");
    if (!navLinks) return;

    let ticking = false;

    window.addEventListener("scroll", () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                navLinks.classList.toggle("hide", window.pageYOffset > 0);
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });
}

// ==========================================
// NAV COLOR CHANGE ON FOOTER
// ==========================================

function initNavFooterColor() {
    const nav = document.querySelector(".main-nav");
    const footer = document.querySelector("#footer");
    const body = document.body;

    if (!nav || !footer) return;

    let ticking = false;

    window.addEventListener("scroll", () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                const footerTop = footer.offsetTop;
                const scrollPos = window.scrollY + window.innerHeight / 2;
                const inFooter = scrollPos >= footerTop;

                nav.classList.toggle("white", inFooter);
                body?.classList.toggle("hide-deco", inFooter);
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });
}

// ==========================================
// HERO PARALLAX (Ultra Smooth)
// ==========================================

function initHeroParallax() {
    const middle = document.querySelector(".middle");
    const end = document.querySelector(".end");
    const home = document.querySelector("#home");

    if (!home) return;

    let currentProgress = 0;
    let targetProgress = 0;
    let rafId = null;

    function updateParallax() {
        // Lerp pour fluidité
        currentProgress += (targetProgress - currentProgress) * 0.08;

        if (middle) {
            middle.style.transform = `translate3d(${-200 * currentProgress}px, 0, 0)`;
            middle.style.opacity = 1 - currentProgress;
        }

        if (end) {
            end.style.transform = `
                translate3d(${400 * currentProgress}px, 0, 0) 
                rotate(${3 * currentProgress}deg) 
                scale(${1 - 0.05 * currentProgress})
            `;
            end.style.filter = `blur(${12 * currentProgress}px)`;
            end.style.opacity = 1 - 0.8 * currentProgress;
        }

        // Continue animation si pas encore stabilisé
        if (Math.abs(targetProgress - currentProgress) > 0.001) {
            rafId = requestAnimationFrame(updateParallax);
        } else {
            rafId = null;
        }
    }

    window.addEventListener("scroll", () => {
        const rect = home.getBoundingClientRect();
        targetProgress = clamp(-rect.top / rect.height, 0, 1);

        if (!rafId) {
            rafId = requestAnimationFrame(updateParallax);
        }
    }, { passive: true });
}

// ==========================================
// SCROLL ANIMATIONS (Rejouables + Fluides)
// ==========================================

function initScrollAnimations() {
    const animations = [
        { 
            selector: '.about', 
            from: { x: -180, rotate: -2, scale: 0.97, blur: 6 },
            direction: 'left'
        },
        { 
            selector: '.tool-card', 
            from: { x: 180, rotate: 2, scale: 0.92, blur: 6 },
            stagger: 0.05
        },
        { 
            selector: '#footer', 
            from: { y: 120, scale: 0.985, blur: 12 }
        },
        { 
            selector: '.contact-title', 
            from: { y: 60, blur: 10 }
        },
        { 
            selector: '.contact-description', 
            from: { y: 40, blur: 10 }
        },
        { 
            selector: '.form-group', 
            from: { x: 180, blur: 10 },
            alternateX: true,
            stagger: 0.08
        },
        { 
            selector: '.btn-17', 
            from: { y: 80, scale: 0.9, blur: 10 }
        }
    ];

    animations.forEach(config => {
        const elements = document.querySelectorAll(config.selector);
        if (!elements.length) return;

        // Préparer chaque élément
        elements.forEach((el, index) => {
            el.style.willChange = 'transform, opacity, filter';
            
            // Délai pour stagger
            const delay = config.stagger ? index * config.stagger : 0;
            
            // Direction alternée pour form-group
            let xValue = config.from.x || 0;
            if (config.alternateX && index % 2 === 0) {
                xValue = -xValue;
            }

            // Stocker les valeurs initiales
            el._animConfig = {
                x: xValue,
                y: config.from.y || 0,
                rotate: config.from.rotate || 0,
                scale: config.from.scale || 1,
                blur: config.from.blur || 0,
                delay: delay
            };

            // État initial (caché)
            applyAnimationState(el, 0);
        });

        // Observer avec ratio progressif
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const ratio = entry.intersectionRatio;
                const el = entry.target;
                
                // Animation progressive basée sur la visibilité
                applyAnimationState(el, ratio);
            });
        }, {
            threshold: [0, 0.05, 0.1, 0.15, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1],
            rootMargin: '0px 0px -5% 0px'
        });

        elements.forEach(el => observer.observe(el));
    });
}

function applyAnimationState(el, ratio) {
    const config = el._animConfig;
    if (!config) return;

    // Easing pour ratio (ease-out)
    const eased = 1 - Math.pow(1 - ratio, 3);

    const x = config.x * (1 - eased);
    const y = config.y * (1 - eased);
    const rotate = config.rotate * (1 - eased);
    const scale = config.scale + (1 - config.scale) * eased;
    const blur = config.blur * (1 - eased);
    const opacity = eased;

    el.style.transform = `translate3d(${x}px, ${y}px, 0) rotate(${rotate}deg) scale(${scale})`;
    el.style.filter = blur > 0.1 ? `blur(${blur}px)` : 'none';
    el.style.opacity = opacity;
}

const recentWorkScrollObservers = [];

const RECENT_WORK_SCROLL_CONFIGS = [
    { selector: '.recent-work', from: { y: 200, scale: 0.98, blur: 4 } },
    { selector: '.work-card', from: { y: 60, scale: 0.96, blur: 10 }, stagger: 0.06 },
    { selector: '.recent-work-actions .view-more', from: { y: 24, blur: 10 } }
];

function clearScrollAnimInline(el) {
    el.style.removeProperty('transform');
    el.style.removeProperty('filter');
    el.style.removeProperty('opacity');
    el.style.removeProperty('will-change');
    delete el._animConfig;
}

function teardownRecentWorkScrollAnimations() {
    recentWorkScrollObservers.forEach((observer) => observer.disconnect());
    recentWorkScrollObservers.length = 0;
    document.querySelectorAll('.recent-work, .work-card, .recent-work-actions .view-more').forEach(clearScrollAnimInline);
}

function enableDesktopRecentWorkScrollAnimations() {
    RECENT_WORK_SCROLL_CONFIGS.forEach((config) => {
        const elements = document.querySelectorAll(config.selector);
        if (!elements.length) return;

        elements.forEach((el, index) => {
            el.style.willChange = 'transform, opacity, filter';

            let xValue = config.from.x || 0;
            el._animConfig = {
                x: xValue,
                y: config.from.y || 0,
                rotate: config.from.rotate || 0,
                scale: config.from.scale || 1,
                blur: config.from.blur || 0,
                delay: config.stagger ? index * config.stagger : 0
            };

            applyAnimationState(el, 0);
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                applyAnimationState(entry.target, entry.intersectionRatio);
            });
        }, {
            threshold: [0, 0.05, 0.1, 0.15, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1],
            rootMargin: '0px 0px -5% 0px'
        });

        elements.forEach((el) => observer.observe(el));
        recentWorkScrollObservers.push(observer);
    });
}

function enableMobileRecentWorkScrollAnimations() {
    const section = document.getElementById('work');
    document.querySelectorAll('.recent-work, .work-card, .recent-work-actions .view-more').forEach((el) => {
        clearScrollAnimInline(el);
        el.style.opacity = '1';
        el.style.willChange = 'auto';
    });

    section?.querySelectorAll('.work-gallery .work-card img').forEach((img) => {
        if (!img.dataset.coverSrc) {
            img.dataset.coverSrc = img.getAttribute('src') || '';
        }
        const fullSrc = img.dataset.coverSrc.replace('mini_', '');
        if (img.src !== fullSrc) {
            img.src = fullSrc;
        }
        img.loading = 'eager';
    });
}

function restoreDesktopRecentWorkImages() {
    document.querySelectorAll('.work-gallery .work-card img').forEach((img) => {
        if (img.dataset.coverSrc) {
            img.src = img.dataset.coverSrc;
        }
        img.loading = 'lazy';
    });
}

function syncRecentWorkScrollAnimations() {
    teardownRecentWorkScrollAnimations();
    if (window.matchMedia('(max-width: 768px)').matches) {
        enableMobileRecentWorkScrollAnimations();
    } else {
        restoreDesktopRecentWorkImages();
        enableDesktopRecentWorkScrollAnimations();
    }
}

function initToolsTitleScrollAnimation() {
    const section = document.querySelector('.tools-section');
    const el = document.querySelector('.tools-title');
    if (!section || !el) return;

    const from = { x: 180, rotate: 2, scale: 0.92, blur: 6 };

    el.style.willChange = 'transform, opacity, filter';
    el._animConfig = {
        x: from.x,
        y: 0,
        rotate: from.rotate,
        scale: from.scale,
        blur: from.blur,
        delay: 0
    };

    let ticking = false;

    function update() {
        const vh = window.innerHeight;
        const top = section.getBoundingClientRect().top;
        const start = vh * 0.45;
        const end = vh * 0.25;
        const progress = clamp((start - top) / (start - end), 0, 1);

        applyAnimationState(el, progress);
        ticking = false;
    }

    function onScroll() {
        if (!ticking) {
            ticking = true;
            requestAnimationFrame(update);
        }
    }

    applyAnimationState(el, 0);
    update();
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', update);
    window.addEventListener('load', update);
    requestAnimationFrame(() => requestAnimationFrame(update));
}

// ==========================================
// LOAD ANIMATIONS
// ==========================================

function initLoadAnimations() {
    const mainNav = document.querySelector(".main-nav");
    const middle = document.querySelector(".middle");
    const end = document.querySelector(".end");

    const elements = [
        { el: mainNav, delay: 0, y: -80 },
        { el: middle, delay: 200, y: 80, blur: 10 },
        { el: end, delay: 400, y: 100, blur: 10 }
    ];

    elements.forEach(({ el, delay, y, blur }) => {
        if (!el) return;

        el.style.opacity = '0';
        el.style.transform = `translate3d(0, ${y}px, 0)`;
        el.style.filter = blur ? `blur(${blur}px)` : 'none';
        el.style.willChange = 'transform, opacity, filter';

        setTimeout(() => {
            el.style.transition = 'transform 1.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 1s ease-out, filter 1s ease-out';
            el.style.opacity = '1';
            el.style.transform = 'translate3d(0, 0, 0)';
            el.style.filter = 'none';

            // Cleanup willChange après animation
            setTimeout(() => {
                el.style.willChange = 'auto';
            }, 1500);
        }, delay);
    });
}

// ==========================================
// FOOTER LOGO
// ==========================================

function initFooterLogo() {
    const footerLogo = document.querySelector(".footer-logo");
    if (!footerLogo) return;

    let animated = false;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !animated) {
                footerLogo.style.transition = 'width 1.8s steps(5)';
                footerLogo.style.width = '';
                animated = true;
            } else if (!entry.isIntersecting && animated) {
                footerLogo.style.transition = 'none';
                footerLogo.style.width = '0';
                animated = false;
            }
        });
    }, { threshold: 0.1 });

    footerLogo.style.width = '0';
    observer.observe(footerLogo);
}

// ==========================================
// SUCCESS MESSAGE
// ==========================================

function initSuccessMessage() {
    const msg = document.querySelector(".message-success");
    if (!msg || getComputedStyle(msg).display === 'none') return;

    setTimeout(() => {
        msg.style.transition = 'all 1s cubic-bezier(0.16, 1, 0.3, 1)';
        msg.style.opacity = '0';
        msg.style.transform = 'translate3d(0, -15px, 0) scale(0.96)';
        msg.style.filter = 'blur(12px)';

        msg.addEventListener('transitionend', () => {
            msg.style.display = 'none';
        }, { once: true });
    }, 3000);
}

// ==========================================
// MOBILE WORK REVEAL
// ==========================================

function initRecentWorkMobileReveal() {
    const section = document.getElementById("work");
    const viewMore = document.querySelector(".recent-work-actions .view-more");
    if (!section || !viewMore) return;

    const mq = window.matchMedia("(max-width: 768px)");

    viewMore.addEventListener("click", (e) => {
        if (!mq.matches) return;
        if (section.querySelectorAll(".work-gallery .work-card").length <= 2) return;

        if (section.getAttribute("data-expanded") !== "true") {
            e.preventDefault();
            section.setAttribute("data-expanded", "true");
        }
    });

    mq.addEventListener("change", () => {
        if (!mq.matches) section.removeAttribute("data-expanded");
        syncRecentWorkScrollAnimations();
    });
}

// ==========================================
// SMOOTH SCROLL
// ==========================================

function initSmoothScroll() {
    document.documentElement.style.scrollBehavior = 'smooth';
}

// ==========================================
// INIT
// ==========================================

document.addEventListener("DOMContentLoaded", () => {
    initSmoothScroll();
    initNavHide();
    initNavFooterColor();
    initScrollAnimations();
    syncRecentWorkScrollAnimations();
    initToolsTitleScrollAnimation();
    initFooterLogo();
    initSuccessMessage();
    initRecentWorkMobileReveal();
});

window.addEventListener("load", () => {
    initLoadAnimations();
    initHeroParallax();
});
