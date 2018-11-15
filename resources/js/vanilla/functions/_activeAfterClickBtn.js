/**
 * Show certain element by adding active class and
 * removing after another click event
 *
 * @param {string} element that u want to show
 * @param {string} button that u want to click
 */
function activeAfterClickBtn(element, button, customClass = 'active') {
    let visible = false;

    $(button).addEventListener('click', () => {
        if (visible === false) {
            $(element).classList.add(customClass);
            visible = true;
        } else if (visible === true) {
            $(element).classList.remove(customClass);
            visible = false;
        }
    });
}
