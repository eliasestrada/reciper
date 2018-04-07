function id(e) {
	return document.getElementById(e)
}

let menuUl = document.querySelector("#nav-menu ul")
let opened = false


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

window.addEventListener('mouseup', function (event) {
    if (event.target != id("nav-menu") && opened === true && event.target.parentNode != id("nav-menu")) {
        closeMenu()
    }
})

window.onscroll = () => hideMenuBarIntoButton()