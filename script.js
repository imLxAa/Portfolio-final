const navLinks = document.querySelector(".main-nav ul");

window.addEventListener("scroll", () => {

    if(window.pageYOffset > 0){

        navLinks.classList.add("hide");

    } else {

        navLinks.classList.remove("hide");
    }

});

gsap.registerPlugin(ScrollTrigger);

gsap.to(".middle", {

    x: -200,
    opacity: 0,

    scrollTrigger: {
        trigger: "#home",
        start: "top top",
        end: "bottom top",
        scrub: true
    }
});

gsap.to(".end", {

    y: 150,

    scrollTrigger: {
        trigger: "#home",
        start: "top top",
        end: "bottom top",
        scrub: true
    }
});

gsap.to("space", {

    y: -100,
    rotate: 10,

    scrollTrigger: {
        trigger: "#home",
        start: "top top",
        end: "bottom top",
        scrub: true
    }
});

const lenis = new Lenis();

function raf(time) {
    lenis.raf(time);
    requestAnimationFrame(raf);
}

requestAnimationFrame(raf);
