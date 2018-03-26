function $(e) {
	return document.getElementById(e)
}

let menuNav = $("nav-menu"),
	logoNav = $("logo"),
	button = $("hamburger"),
	menuConteiner = $("menu-container"),
	menuUl = document.querySelector("#nav-menu ul"),
	homeSearchBtn = $("home-search-btn"),
	headerSearchInput = $("header-search-input"),
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

function showHeaderSearch() {
	headerSearchInput.style.opacity = "1"
}

// Events
button.addEventListener('click', openMenu)
homeSearchBtn.addEventListener('click', showHeaderSearch)

window.addEventListener('mouseup', function (event) {
    if (event.target != menuNav && opened === true && event.target.parentNode != menuNav) {
        closeMenu()
    }
})

window.onscroll = () => hideMenuBarIntoButton()