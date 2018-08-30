if ($('input-message')) {
	(function() {
		$('input-message').addEventListener('input', function() {
			$('output-message1').value = $('input-message').value
			$('output-message2').value = $('input-message').value
		})
	})()
}