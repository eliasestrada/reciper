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