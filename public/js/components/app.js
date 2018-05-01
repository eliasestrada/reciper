/**
 * A simple way to cut 'document.getElementById'
 * 
 * @name shortcut
 * @param {string} e
 */
function id(e) {
	return document.getElementById(e)
}

let categoriesTitle = document.querySelector('.categories-title')
let menuUl = document.querySelector('#nav-menu ul')
let categoriesButton = id('categories-button')
let categoriesMenu = id('categories-menu')
let menuContainer = id('menu-container')
let loadingTitle = id('loading-title')
let arrowBottom = id('arrow-bottom')
let categoriesMenuOpened = false
let hamburger = id('hamburger')
let navMenu = id('nav-menu')
let loading = id('loading')
let logo = id('logo')
let opened = false


/**
 * Event works only if min-width of display is less than 640px
 * 
 * @name NavMenuCategories
 * @event click
 */
if (window.matchMedia("( min-width: 640px )").matches) {
	categoriesButton.addEventListener('click', () => {

		if (categoriesMenuOpened === false) {
			categoriesMenu.style.display = "block"
			arrowBottom.classList.add('arrow-bottom-rotate')
			categoriesMenuOpened = true
			setTimeout(() => categoriesMenu.style.opacity = "1", 100)
		} else if (categoriesMenuOpened === true) {
			categoriesMenu.style.opacity = "0"
			arrowBottom.classList.remove('arrow-bottom-rotate')
			categoriesMenuOpened = false
			setTimeout(() => categoriesMenu.style.display = "none", 100)
		}
	})
}

/**
 * After page has been loaded, it will
 * remove the loading animation
 * 
 * @name preloader
 */
window.onload = () => {
	loading.classList.remove("loading")
	loadingTitle.innerHTML = ''
}

/**
 * Opens navigation menu on mobile screens
 * after clicking on 'humburger' button
 * 
 * @name OpenNavigationMenu
 * @event click
 */
hamburger.addEventListener('click', () => {
	navMenu.className = "nav-opened"
	menuContainer.style.opacity = "0"
	logo.className = "logo-opened"
	logo.style.opacity = "1"
	logo.style.display = "block"
	menuUl.style.display = "block"
	opened = true
})

/**
 * Closing navigation menu on mobile screen
 * after clicking anywhere except our navigation
 * 
 * @name CloseNavMenu
 * @event mouseup
 */
window.addEventListener('mouseup', e => {
	if (e.target != navMenu && opened === true && e.target.parentNode != navMenu) {
		menuContainer.style.opacity = "0.8"
		navMenu.className = "nav-closed"
		logo.className = "logo-closed"
		menuUl.style.display = "none"

		if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
			logo.style.opacity = "0"
			logo.style.display = "none"
		}
		opened = false
	}
})

/**
 * Hide Navbar into a humburger menu
 * when user scrolls lower than 100 px
 * 
 * @name HideNavbar
 */
window.onscroll = () => {
	if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
		menuContainer.className = "hamburger-menu"
		if (opened === false) {
			logo.style.opacity = "0"
			logo.style.display = "none"
		}
	} else {
		menuContainer.className = "regular-menu"
		if (opened === false) {
			logo.style.opacity = "1"
			logo.style.display = "block"
		}
	}
}

/**
 * Removing word 'Категории' on mobile screen,
 * and put it back on descktop
 */
if (window.matchMedia("( min-width: 640px )").matches) {
	categoriesTitle.innerHTML = 'Категории'
} else {
	categoriesTitle.innerHTML = ''
}