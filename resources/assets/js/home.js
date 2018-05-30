function showTargetAfterClickButton (btn, target) {
	let visible = false

	btn.addEventListener('click', () => {
		if (visible === true) {
			target.style.display = 'none'
			visible = false
		} else if (visible === false) {
			target.style.display = 'block'
			visible = true
		}
	})
}

// Run function
if ($('btn-for-banner') && $('banner-form')) {
	showTargetAfterClickButton($('btn-for-banner'), $('banner-form'))
}

if ($('btn-for-intro') && $('intro-form')) {
	showTargetAfterClickButton($('btn-for-intro'), $('intro-form'))
}

if ($('btn-for-footer') && $('footer-form')) {
	showTargetAfterClickButton($('btn-for-footer'), $('footer-form'))
}