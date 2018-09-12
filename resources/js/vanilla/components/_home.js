/**
 * These functions allows admin see edit form after clicking
 * edit button
 */
if ($("btn-for-intro")) {
    activeAfterClickBtn("intro-form", "btn-for-intro");
}
if ($("btn-for-footer")) {
    activeAfterClickBtn("footer-form", "btn-for-footer");
}

/**
 * When visitor clicks search button, it will show the search form
 * instead of submitting, js prevents default behavior. After first click
 * it will set @var preventing to false, now after second click, it
 * will submit the search form
 */
if ($("home-search-form")) {
    (function() {
        let preventing = true;
        let button = $("home-search-btn");
        activeAfterClickBtn("home-search-form", "home-search-btn");

        button.addEventListener("click", e => {
            if (preventing === true) {
                e.preventDefault();
                preventing = false;
            }
        });
    })();
}
