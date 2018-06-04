/**
 * A simple way to cut 'document.getElementById'
 * @param {string} e
 */
function $(e) {
	return document.getElementById(e);
}

var i = void 0;

/**
 * Show certain element by adding active class and
 * removing after another click event
 * 
 * @param {string} element that u want to show
 * @param {string} button that u want to click
 */
function activeAfterClickBtn(element, button) {
	var visible = false;

	$(button).addEventListener('click', function () {
		if (visible === false) {
			$(element).classList.add('active');
			visible = true;
		} else if (visible === true) {
			$(element).classList.remove('active');
			visible = false;
		}
	});
}

// This object auto updates pictures after
// selecting them via file input
var imageUploader = {
	target: $("target-image"),
	src: $("src-image"),
	fr: new FileReader(),
	showImage: function showImage() {
		var _this = this;

		this.src.addEventListener("change", function () {
			if (_this.src.files.length !== 0) {
				var that = _this;
				_this.fr.readAsDataURL(_this.src.files[0]);
				_this.fr.onload = function (e) {
					that.target.src = this.result;
				};
			} else {
				_this.target.src = '/storage/images/default.jpg';
			}
		});
	}

	// User on page where variables:
	// src and target exist, run function
};if (imageUploader.src && imageUploader.target) {
	imageUploader.showImage();
}
// After page has been loaded, it will
// remove the loading animation
window.onload = function () {
	$('loading').classList.remove("loading");
	$('loading-title').innerHTML = '';
};
if ($('btn-for-intro')) {
	activeAfterClickBtn('intro-form', 'btn-for-intro');
}

if ($('btn-for-footer')) {
	activeAfterClickBtn('footer-form', 'btn-for-footer');
}

if ($('search-form')) {
	activeAfterClickBtn('search-form', 'home-search-btn');
}

/**
 * Function runs only if min-width of display is less than 640px
 */
if (window.matchMedia("( min-width: 640px )").matches && $('categories-button')) {
	activeAfterClickBtn('categories-menu', 'categories-button');
}

/**
 * Opens navigation menu on mobile screens
 * after clicking on 'humburger' button
 * 
 * @event click
 */
var opened = false;

$('hamburger').addEventListener('click', function () {
	$('nav-menu').className = "nav-opened";
	$('menu-container').style.opacity = "0";
	$('logo').className = "logo-opened";
	$('logo').style.opacity = "1";
	$('logo').style.display = "block";
	document.querySelector('#nav-menu ul').style.display = "block";
	opened = true;
});

/**
 * Closing navigation menu on mobile screen
 * after clicking anywhere except our navigation
 * 
 * @event mouseup
 */
window.addEventListener('mouseup', function (e) {
	if (e.target != $('nav-menu') && opened === true && e.target.parentNode != $('nav-menu')) {
		$('menu-container').style.opacity = "0.8";
		$('nav-menu').className = "nav-closed";
		$('logo').className = "logo-closed";
		document.querySelector('#nav-menu ul').style.display = "none";
		opened = false;
	}
});

/**
 * Removing word 'Категории' on mobile screen
 */
if (window.matchMedia("( max-width: 640px )").matches) {
	document.querySelector('.categories-title').innerHTML = '';
}
/**
 * @param {string} input
 * @returns {boolean}
 */
function inputValueIsInteger(input) {
	if (Number.isInteger(parseInt($(input).value))) {
		return true;
	}
	return false;
}

/**
 * @param {string} input 
 */
function setInputValueToEmpty(input) {
	if (input = $(input)) {
		input.setAttribute('value', '');
	}
}

// Run funtion
if ($('search-input') && inputValueIsInteger('search-input')) {
	setInputValueToEmpty('search-input');
}
if ($('user-sidebar')) {
	activeAfterClickBtn('user-sidebar', 'user-sidebar-activator');
}