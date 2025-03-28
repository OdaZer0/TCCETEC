let slideIndex = 0;

function mudarSlide(direcao) {
    const carrossel = document.querySelector(".carousel");
    const totalSlides = document.querySelectorAll(".carousel img").length;
    
    slideIndex += direcao;
    
    if (slideIndex >= totalSlides) {
        slideIndex = 0;
    } else if (slideIndex < 0) {
        slideIndex = totalSlides - 1;
    }
    
    carrossel.style.transform = `translateX(${-slideIndex * 100}%)`;
}


setInterval(() => mudarSlide(1), 3000);
