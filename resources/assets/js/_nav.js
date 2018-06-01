
/**
 * Function runs only if min-width of display is less than 640px
 */
if (window.matchMedia("( min-width: 640px )").matches && $('categories-button')) {
	addClassToElement('categories-menu', 'categories-button', 'categor-menu-opened')
}

/**
 * Opens navigation menu on mobile screens
 * after clicking on 'humburger' button
 * 
 * @event click
 */
let opened = false

$('hamburger').addEventListener('click', () => {
	$('nav-menu').className = "nav-opened"
	$('menu-container').style.opacity = "0"
	$('logo').className = "logo-opened"
	$('logo').style.opacity = "1"
	$('logo').style.display = "block"
	document.querySelector('#nav-menu ul').style.display = "block"
	opened = true
})

/**
 * Closing navigation menu on mobile screen
 * after clicking anywhere except our navigation
 * 
 * @event mouseup
 */
window.addEventListener('mouseup', e => {
	if (e.target != $('nav-menu') && opened === true && e.target.parentNode != $('nav-menu')) {
		$('menu-container').style.opacity = "0.8"
		$('nav-menu').className = "nav-closed"
		$('logo').className = "logo-closed"
		document.querySelector('#nav-menu ul').style.display = "none"
		opened = false
	}
})

/**
 * Removing word 'Категории' on mobile screen,
 * and put it back on descktop
 */
document.querySelector('.categories-title').innerHTML
	= window.matchMedia("( min-width: 640px )").matches
	? 'Категории'
	: ''
