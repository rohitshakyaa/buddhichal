import "./bootstrap";
import "flowbite";

import "tabulator-tables/dist/css/tabulator_midnight.min.css";
import "./tabulators/TournamentTable.js";
import "./tabulators/NcaMemberTable.js";
import "./tabulators/TournamentPlayer.js";
import "./tabulators/BannerTable";
import "./tabulators/BookTable";
import "./tabulators/ChampionTable";

if (
    localStorage.getItem("color-theme") === "dark" ||
    (!("color-theme" in localStorage) &&
        window.matchMedia("(prefers-color-scheme: dark)").matches)
) {
    darkMode();
} else {
    lightMode();
}

document.getElementById("toggle-theme").addEventListener("click", (e) => {
    const colorTheme = localStorage.getItem("color-theme");
    if (colorTheme === "dark") {
        lightMode();
    } else {
        darkMode();
    }
});

function lightMode() {
    localStorage.setItem("color-theme", "light");
    document.documentElement.classList.remove("dark");
    if (document.getElementById("toggle-theme"))
        document.getElementById("toggle-theme").innerHTML =
            '<i class="fa-solid fa-moon text-gray-400"></i>';
}

function darkMode() {
    console.log("HERE");
    localStorage.setItem("color-theme", "dark");
    if (document.getElementById("toggle-theme"))
        document.getElementById("toggle-theme").innerHTML =
            '<i class="fa-solid fa-sun text-white"></i>';
    document.documentElement.classList.add("dark");
}
