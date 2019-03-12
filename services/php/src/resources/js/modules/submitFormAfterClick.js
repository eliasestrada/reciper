/**
 * @param {object} form Form that will be submited
 * @param {object} btn Button that trigger the event
 * @param {string} confirmMsg Message for a confirm message
 * @param {string|null} checkbox Checkbox that needs to be checked
 * @return {void}
 */
export default function(form, btn, confirmMsg, checkbox = null) {
    btn.addEventListener('click', () => {
        checkbox ? (checkbox.checked = true) : ''
        confirm(confirmMsg) ? form.submit() : ''
    })
}