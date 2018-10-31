function switchTheme(state) {
    fetch(`/dark-theme-switcher/${state}`).catch(err => console.error(err));
}

$("dark-theme-toggle").addEventListener("click", () => {
    if (document.body.classList.value === "dark-theme") {
        document.body.classList.remove("dark-theme");
        switchTheme(0);
    } else {
        document.body.classList.add("dark-theme");
        switchTheme(1);
    }
});
