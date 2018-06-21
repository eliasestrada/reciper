<script>
	document.addEventListener('DOMContentLoaded', function() {
		let elems = document.querySelectorAll('.fixed-action-btn');
		M.FloatingActionButton.init(elems, {
			direction: 'top',
			hoverEnabled: false
		});
	});
</script>