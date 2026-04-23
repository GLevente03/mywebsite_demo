document.addEventListener("DOMContentLoaded", () => {
    const langChangeBtn = document.querySelector(".language-change-button");

    // Beállítjuk a localStorage-ben lévő nyelvet gombosztályként (ha kell)
    let savedLang = localStorage.getItem("lang");
    if (savedLang) {
        langChangeBtn.classList.remove("hu", "en");
        langChangeBtn.classList.add(savedLang);
    }

    langChangeBtn.addEventListener("click", () => {
        let currentLang = langChangeBtn.classList.contains("hu") ? "hu" : "en";
        let newLang = currentLang === "hu" ? "en" : "hu";

        // AJAX kérés a nyelv beállításához
        fetch("/controller/change-lang.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ lang: newLang })
        })
        .then(res => res.json())
        .then(response => {
            console.log(response);

            // Gomb osztály frissítése
            langChangeBtn.classList.remove("hu", "en");
            langChangeBtn.classList.add(newLang);

            // localStorage és cookie frissítése
            localStorage.setItem("lang", newLang);
            document.cookie = "lang=" + newLang + "; path=/";

            // Oldal újratöltése új nyelvvel
            location.reload();
        })
        .catch(err => {
            console.error("Hiba a nyelvváltásnál:", err);
        });
    });
});
