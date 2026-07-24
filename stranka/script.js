const toggle = document.getElementById("profileToggle");
const dropdown = document.getElementById("profileDropdown");

toggle.addEventListener("click", () => {
    dropdown.style.display =
        dropdown.style.display === "flex" ? "none" : "flex";
});

// klik mimo = zavrie
document.addEventListener("click", function(e) {
    if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.style.display = "none";
    }
});
