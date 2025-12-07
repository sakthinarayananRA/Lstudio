(function ($) {
  "use strict";

  // Spinner
  var spinner = function () {
    setTimeout(function () {
      if ($("#spinner").length > 0) {
        $("#spinner").removeClass("show");
      }
    }, 1);
  };
  spinner();

  // Initiate the wowjs
  new WOW().init();

  // Navbar on scrolling
  $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
      $(".navbar").fadeIn("slow").css("display", "flex");
    }
  });

  // Modal Video
  var $videoSrc;
  $(".btn-play").click(function () {
    $videoSrc = $(this).data("src");
  });
  console.log($videoSrc);
  $("#videoModal").on("shown.bs.modal", function (e) {
    $("#video").attr(
      "src",
      $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0"
    );
  });
  $("#videoModal").on("hide.bs.modal", function (e) {
    $("#video").attr("src", $videoSrc);
  });

  // Back to top button
  $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
      $(".back-to-top").fadeIn("slow");
    } else {
      $(".back-to-top").fadeOut("slow");
    }
  });
  $(".back-to-top").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
    return false;
  });

  // Facts counter
  $('[data-toggle="counter-up"]').counterUp({
    delay: 10,
    time: 2000,
  });

  // Testimonials carousel
  $(".testimonial-carousel").owlCarousel({
    autoplay: true,
    smartSpeed: 1000,
    margin: 25,
    loop: true,
    center: true,
    dots: false,
    nav: true,
    navText: [
      '<i class="bi bi-chevron-left"></i>',
      '<i class="bi bi-chevron-right"></i>',
    ],
    responsive: {
      0: {
        items: 1,
      },
      768: {
        items: 2,
      },
      992: {
        items: 3,
      },
    },
  });

  // Navbar: add solid background on scroll
  $(window).on("scroll", function () {
    if ($(this).scrollTop() > 50) {
      $(".custom-navbar").addClass("navbar-scrolled");
    } else {
      $(".custom-navbar").removeClass("navbar-scrolled");
    }
  });

  // Trigger once on load
  $(window).trigger("scroll");

  document.addEventListener("DOMContentLoaded", () => {
    // Spinner: hide reliably
    const spinner = document.getElementById("spinner");
    if (spinner) {
      spinner.classList.remove("show");
      spinner.style.display = "none";
    }

    // Navbar shadow toggle on scroll
    const navbar = document.querySelector(".custom-navbar");
    if (navbar) {
      const onScroll = () =>
        navbar.classList.toggle("scrolled", window.scrollY > 50);
      window.addEventListener("scroll", onScroll, { passive: true });
      onScroll();
    }

    // Add aria-labels to carousel indicators and set button type
    const setCarouselAria = (id, prefix) => {
      const carousel = document.getElementById(id);
      if (!carousel) return;
      const indicators = carousel.querySelectorAll(
        ".carousel-indicators button"
      );
      indicators.forEach((btn, i) => {
        btn.setAttribute("type", "button");
        if (!btn.hasAttribute("aria-label"))
          btn.setAttribute("aria-label", `${prefix} slide ${i + 1}`);
      });
    };
    setCarouselAria("heroSlider", "Hero");
    setCarouselAria("gallerySlider", "Gallery");

    // Ensure images are lazy-loaded and have alt text
    document.querySelectorAll("img").forEach((img) => {
      if (!img.hasAttribute("loading")) img.setAttribute("loading", "lazy");
      if (!img.getAttribute("alt") || img.getAttribute("alt").trim() === "") {
        img.setAttribute("alt", "4L Studio photo");
      }
    });

    // Scoped frame toggle
    const btnLandscape = document.getElementById("btnLandscape");
    const btnPortrait = document.getElementById("btnPortrait");
    const frameGrid = document.getElementById("frameGrid");
    if (frameGrid && btnLandscape && btnPortrait) {
      const frames = frameGrid.querySelectorAll(".frame-card");

      const setLandscape = () => {
        frames.forEach((f) => {
          f.classList.remove("portrait");
          f.classList.add("landscape");
        });
        btnLandscape.classList.add("active");
        btnPortrait.classList.remove("active");
      };
      const setPortrait = () => {
        frames.forEach((f) => {
          f.classList.remove("landscape");
          f.classList.add("portrait");
        });
        btnPortrait.classList.add("active");
        btnLandscape.classList.remove("active");
      };

      btnLandscape.addEventListener("click", setLandscape);
      btnPortrait.addEventListener("click", setPortrait);
      [btnLandscape, btnPortrait].forEach((b) =>
        b.addEventListener("keyup", (e) => {
          if (e.key === "Enter" || e.key === " ") b.click();
        })
      );
    }

    // Back to top button visibility & smooth scroll
    const backToTop = document.querySelector(".back-to-top");
    if (backToTop) {
      const toggleBTT = () =>
        backToTop.classList.toggle("show", window.scrollY > 400);
      window.addEventListener("scroll", toggleBTT, { passive: true });
      backToTop.addEventListener("click", (e) => {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: "smooth" });
      });
      toggleBTT();
    }

    // Initialize WOW.js safely
    if (window.WOW) {
      try {
        new WOW().init();
      } catch (e) {
        /* ignore */
      }
    }

    // Initialize Owl Carousel (if loaded)
    if (window.jQuery && jQuery.fn && jQuery.fn.owlCarousel) {
      try {
        jQuery(".testimonial-carousel").owlCarousel({
          loop: true,
          margin: 20,
          autoplay: true,
          autoplayTimeout: 4000,
          responsive: { 0: { items: 1 }, 768: { items: 2 }, 992: { items: 3 } },
        });
      } catch (e) {
        /* ignore */
      }
    }
  });

  (function () {
    // ensure gallery uses full viewport height (handles mobile address bar)
    const setGalleryHeight = () => {
      const gallery = document.getElementById("gallerySlider");
      if (!gallery) return;
      // Use innerHeight to include browser chrome — helps mobile UX
      const h = Math.max(window.innerHeight || 0, 480);
      gallery.style.height = h + "px";
      const inner = gallery.querySelector(".carousel-inner");
      if (inner) inner.style.height = h + "px";
      // ensure each slide occupies full height
      gallery
        .querySelectorAll(".carousel-item")
        .forEach((item) => (item.style.height = h + "px"));
    };

    // Debounced resize
    let resizeTimeout = null;
    const onResize = () => {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(setGalleryHeight, 120);
    };

    document.addEventListener("DOMContentLoaded", () => {
      setGalleryHeight();
      window.addEventListener("resize", onResize, { passive: true });

      // Ensure gallery images are lazy-loaded and have alt text
      const gallery = document.getElementById("gallerySlider");
      if (gallery) {
        gallery.querySelectorAll("img").forEach((img) => {
          if (!img.hasAttribute("loading")) img.setAttribute("loading", "lazy");
          if (
            !img.getAttribute("alt") ||
            img.getAttribute("alt").trim() === ""
          ) {
            img.setAttribute("alt", "4L Studio gallery photo");
          }
          // ensure correct sizing attributes for responsive images
          img.style.width = "100%";
          img.style.height = "100%";
          img.style.objectFit = "cover";
        });
      }
    });
  })();
})(jQuery);
