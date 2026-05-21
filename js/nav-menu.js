(function () {
    const burger = document.getElementById("burger");
    const panel = document.getElementById("panel");
    const overlay = document.getElementById("overlay");
    if (!burger || !panel || !overlay) return;

    function openMenu() {
        burger.classList.add("open");
        panel.classList.add("open");
        overlay.classList.add("open");
        burger.setAttribute("aria-expanded", "true");
        panel.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";
    }

    function closeMenu() {
        burger.classList.remove("open");
        panel.classList.remove("open");
        overlay.classList.remove("open");
        burger.setAttribute("aria-expanded", "false");
        panel.setAttribute("aria-hidden", "true");
        document.body.style.overflow = "";
    }

    burger.addEventListener("click", () => {
        if (burger.classList.contains("open")) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    overlay.addEventListener("click", closeMenu);

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            closeMenu();
        }
    });

    panel.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", closeMenu);
    });
})();
