let index = 0;
const slides = document.querySelector('.slides');
const total = document.querySelectorAll('.slide').length;


const nextBtn = document.querySelector('.next');
const prevBtn = document.querySelector('.prev');


const nav = document.querySelectorAll('.navigation span');


function showSlide(i) {
    index = i;
    slides.style.marginLeft = `-${index * 100}%`;
}


nextBtn.addEventListener("click", () => {
    index = (index + 1) % total;
    showSlide(index);
});

prevBtn.addEventListener("click", () => {
    index = (index - 1 + total) % total;
    showSlide(index);
});

nav.forEach((dot, i) => {
    dot.addEventListener("click", () => {
        showSlide(i);
    });
});

