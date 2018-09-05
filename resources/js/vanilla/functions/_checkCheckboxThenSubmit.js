/**
 * The function will check the given checkbox after clicking given
 * button, then it will submit the closest form to checkbox
 * @param {string} checkbox
 * @param {string} button
 */
function checkCheckboxThenSubmit(checkbox, button) {
    $(button).addEventListener("click", () => {
        if (($(checkbox).checked = true)) {
            $(checkbox)
                .closest("form")
                .submit();
        }
    });
}
