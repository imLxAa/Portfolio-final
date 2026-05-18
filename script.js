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

    x: 400,
    rotate: 3,
    scale: 0.95,

    filter: "blur(12px)",

    opacity: 0.2,

    ease: "none",

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
requestAnimationFrame

gsap.from(".about", {

    x: -300,
    opacity: 0,
    filter: "blur(10px)",

    ease: "none",

    scrollTrigger: {
        trigger: ".about",
        start: "top 85%",
        end: "top 30%",

        scrub: 1
    }

});
requestAnimationFrame(raf);