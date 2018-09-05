if ($("nav-btn-for-search")) {
    activeAfterClickBtn("nav-search-form", "nav-btn-for-search");

    $("nav-btn-for-search").addEventListener("click", () =>
        $("search-input").focus()
    );
    $("nav-btn-for-search-footer").addEventListener("click", () =>
        $("search-input").focus()
    );
}

if ($("nav-btn-for-search-footer")) {
    activeAfterClickBtn("nav-search-form", "nav-btn-for-search-footer");
}
