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
        scrub: 1
    }

});

gsap.to("space", {

    y: -100,
    rotate: 10,

    scrollTrigger: {
        trigger: "#home",
        start: "top top",
        end: "bottom top",
        scrub: 1
    }
});

const lenis = new Lenis();

function raf(time) {
    lenis.raf(time);
    requestAnimationFrame(raf);
}
requestAnimationFrame

gsap.from(".about", {
    x: -180,
    opacity: 0,
    scale: 0.97,
    rotate: -2,
    filter: "blur(6px)",
    duration: 1.8,
    ease: "expo.out",
    scrollTrigger: {
    trigger: ".about",
    start: "top 30%",
    end: "top 5%",
    scrub: 1
    }
});
requestAnimationFrame(raf);

const nav = document.querySelector(".main-nav");
const footer = document.querySelector("#footer");

window.addEventListener("scroll", () => {

    const footerTop = footer.offsetTop;
    const scrollPos = window.scrollY + window.innerHeight / 2;

    if(scrollPos >= footerTop){
        nav.classList.add("white");
    } else {
        nav.classList.remove("white");
    }

});

const body = document.body;

window.addEventListener("scroll", () => {

    const footerTop = footer.offsetTop;
    const scrollPos = window.scrollY + window.innerHeight / 2;

    if(scrollPos >= footerTop){

        nav.classList.add("white");
        body.classList.add("hide-deco");

    } else {

        nav.classList.remove("white");
        body.classList.remove("hide-deco");

    }

});

window.addEventListener("load", () => {

    const tl = gsap.timeline();

    /* NAVBAR */

    tl.from(".main-nav", {
        y: -80,
        opacity: 0,
        duration: 1,
        ease: "power3.out"
    });

    /* DECORATIONS */

    tl.from(".cross, .bottom-cross", {
        opacity: 0,
        rotate: 90,
        scale: 0.7,
        duration: 1.2,
        ease: "power4.out"
    }, "-=0.7")

    .from("#circles", {
        opacity: 0,
        y: 30,
        duration: 1,
        ease: "power3.out"
    }, "-=1");

    /* IMAGE */

    tl.from(".middle", {
        y: 80,
        opacity: 0,
        filter: "blur(10px)",
        duration: 1.4,
        ease: "power4.out"
    }, "-=0.8");

    /* TITRE */

    tl.from(".end", {
        y: 100,
        opacity: 0,
        filter: "blur(10px)",
        duration: 1.2,
        ease: "power4.out"
    }, "-=1");

    /* SOCIALS */

    tl.from(".socials", {
        y: 30,
        opacity: 0,
        duration: 1,
        ease: "power2.out"
    }, "-=0.8");

});
window.addEventListener("load", () => {

    document.body.style.overflow = "auto";

});

gsap.from(".tool-card", {
    x: 180,
    opacity: 0,
    scale: 0.92,
    rotate: 2,
    filter: "blur(6px)",
    duration: 1.3,
    ease: "expo.out",
    scrollTrigger: {
    trigger: ".tools-section",
    start: "top 45%",
    end: "top 25%",
    scrub: 1
    }
});
gsap.from(".tools-title", {
    x: 180,
    opacity: 0,
    scale: 0.92,
    rotate: 2,
    filter: "blur(6px)",
    duration: 1.3,
    ease: "expo.out",
    scrollTrigger: {
    trigger: ".tools-section",
    start: "top 45%",
    end:" top 25%",
    scrub: 1
    }
});