<!-- jQuery -->
<script src="Ref/jquery-3.4.1.min.js"></script>
<!-- Materialize js -->
<script src="Ref/materialize/js/materialize.min.js"></script>
<!-- Chartjs -->
<script src="node_modules/chart.js/dist/Chart.min.js"></script>
<!-- Materialize initializations -->
<script>
	$(document).ready(function() {
		$('.dropdown-trigger').dropdown({
			constrainWidth: false,
			coverTrigger: false,
			alignment: 'right',
			hover: true
		});
		$('.modal').modal();
		$('select').formSelect();
		$('.datepicker').datepicker({
			defaultDate: 'Dec 19, 2019',
			setDefaultDate: true
		});
		$('.tabs').tabs();
	});
</script>
