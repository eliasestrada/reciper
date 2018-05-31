/**
 * @param {string} input
 * @returns {boolean}
 */
function inputValueIsInteger(input) {
	if (Number.isInteger(parseInt($(input).value))) {
		return true
	}
	return false
}

/**
 * @param {string} input 
 */
function setInputValueToEmpty(input) {
	if (input = $(input)) {
		input.setAttribute('value', '')
	}
}

// Run funtion
if (inputValueIsInteger('search-input')) {
	setInputValueToEmpty('search-input')
}