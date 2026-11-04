(function () {
  "use strict";

  // Sidebar di layar kecil
  var burger = document.getElementById("burger"), sb = document.getElementById("sidebar");
  if (burger && sb) {
    burger.addEventListener("click", function (e) {
      e.stopPropagation();
      var b = sb.classList.toggle("buka");
      burger.setAttribute("aria-expanded", b ? "true" : "false");
    });
    document.addEventListener("click", function (e) { if (!sb.contains(e.target)) sb.classList.remove("buka"); });
  }

  // Tutup menu akun saat klik di luar
  document.addEventListener("click", function (e) {
    document.querySelectorAll("details.akun[open]").forEach(function (d) { if (!d.contains(e.target)) d.removeAttribute("open"); });
  });

  // Konfirmasi hapus
  document.querySelectorAll("form[data-konfirmasi]").forEach(function (f) {
    f.addEventListener("submit", function (e) { if (!window.confirm(f.getAttribute("data-konfirmasi"))) e.preventDefault(); });
  });

  // Slug otomatis dari judul (selama slug belum diubah manual)
  document.querySelectorAll("[data-slug-dari]").forEach(function (s) {
    var src = document.getElementById(s.getAttribute("data-slug-dari")); if (!src) return;
    var manual = s.value !== "";
    s.addEventListener("input", function () { manual = s.value !== ""; });
    src.addEventListener("input", function () {
      if (manual) return;
      s.placeholder = src.value.toLowerCase().normalize("NFD").replace(/[̀-ͯ]/g, "").replace(/[^a-z0-9]+/g, "-").replace(/^-|-$/g, "").slice(0, 80);
    });
  });

  // Pratinjau gambar sebelum diunggah
  document.querySelectorAll("input[type=file][data-pratinjau='1']").forEach(function (inp) {
    var img = inp.parentNode.querySelector(".unggah-pratinjau");
    inp.addEventListener("change", function () {
      var f = inp.files && inp.files[0];
      if (!f || !img) return;
      img.src = URL.createObjectURL(f); img.hidden = false;
    });
  });

  // Penyunting markdown sederhana
  function esc(s) { return s.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;"); }
  function md(src) {
    var out = [], list = false;
    esc(src).split(/\n{2,}/).forEach(function (blok) {
      blok = blok.trim(); if (!blok) return;
      var inline = function (t) {
        return t.replace(/\*\*(.+?)\*\*/g, "<b>$1</b>").replace(/\*(.+?)\*/g, "<i>$1</i>")
          .replace(/\[(.+?)\]\((https?:\/\/[^\s)]+)\)/g, '<a href="$2">$1</a>');
      };
      if (/^### /.test(blok)) out.push("<h3>" + inline(blok.slice(4)) + "</h3>");
      else if (/^## /.test(blok)) out.push("<h2>" + inline(blok.slice(3)) + "</h2>");
      else if (/^&gt; /.test(blok)) out.push("<blockquote>" + inline(blok.replace(/^&gt; /gm, "")) + "</blockquote>");
      else if (/^- /.test(blok)) out.push("<ul>" + blok.split("\n").map(function (l) { return "<li>" + inline(l.replace(/^- /, "")) + "</li>"; }).join("") + "</ul>");
      else out.push("<p>" + inline(blok).replace(/\n/g, "<br>") + "</p>");
    });
    return out.join("");
  }
  document.querySelectorAll(".md").forEach(function (w) {
    var ta = w.querySelector("textarea"), hasil = w.querySelector(".md-hasil");
    w.querySelectorAll("[data-md]").forEach(function (b) {
      b.addEventListener("click", function () {
        var p = b.getAttribute("data-md").replace(/\\n/g, "\n").split("|"), a = ta.selectionStart, z = ta.selectionEnd;
        var pilih = ta.value.slice(a, z) || (b.title === "Tautan" ? "teks tautan" : "");
        ta.setRangeText(p[0] + pilih + (p[1] || ""), a, z, "end"); ta.focus();
      });
    });
    var pv = w.querySelector(".md-pratinjau");
    if (pv) pv.addEventListener("click", function () {
      var on = hasil.hidden;
      if (on) hasil.innerHTML = md(ta.value) || "<p><i>Belum ada isi.</i></p>";
      hasil.hidden = !on; ta.hidden = on; pv.textContent = on ? "Tulis" : "Pratinjau";
    });
  });
})();
