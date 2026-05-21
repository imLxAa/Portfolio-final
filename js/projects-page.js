(function () {
    if (!document.body.classList.contains("page-projects")) return;
    if (typeof gsap === "undefined") return;

    gsap.set([".project-card", ".projects-empty", ".filter-btn", ".projects-filters"], {
        clearProps: "all",
    });

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
        )
        .from(
            ".filter-btn",
            {
                y: 12,
                duration: 0.4,
                stagger: 0.05,
            },
            "-=0.15"
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
            "-=0.1"
        );
    } else if (document.querySelector(".projects-empty")) {
        tl.from(".projects-empty", { opacity: 0, y: 16, duration: 0.5 }, "-=0.1");
    }

    tl.from(
        ".projects-back",
        {
            opacity: 0,
            x: -12,
            duration: 0.5,
        },
        "-=0.2"
    );
})();
