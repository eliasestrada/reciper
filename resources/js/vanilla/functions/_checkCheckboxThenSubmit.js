/**
 * The function will check the given checkbox after clicking given
 * button, then it will submit the closest form to checkbox
 * @param {string} checkbox
 * @param {string} button
 */
function checkCheckboxThenSubmit(checkbox, button, callback = true) {
    $(button).addEventListener("click", () => {
        if (callback() == true) {
            if (($(checkbox).checked = true)) {
                $(checkbox)
                    .closest("form")
                    .submit();
            }
        }
    });
}
