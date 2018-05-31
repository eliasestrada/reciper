
/**
 * Show certain element by adding class and removing after
 * another click event
 * 
 * @param {string} element that u want to show
 * @param {string} button that u want to click
 * @param {string} className class that you want to add after click 
 */
function addClassToElement(element, button, className) {
	let visible = false

	$(button).addEventListener('click', () => {
		if (visible === false) {
			$(element).classList.add(className)
			visible = true
		} else if (visible === true) {
			$(element).classList.remove(className)
			visible = false
		}
	})
}
