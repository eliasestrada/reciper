/**
 * A simple way to cut 'document.getElementById'
 * @param {string} e
 */
function id(e) {
	return document.getElementById(e)
}

let categoriesTitle = document.querySelector('.categories-title')
let accordion = document.getElementsByClassName("accordion")
let menuUl = document.querySelector('#nav-menu ul')
let categoriesButton = id('categories-button')
let categoriesMenu = id('categories-menu')
let menuContainer = id('menu-container')
let loadingTitle = id('loading-title')
let arrowBottom = id('arrow-bottom')
let searchInput = id('search-input')
let categoriesMenuOpened = false
let target = id("target-image")
let hamburger = id('hamburger')
let navMenu = id('nav-menu')
let loading = id('loading')
let src = id("src-image")
let logo = id('logo')
let opened = false
let i