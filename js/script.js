(function () {
  "use strict";

  /* ================= Réglages à modifier facilement ================= */
  var WHATSAPP_NUMBER = "22890386784"; // format international, sans le +
  var WHATSAPP_MESSAGE = "Bonjour K-ARCHITECTES, je souhaite discuter d'un projet.";
  /* ==================================================================== */

  document.getElementById("year").textContent = new Date().getFullYear();

  var whatsappLink = document.getElementById("whatsappLink");
  if (whatsappLink) {
    whatsappLink.href =
      "https://wa.me/" + WHATSAPP_NUMBER + "?text=" + encodeURIComponent(WHATSAPP_MESSAGE);
  }

  /* ---------------- Menu mobile ---------------- */
  var burgerBtn = document.getElementById("burgerBtn");
  var mobileNav = document.getElementById("mobileNav");

  if (burgerBtn && mobileNav) {
    burgerBtn.addEventListener("click", function () {
      var isOpen = burgerBtn.getAttribute("aria-expanded") === "true";
      burgerBtn.setAttribute("aria-expanded", String(!isOpen));
      burgerBtn.setAttribute("aria-label", isOpen ? "Ouvrir le menu" : "Fermer le menu");
      mobileNav.hidden = isOpen;
    });

    mobileNav.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        burgerBtn.setAttribute("aria-expanded", "false");
        burgerBtn.setAttribute("aria-label", "Ouvrir le menu");
        mobileNav.hidden = true;
      });
    });
  }

  /* ---------------- Carrousel témoignages ---------------- */
  var track = document.getElementById("testimonialTrack");
  var prevBtn = document.getElementById("prevTestimonial");
  var nextBtn = document.getElementById("nextTestimonial");

  if (track && prevBtn && nextBtn) {
    var cards = Array.prototype.slice.call(track.children);
    var index = 0;
    var autoplayId = null;
    var AUTOPLAY_DELAY = 4000;

    function cardsPerView() {
      var w = window.innerWidth;
      if (w >= 1024) return 3;
      if (w >= 700) return 2;
      return 1;
    }

    function maxIndex() {
      return Math.max(0, cards.length - cardsPerView());
    }

    function update() {
      var perView = cardsPerView();
      var cardWidth = cards[0].getBoundingClientRect().width;
      var gap = parseFloat(getComputedStyle(track).gap) || 0;
      var offset = index * (cardWidth + gap);
      track.style.transform = "translateX(-" + offset + "px)";
    }

    function goTo(newIndex) {
      var mi = maxIndex();
      if (newIndex > mi) newIndex = 0;
      if (newIndex < 0) newIndex = mi;
      index = newIndex;
      update();
    }

    function next() { goTo(index + 1); }
    function prev() { goTo(index - 1); }

    function startAutoplay() {
      stopAutoplay();
      autoplayId = window.setInterval(next, AUTOPLAY_DELAY);
    }
    function stopAutoplay() {
      if (autoplayId) window.clearInterval(autoplayId);
    }

    nextBtn.addEventListener("click", function () { next(); startAutoplay(); });
    prevBtn.addEventListener("click", function () { prev(); startAutoplay(); });

    window.addEventListener("resize", update);

    var carouselSection = document.getElementById("testimonialCarousel");
    carouselSection.addEventListener("mouseenter", stopAutoplay);
    carouselSection.addEventListener("mouseleave", startAutoplay);

    update();
    startAutoplay();
  }

  /* ---------------- Révélation au défilement ---------------- */
  var revealEls = document.querySelectorAll(".reveal");
  if (revealEls.length && "IntersectionObserver" in window) {
    var revealObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            revealObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15, rootMargin: "0px 0px -60px 0px" }
    );
    revealEls.forEach(function (el) { revealObserver.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add("is-visible"); });
  }

  /* ---------------- Compteur animé (statistiques "Notre parcours") ---------------- */
  var countEls = document.querySelectorAll(".count-up");
  if (countEls.length) {
    function animateCount(el) {
      var target = parseInt(el.getAttribute("data-target"), 10) || 0;
      var duration = 1200;
      var startTime = null;

      function step(timestamp) {
        if (!startTime) startTime = timestamp;
        var progress = Math.min((timestamp - startTime) / duration, 1);
        var eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.floor(eased * target);
        if (progress < 1) {
          window.requestAnimationFrame(step);
        } else {
          el.textContent = target;
        }
      }
      window.requestAnimationFrame(step);
    }

    if ("IntersectionObserver" in window) {
      var countObserver = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              animateCount(entry.target);
              countObserver.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.6 }
      );
      countEls.forEach(function (el) { countObserver.observe(el); });
    } else {
      countEls.forEach(function (el) { el.textContent = el.getAttribute("data-target"); });
    }
  }

  /* ---------------- Formulaire de contact ---------------- */
  var CONTACT_EMAIL = "archikortete@gmail.com";
  var form = document.getElementById("contactForm");
  var formNote = document.getElementById("formNote");

  if (form && formNote) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();

      var nom = form.nom.value.trim();
      var email = form.email.value.trim();
      var telephone = form.telephone.value.trim();
      var message = form.message.value.trim();

      var subject = "Nouveau message depuis le site — " + nom;
      var body =
        "Nom : " + nom + "\n" +
        "Email : " + email + "\n" +
        (telephone ? "Téléphone : " + telephone + "\n" : "") +
        "\nMessage :\n" + message;

      var mailtoUrl =
        "mailto:" + CONTACT_EMAIL +
        "?subject=" + encodeURIComponent(subject) +
        "&body=" + encodeURIComponent(body);

      window.location.href = mailtoUrl;

      formNote.textContent = "Votre client mail va s'ouvrir pour envoyer le message à " + CONTACT_EMAIL + ".";
      formNote.classList.add("is-success");
    });
  }
})();