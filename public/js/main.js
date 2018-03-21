let menuNav = document.getElementById("nav-menu"),
	logoNav = document.getElementById("logo"),
	button = document.getElementById("hamburger"),
	menuConteiner = document.getElementById("menu-container"),
	menuUl = document.querySelector("#nav-menu ul"),
	opened = false


// Functions
function openMenu() {
    menuNav.className = "nav-opened"
    menuConteiner.style.opacity = "0"
    logoNav.className = "logo-opened"
    logoNav.style.opacity = "1"
    logoNav.style.display = "block"
    menuUl.style.display = "block"
    opened = true
}

function closeMenu() {
    menuConteiner.style.opacity = "0.8"
    menuNav.className = "nav-closed"
    logoNav.className = "logo-closed"
    menuUl.style.display = "none"

    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        logoNav.style.opacity = "0"
        logoNav.style.display = "none"
    }

    opened = false
}

function hideMenuBarIntoButton() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        menuConteiner.className = "hamburger-menu"
        if (opened === false) {
            logoNav.style.opacity = "0"
            logoNav.style.display = "none"
        }
    } else {
        menuConteiner.className = "regular-menu"
        if (opened === false) {
            logoNav.style.opacity = "1"
            logoNav.style.display = "block"
        }
    }
}

// Events
button.addEventListener('click', openMenu)

window.addEventListener('mouseup', function (event) {
    if (event.target != menuNav && opened === true && event.target.parentNode != menuNav) {
        closeMenu()
    }
})

window.onscroll = () => hideMenuBarIntoButton()