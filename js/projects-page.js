(function () {
    if (!document.body.classList.contains("page-projects")) return;
    if (typeof gsap === "undefined") return;

    const filterLinks = document.querySelectorAll(".category-filters a");
    const scrollEl = document.getElementById("filtersScroll");
    const filtersNav = document.querySelector(".category-filters");
    const prevBtn = document.querySelector(".filters-scroll-btn--prev");
    const nextBtn = document.querySelector(".filters-scroll-btn--next");

    function updateScrollButtons() {
        if (!filtersNav || !prevBtn || !nextBtn) return;

        const maxScroll = filtersNav.scrollWidth - filtersNav.clientWidth;
        const hasOverflow = maxScroll > 4;

        prevBtn.hidden = !hasOverflow;
        nextBtn.hidden = !hasOverflow;

        if (!hasOverflow) return;

        prevBtn.disabled = filtersNav.scrollLeft <= 0;
        nextBtn.disabled = filtersNav.scrollLeft >= maxScroll - 1;
    }

    function scrollFiltersBy(direction) {
        if (!filtersNav) return;
        filtersNav.scrollBy({
            left: direction * 220,
            behavior: "smooth",
        });
    }

    function scrollActiveFilterIntoView() {
        const active = document.querySelector(".filter-btn.active");
        if (!active || !filtersNav) return;

        const navRect = filtersNav.getBoundingClientRect();
        const activeRect = active.getBoundingClientRect();

        if (activeRect.left < navRect.left || activeRect.right > navRect.right) {
            active.scrollIntoView({
                behavior: "smooth",
                inline: "center",
                block: "nearest",
            });
        }
    }

    if (prevBtn && nextBtn && filtersNav) {
        prevBtn.addEventListener("click", () => scrollFiltersBy(-1));
        nextBtn.addEventListener("click", () => scrollFiltersBy(1));
        filtersNav.addEventListener("scroll", updateScrollButtons, { passive: true });
        window.addEventListener("resize", updateScrollButtons);
        updateScrollButtons();
        scrollActiveFilterIntoView();
    }

    function animateIn() {
        gsap.set([".project-card", ".projects-empty"], { clearProps: "all" });

        const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

        tl.from(".main-nav", {
            y: -24,
            opacity: 0,
            duration: 0.7,
        })
            .from(
                ".projects-head .section-title",
                {
                    y: 36,
                    opacity: 0,
                    filter: "blur(10px)",
                    duration: 0.85,
                },
                "-=0.35"
            )
            .from(
                ".projects-intro",
                {
                    y: 12,
                    opacity: 0,
                    duration: 0.4,
                },
                "-=0.35"
            );

        if (document.querySelector(".project-card")) {
            tl.from(
                ".project-card",
                {
                    y: 40,
                    opacity: 0,
                    filter: "blur(8px)",
                    stagger: 0.07,
                    duration: 0.65,
                },
                "-=0.2"
            );
        } else if (document.querySelector(".projects-empty")) {
            tl.from(".projects-empty", { opacity: 0, y: 16, duration: 0.5 }, "-=0.1");
        }

        tl.from(
            ".projects-filters",
            {
                y: 24,
                opacity: 0,
                duration: 0.55,
            },
            "-=0.25"
        ).from(
            ".filter-btn",
            {
                y: 14,
                opacity: 0,
                scale: 0.94,
                stagger: 0.04,
                duration: 0.35,
            },
            "-=0.35"
        );

        tl.from(
            ".projects-back",
            {
                opacity: 0,
                y: 10,
                duration: 0.5,
            },
            "-=0.2"
        );
    }

    function animateOut(callback) {
        gsap.to(".projects-head, .projects-grid, .projects-filters, .projects-back", {
            opacity: 0,
            y: 12,
            duration: 0.28,
            ease: "power2.in",
            onComplete: callback,
        });
    }

    filterLinks.forEach((link) => {
        link.addEventListener("click", (e) => {
            if (link.classList.contains("active")) {
                e.preventDefault();
                return;
            }

            e.preventDefault();
            const href = link.getAttribute("href");
            animateOut(() => {
                window.location.href = href;
            });
        });
    });

    const backLink = document.querySelector(".projects-back");
    if (backLink) {
        backLink.addEventListener("click", (e) => {
            e.preventDefault();
            const href = backLink.getAttribute("href");
            animateOut(() => {
                window.location.href = href;
            });
        });
    }

    animateIn();
})();
