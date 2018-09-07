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
