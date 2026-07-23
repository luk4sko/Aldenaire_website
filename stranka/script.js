/*
 * script.js – ovládanie profilového menu (rozbaľovacieho okna) v hlavičke.
 * Po kliknutí na profilovú ikonu sa menu zobrazí / skryje.
 * Kliknutím kamkoľvek mimo menu sa zatvorí.
 */

const toggle = document.getElementById("profileToggle");     // profilová ikona
const dropdown = document.getElementById("profileDropdown");  // rozbaľovacie menu

// Klik na ikonu = prepni medzi zobrazené (flex) a skryté (none)
toggle.addEventListener("click", () => {
    dropdown.style.display =
        dropdown.style.display === "flex" ? "none" : "flex";
});

// Klik mimo ikony aj mimo menu = menu zatvor
document.addEventListener("click", function(e) {
    if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.style.display = "none";
    }
});
