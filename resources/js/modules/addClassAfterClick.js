/**
 * Show certain element by adding active class and
 * removing after another click event
 *
 * @param {object} el that u want to show
 * @param {object} btn that u want to click
 * @param {string} className
 * @param {callback} onOpen
 * @param {callback} onClose
 * @return {void}
 */
export default (el, btn, className = 'active', onOpen, onClose) => {
    let visible = false

    btn.addEventListener('click', () => {
        if (visible === false) {
            if (Object.prototype.toString.call(onOpen) == "[object Function]") {
                onOpen()
            }
            el.classList.add(className)
            visible = true
        } else {
            if (Object.prototype.toString.call(onClose) == "[object Function]") {
                onClose()
            }
            el.classList.remove(className)
            visible = false
        }
    })
}
