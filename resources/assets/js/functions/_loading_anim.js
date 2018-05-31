// After page has been loaded, it will
// remove the loading animation
window.onload = () => {
	$('loading').classList.remove("loading")
	$('loading-title').innerHTML = ''
}