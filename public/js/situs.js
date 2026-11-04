(function () {
  "use strict";
  var $ = function (id) { return document.getElementById(id); };

  /* ---------- Menu ---------- */
  var nav = $("top"), burger = $("burger");
  function tutup() {
    document.querySelectorAll(".menu li.open").forEach(function (li) {
      li.classList.remove("open");
      var b = li.querySelector("button"); if (b) b.setAttribute("aria-expanded", "false");
    });
  }
  document.querySelectorAll(".menu>li>button").forEach(function (b) {
    b.addEventListener("click", function (e) {
      e.stopPropagation();
      var li = b.parentNode, buka = li.classList.contains("open");
      tutup();
      if (!buka) { li.classList.add("open"); b.setAttribute("aria-expanded", "true"); }
    });
  });
  document.addEventListener("click", function (e) { if (!e.target.closest(".menu")) tutup(); });
  document.addEventListener("keydown", function (e) { if (e.key === "Escape") tutup(); });
  if (burger) burger.addEventListener("click", function () {
    var o = nav.classList.toggle("nav-open");
    burger.setAttribute("aria-expanded", o ? "true" : "false");
  });

  /* ---------- Salin teks / tautan ---------- */
  document.querySelectorAll("[data-salin]").forEach(function (b) {
    b.addEventListener("click", function () {
      var teks = b.getAttribute("data-salin"), label = b.textContent;
      if (teks.charAt(0) === "#") { var el = document.querySelector(teks); teks = el ? el.textContent : ""; }
      function ok() { b.textContent = "Tersalin"; setTimeout(function () { b.textContent = label; }, 1600); }
      if (navigator.clipboard) navigator.clipboard.writeText(teks).then(ok, function () {});
    });
  });

  /* ---------- Api suci di celah candi bentar ---------- */
  var c = $("api"); if (!c || !c.getContext) return;
  var reduce = window.matchMedia && matchMedia("(prefers-reduced-motion: reduce)").matches;
  var ctx = c.getContext("2d"), P = [], W = 0, H = 0;
  function ukur() { var r = c.getBoundingClientRect(), d = Math.min(2, window.devicePixelRatio || 1); W = r.width; H = r.height; c.width = W * d; c.height = H * d; ctx.setTransform(d, 0, 0, d, 0, 0); }
  function bara() { return { x: W * (.5 + (Math.random() - .5) * .08), y: H * .9, vx: (Math.random() - .5) * .25, vy: -(.5 + Math.random() * 1.1), r: .8 + Math.random() * 2, life: 1 }; }
  ukur(); addEventListener("resize", ukur);
  for (var i = 0; i < 90; i++) { var p = bara(); p.y = H * (.2 + Math.random() * .7); p.life = Math.random(); P.push(p); }
  function frame() {
    if (!W) ukur();
    ctx.clearRect(0, 0, W, H);
    var fl = .5 + .12 * Math.sin(Date.now() / 180) + .06 * Math.sin(Date.now() / 67);
    var g = ctx.createRadialGradient(W * .5, H * .88, 0, W * .5, H * .88, W * .2);
    g.addColorStop(0, "rgba(255,170,90," + fl.toFixed(2) + ")");
    g.addColorStop(.45, "rgba(232,104,44," + (fl * .45).toFixed(2) + ")");
    g.addColorStop(1, "rgba(232,104,44,0)");
    ctx.fillStyle = g; ctx.fillRect(0, 0, W, H);
    P.forEach(function (p, i) {
      p.x += p.vx + Math.sin((p.y + i * 7) * .04) * .25; p.y += p.vy; p.life -= .005;
      if (p.life <= 0 || p.y < H * .04) { P[i] = bara(); return; }
      ctx.beginPath(); ctx.arc(p.x, p.y, p.r, 0, 6.283);
      ctx.fillStyle = "rgba(245," + Math.round(140 + 90 * p.life) + ",80," + (p.life * .85).toFixed(2) + ")"; ctx.fill();
    });
    if (!reduce && !document.hidden) requestAnimationFrame(frame);
  }
  document.addEventListener("visibilitychange", function () { if (!document.hidden && !reduce) frame(); });
  frame();
})();
