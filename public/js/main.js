document.addEventListener("DOMContentLoaded", function () {
  const sliderWrapper = document.querySelector(".banner__slider-wrapper");
  if (sliderWrapper) {
    const slides = document.querySelectorAll(".banner__slider-item");
    let currentSlide = 0;
    let slideInterval;

    slides[0].classList.add("active");

    function goToSlide(index) {
      slides[currentSlide].classList.remove("active");
      currentSlide = index;
      if (currentSlide >= slides.length) currentSlide = 0;
      if (currentSlide < 0) currentSlide = slides.length - 1;
      slides[currentSlide].classList.add("active");
    }

    function nextSlide() {
      goToSlide(currentSlide + 1);
    }

    function prevSlide() {
      goToSlide(currentSlide - 1);
    }

    function startSlideShow() {
      if (slideInterval) {
        clearInterval(slideInterval);
      }
      slideInterval = setInterval(nextSlide, 7000);
    }

    function preloadImages() {
      slides.forEach((slide) => {
        const img = slide.getAttribute("src");
        if (img) {
          const image = new Image();
          image.src = img;
        }
      });
    }

    function createNavigationAreas() {
      const prevArea = document.createElement("div");
      const nextArea = document.createElement("div");
      prevArea.classList.add(
        "banner__slider-area",
        "banner__slider-area--prev"
      );
      nextArea.classList.add(
        "banner__slider-area",
        "banner__slider-area--next"
      );
      sliderWrapper.appendChild(prevArea);
      sliderWrapper.appendChild(nextArea);
      prevArea.addEventListener("click", () => {
        prevSlide();
        startSlideShow();
      });
      nextArea.addEventListener("click", () => {
        nextSlide();
        startSlideShow();
      });
    }

    preloadImages();
    createNavigationAreas();
    startSlideShow();
  }

  function showToast() {
    const toast = document.getElementById("toast");
    if (toast) {
      if (toast.style.display === "block") {
        toast.style.display = "none";
        setTimeout(() => {
          toast.style.display = "block";
        }, 100);
      } else {
        toast.style.display = "block";
      }
      if (toast.timeoutId) {
        clearTimeout(toast.timeoutId);
      }
      toast.timeoutId = setTimeout(() => {
        toast.style.display = "none";
        toast.timeoutId = null;
      }, 3000);
    }
  }

  const cartIcons = document.querySelectorAll(".fa-cart-shopping");
  const cartActions = document.querySelectorAll(".cart-action");

  cartActions.forEach((item) => {
    item.addEventListener("click", function (e) {
      e.stopPropagation();
      showToast();
    });
  });

  cartIcons.forEach((icon) => {
    icon.addEventListener("click", function (e) {
      e.stopPropagation();
      showToast();
    });
  });
});

function handleSortChange(input) {
  const sort = input.value;
  const params = new URLSearchParams(window.location.search);

  // Set the sort parameter
  params.set("sort", sort);
  params.set("page", 1); // Reset to page 1 on sort change

  // Redirect to the updated URL
  window.location.href = "?" + params.toString();
}
