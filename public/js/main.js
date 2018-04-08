function id(e) {
	return document.getElementById(e)
}

let menuUl = document.querySelector("#nav-menu ul")
let opened = false
let categoriesMenuOpened = false

// Functions
function openMenu() {
    id("nav-menu").className = "nav-opened"
    id("menu-container").style.opacity = "0"
    id("logo").className = "logo-opened"
    id("logo").style.opacity = "1"
    id("logo").style.display = "block"
    menuUl.style.display = "block"
    opened = true
}

function closeMenu() {
    id("menu-container").style.opacity = "0.8"
    id("nav-menu").className = "nav-closed"
    id("logo").className = "logo-closed"
    menuUl.style.display = "none"

    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        id("logo").style.opacity = "0"
        id("logo").style.display = "none"
    }

    opened = false
}

function hideMenuBarIntoButton() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        id("menu-container").className = "hamburger-menu"
        if (opened === false) {
            id("logo").style.opacity = "0"
            id("logo").style.display = "none"
        }
    } else {
        id("menu-container").className = "regular-menu"
        if (opened === false) {
            id("logo").style.opacity = "1"
            id("logo").style.display = "block"
        }
    }
}

// Events
id("hamburger").addEventListener('click', openMenu)

window.addEventListener('mouseup', (event) => {
    if (event.target != id("nav-menu") && opened === true && event.target.parentNode != id("nav-menu")) {
        closeMenu()
    }
})

window.onscroll = () => hideMenuBarIntoButton()

// Nav menu categories
if (window.matchMedia("(min-width: 640px)").matches) {
	id('categories-button').addEventListener('click', () => {
		if (categoriesMenuOpened === false) {
			id('categories-menu').style.display = "block"
			id('arrow-bottom').classList.add('arrow-bottom-rotate')
			categoriesMenuOpened = true
			setTimeout(() => id('categories-menu').style.opacity = "0.9", 100)
		} else if (categoriesMenuOpened === true) {
			id('categories-menu').style.opacity = "0"
			id('arrow-bottom').classList.remove('arrow-bottom-rotate')
			categoriesMenuOpened = false
			setTimeout(() => id('categories-menu').style.display = "none", 100)
		}
	})
}