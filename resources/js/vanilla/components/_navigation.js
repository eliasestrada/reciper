(function SearchFormActivator() {
    let opened = false;
    let navBtnForSearch = $("nav-btn-for-search");
    let searchInput = $("search-input");

    if (navBtnForSearch) {
        activeAfterClickBtn("nav-search-form", "nav-btn-for-search");

        navBtnForSearch.addEventListener("click", () => {
            if (opened == false) {
                searchInput.focus();
                opened = true;
            } else {
                searchInput.blur();
                opened = false;
            }
        });
    }
})();

(function DarkThemeSwitcher() {
    let button = $("dark-theme-toggle");
    let className = document.body.classList;
    let urlWithState = state => `/invokes/dark-theme-switcher/${state}`;

    button.addEventListener("click", () => {
        if (className.value === "dark-theme") {
            className.remove("dark-theme");
            fetch(urlWithState(0)).catch(e => console.error(e));
        } else {
            className.add("dark-theme");
            fetch(urlWithState(1)).catch(e => console.error(e));
        }
    });
})();
