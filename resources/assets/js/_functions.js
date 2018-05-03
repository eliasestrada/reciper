/**
 * After page has been loaded, it will
 * remove the loading animation
 */
window.onload = () => {
	loading.classList.remove("loading")
	loadingTitle.innerHTML = ''
}

if (searchInput && Number.isInteger(parseInt(searchInput.value)))
	searchInput.setAttribute('value', '')


/**
 * This function auto updates pictures after selecting them via
 * file input
 * @param {string} src 
 * @param {string} target 
 */
function showImage(src, target) {
	var fr = new FileReader()
	
	fr.onload = function(e) { target.src = this.result }
	src.addEventListener("change", ()=> fr.readAsDataURL(src.files[0]))
}

// User on page where variables:
// src and target exist, run function
if (src && target) showImage(src, target)

/**
 * Loop for accordion functionality
 */
if (accordion) {
	for (i = 0; i < accordion.length; i++) {
		accordion[i].addEventListener("click", function(){
			this.classList.toggle("accordion-active")
			let panel = this.nextElementSibling

			panel.style.maxHeight
				= panel.style.maxHeight
				? null
				: panel.scrollHeight + "px"
		})
	}
}