/**
 * A simple way to cut 'document.getElementById'
 * @param {string} e
 */
function $(e) {
	return document.getElementById(e);
}

var i = void 0;
// After page has been loaded, it will
// remove the loading animation
window.onload = function () {
	$('loading').classList.remove("loading");
	$('loading-title').innerHTML = '';
};

if ($('search-input') && Number.isInteger(parseInt($('search-input').value))) $('search-input').setAttribute('value', '');

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
};if (imageUploader.src && imageUploader.target) imageUploader.showImage();

// Loop for accordion functionality
var accordion = document.getElementsByClassName("accordion");

if (accordion) {
	for (i = 0; i < accordion.length; i++) {
		accordion[i].addEventListener("click", function () {
			this.classList.toggle("accordion-active");
			var panel = this.nextElementSibling;

			panel.style.maxHeight = panel.style.maxHeight ? null : panel.scrollHeight + "px";
		});
	}
}
function showTargetAfterClickButton(btn, target) {
	var visible = false;

	btn.addEventListener('click', function () {
		if (visible === true) {
			target.style.display = 'none';
			visible = false;
		} else if (visible === false) {
			target.style.display = 'block';
			visible = true;
		}
	});
}

// Run function
if ($('btn-for-banner') && $('banner-form')) {
	showTargetAfterClickButton($('btn-for-banner'), $('banner-form'));
}

if ($('btn-for-intro') && $('intro-form')) {
	showTargetAfterClickButton($('btn-for-intro'), $('intro-form'));
}

if ($('btn-for-footer') && $('footer-form')) {
	showTargetAfterClickButton($('btn-for-footer'), $('footer-form'));
}
// Event works only if min-width of display is less than 640px
var categoriesMenuOpened = false;

if (window.matchMedia("( min-width: 640px )").matches) {
	$('categories-button').addEventListener('click', function () {

		if (categoriesMenuOpened === false) {
			$('categories-menu').style.display = "block";
			$('arrow-bottom').classList.add('arrow-bottom-rotate');
			categoriesMenuOpened = true;
			setTimeout(function () {
				return $('categories-menu').style.opacity = "1";
			}, 100);
		} else if (categoriesMenuOpened === true) {
			$('categories-menu').style.opacity = "0";
			$('arrow-bottom').classList.remove('arrow-bottom-rotate');
			categoriesMenuOpened = false;
			setTimeout(function () {
				return $('categories-menu').style.display = "none";
			}, 100);
		}
	});
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

		if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
			$('logo').style.opacity = "0";
			$('logo').style.display = "none";
		}
	}
});

/**
 * Hide Navbar into a humburger menu
 * when user scrolls lower than 100 px
 */
window.onscroll = function () {
	if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
		$('menu-container').className = "hamburger-menu";
		if (opened === false) $('logo').style.opacity = "0";
		$('logo').style.display = "none";
	} else {
		$('menu-container').className = "regular-menu";
		if (opened === false) $('logo').style.opacity = "1";
		$('logo').style.display = "block";
	}
};

/**
 * Removing word 'Категории' on mobile screen,
 * and put it back on descktop
 */
document.querySelector('.categories-title').innerHTML = window.matchMedia("( min-width: 640px )").matches ? 'Категории' : '';