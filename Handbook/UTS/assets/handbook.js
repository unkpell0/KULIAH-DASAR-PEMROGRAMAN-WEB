// Handbook SIFILM-Mini: tombol Salin pada blok kode, menu mobile, dan penanda bagian aktif.
(function () {
    // 1. Tombol Salin
    document.querySelectorAll(".highlight").forEach(function (blok) {
        const tombol = document.createElement("button");
        tombol.type = "button";
        tombol.className = "copy-btn";
        tombol.textContent = "Salin";
        tombol.addEventListener("click", function () {
            const kode = blok.querySelector("pre").innerText;
            const selesai = function () {
                tombol.textContent = "Tersalin";
                tombol.classList.add("done");
                setTimeout(function () {
                    tombol.textContent = "Salin";
                    tombol.classList.remove("done");
                }, 1500);
            };
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(kode).then(selesai, function () {});
            }
        });
        blok.appendChild(tombol);
    });

    // 2. Menu di layar kecil
    const side = document.getElementById("side");
    const btn = document.getElementById("menu-btn");
    if (side && btn) {
        btn.addEventListener("click", function () {
            const buka = side.classList.toggle("open");
            btn.setAttribute("aria-expanded", buka ? "true" : "false");
        });
    }

    // 3. Penanda bagian aktif di daftar isi halaman
    const tautan = Array.from(document.querySelectorAll(".toc a"));
    if (tautan.length && "IntersectionObserver" in window) {
        const peta = new Map();
        tautan.forEach(function (a) {
            const el = document.getElementById(a.getAttribute("href").slice(1));
            if (el) peta.set(el, a);
        });
        const pengamat = new IntersectionObserver(function (entri) {
            entri.forEach(function (e) {
                if (e.isIntersecting) {
                    tautan.forEach(function (a) { a.classList.remove("active"); });
                    peta.get(e.target).classList.add("active");
                }
            });
        }, { rootMargin: "0px 0px -75% 0px" });
        peta.forEach(function (_, el) { pengamat.observe(el); });
    }
})();
