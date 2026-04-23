function toggleMenu(x) {
    let menu = document.getElementById("myMenu");
    let overlay = document.querySelector(".overlay");
    if (menu.style.width === "250px") {
        menu.style.width = "0";
        overlay.classList.add("invisible");
        overlay.classList.remove("visible");
    } else {
        menu.style.width = "250px";
        overlay.classList.remove("invisible");
        overlay.classList.add("visible");
    }
    if (x) {
        x.classList.toggle("change");
    }
}
