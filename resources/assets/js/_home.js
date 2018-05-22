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
if (id('btn-for-banner') && id('banner-form')) {
	showTargetAfterClickButton(id('btn-for-banner'), id('banner-form'))
}

if (id('btn-for-intro') && id('intro-form')) {
	showTargetAfterClickButton(id('btn-for-intro'), id('intro-form'))
}

if (id('btn-for-footer') && id('footer-form')) {
	showTargetAfterClickButton(id('btn-for-footer'), id('footer-form'))
}