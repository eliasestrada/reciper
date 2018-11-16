import $ from './_main';

/**
 * Show certain element by adding active class and
 * removing after another click event
 *
 * @param {string} el that u want to show
 * @param {string} btn that u want to click
 * @param {string} customClass
 * @return {void}
 */
export default (el, btn, customClass = 'active') => {
    let visible = false;

    $(btn).addEventListener('click', () => {
        if (visible === false) {
            $(el).classList.add(customClass);
            visible = true;
        } else if (visible === true) {
            $(el).classList.remove(customClass);
            visible = false;
        }
    });
};
