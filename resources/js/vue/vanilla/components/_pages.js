/**
 * When visitor clicks search button, it will show the search form
 * instead of submitting, js prevents default behavior. After first click
 * it will set varible preventing to false, now after second click, it
 * will submit the search form
 */
(function HomeHeaderSearchForm() {
    let preventing = true;
    let button = $("home-search-btn");
    let form = $("home-search-form");

    if (form && button) {
        activeAfterClickBtn("home-search-form", "home-search-btn");

        button.addEventListener("click", e => {
            if (preventing) {
                e.preventDefault();
                preventing = false;
            }
        });
    }
})();
