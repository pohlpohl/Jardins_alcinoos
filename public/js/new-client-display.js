$('#place-selected').on('change', function() {
	if (this.value == -1) {
		$('#new-place')[0].parentNode.style.display = 'block';
		$('#new-place-short')[0].parentNode.style.display = 'block';
		$('#selecter')[0].className = 'input-field col s12 m4'
	} else {
		$('#new-place')[0].parentNode.style.display = 'none';
		$('#new-place-short')[0].parentNode.style.display = 'none';
		$('#selecter')[0].className = 'input-field col s12 m6'
	}
});
