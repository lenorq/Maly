/* =============================================================================
   MACIEJ MAŁECKI — DRAWING ARCHIVE · interaction layer
   No dependencies. Progressive enhancement: everything works without JS,
   JS only adds reveals, the HUD clock, and the lightbox.
============================================================================= */
(function () {
  "use strict";
  var reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* ---- 1 · scroll reveals -------------------------------------------- */
  var revealEls = Array.prototype.slice.call(
    document.querySelectorAll("[data-reveal],[data-reveal-img],[data-stagger]"));

  if (reduce || !("IntersectionObserver" in window)) {
    revealEls.forEach(function (el) { el.classList.add("is-in"); });
  } else {
    // a) reveal anything already on/near screen at load (bulletproof above-the-fold)
    var vh = window.innerHeight;
    revealEls.forEach(function (el) {
      var r = el.getBoundingClientRect();
      if (r.top < vh * 0.92 && r.bottom > 0) el.classList.add("is-in");
    });
    // b) observe the rest as they scroll in
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add("is-in"); io.unobserve(e.target); }
      });
    }, { rootMargin: "0px 0px -10% 0px", threshold: 0.08 });
    revealEls.forEach(function (el) { if (!el.classList.contains("is-in")) io.observe(el); });

    // c) scroll/resize fallback — guarantees reveal even if IO misfires
    var pending = revealEls.filter(function (el) { return !el.classList.contains("is-in"); });
    var ticking = false;
    function sweep() {
      ticking = false;
      var h = window.innerHeight;
      pending = pending.filter(function (el) {
        // reveal anything whose top has crossed the trigger line — including
        // elements already scrolled above the viewport (top < 0)
        if (el.getBoundingClientRect().top < h * 0.9) { el.classList.add("is-in"); io.unobserve(el); return false; }
        return true;
      });
      if (!pending.length) {
        window.removeEventListener("scroll", onScroll);
        window.removeEventListener("resize", onScroll);
      }
    }
    function onScroll() {
      if (!ticking) { ticking = true; window.requestAnimationFrame(sweep); }
    }
    window.addEventListener("scroll", onScroll, { passive: true });
    window.addEventListener("resize", onScroll, { passive: true });
  }

  /* ---- 2 · HUD live clock (UTC telemetry feel) ----------------------- */
  var clock = document.querySelector("[data-clock]");
  if (clock) {
    var tick = function () {
      var d = new Date();
      var p = function (n) { return String(n).padStart(2, "0"); };
      clock.textContent = p(d.getUTCHours()) + ":" + p(d.getUTCMinutes()) + ":" + p(d.getUTCSeconds()) + " UTC";
    };
    tick(); if (!reduce) setInterval(tick, 1000);
  }

  /* ---- 3 · mobile nav ------------------------------------------------ */
  var burger = document.querySelector(".nav__burger");
  var links = document.querySelector(".nav__links");
  if (burger && links) {
    burger.addEventListener("click", function () {
      var open = links.classList.toggle("is-open");
      burger.setAttribute("aria-expanded", open ? "true" : "false");
      links.style.display = open ? "flex" : "";
    });
    links.querySelectorAll("a").forEach(function (a) {
      a.addEventListener("click", function () {
        if (window.innerWidth <= 860) { links.classList.remove("is-open"); links.style.display = ""; burger.setAttribute("aria-expanded", "false"); }
      });
    });
  }

  /* ---- 4 · lightbox -------------------------------------------------- */
  var lb = document.getElementById("lightbox");
  if (!lb) return;
  var stage = lb.querySelector(".lb__stage img");
  var capTitle = lb.querySelector("[data-lb-title]");
  var capMeta = lb.querySelector("[data-lb-meta]");
  var capIndex = lb.querySelector("[data-lb-index]");
  var btnClose = lb.querySelector(".lb__close");
  var btnPrev = lb.querySelector("[data-lb-prev]");
  var btnNext = lb.querySelector("[data-lb-next]");
  var triggers = Array.prototype.slice.call(document.querySelectorAll("[data-plate]"));
  var current = 0, lastFocus = null;

  function plateData(btn) {
    return {
      full: btn.getAttribute("data-full"),
      title: btn.getAttribute("data-title") || "",
      meta: btn.getAttribute("data-meta") || "",
      no: btn.getAttribute("data-no") || ""
    };
  }
  function render(i) {
    current = (i + triggers.length) % triggers.length;
    var d = plateData(triggers[current]);
    stage.src = d.full;
    stage.alt = d.title;
    if (capTitle) capTitle.textContent = d.title;
    if (capMeta) capMeta.textContent = d.meta;
    if (capIndex) capIndex.textContent = d.no + "  ·  " + String(current + 1).padStart(2, "0") + " / " + String(triggers.length).padStart(2, "0");
  }
  function open(i) {
    lastFocus = document.activeElement;
    render(i);
    lb.classList.add("is-open");
    lb.setAttribute("aria-hidden", "false");
    document.body.style.overflow = "hidden";
    btnClose.focus();
    document.addEventListener("keydown", onKey);
  }
  function close() {
    lb.classList.remove("is-open");
    lb.setAttribute("aria-hidden", "true");
    document.body.style.overflow = "";
    document.removeEventListener("keydown", onKey);
    if (lastFocus) lastFocus.focus();
  }
  function onKey(e) {
    if (e.key === "Escape") close();
    else if (e.key === "ArrowRight") render(current + 1);
    else if (e.key === "ArrowLeft") render(current - 1);
    else if (e.key === "Tab") {
      // simple focus trap across the 3 controls
      var f = [btnClose, btnPrev, btnNext].filter(Boolean);
      var idx = f.indexOf(document.activeElement);
      if (e.shiftKey && idx <= 0) { e.preventDefault(); f[f.length - 1].focus(); }
      else if (!e.shiftKey && idx === f.length - 1) { e.preventDefault(); f[0].focus(); }
    }
  }
  triggers.forEach(function (btn, i) {
    btn.addEventListener("click", function (e) { e.preventDefault(); open(i); });
  });
  btnClose.addEventListener("click", close);
  if (btnPrev) btnPrev.addEventListener("click", function () { render(current - 1); });
  if (btnNext) btnNext.addEventListener("click", function () { render(current + 1); });
  lb.addEventListener("click", function (e) { if (e.target === lb) close(); });

  /* ---- 5 · footer year ---------------------------------------------- */
  var y = document.querySelector("[data-year]");
  if (y) y.textContent = new Date().getFullYear();
})();
