/**
 * After page has been loaded, it will
 * remove the loading animation
 */
window.onload = () => {
	loading.classList.remove("loading")
	loadingTitle.innerHTML = ''
}

if (searchInput) {
	if (Number.isInteger(parseInt(searchInput.value)))
		searchInput.setAttribute('value', '')
}