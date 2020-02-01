var client = null;

function getClientInfo(id) {
	$.ajax({
		method: "POST",
		url: "ajax/get-client.php",
		data: { "id": id },
	}).done(function (data) {
		client = JSON.parse(data);
		$('#notes-client').html(
			'<h6>' + client['nom_prenom'] + '</h6>' +
			'<p>' +
				client['nbr_adultes'] + ' adultes, ' +
				client['nbr_enfants'] + ' enfants et ' +
				client['nbr_bebe'] + ' bébés' +
			'<br>' +
			'Lieu de provenance : ' + client['nom_lieu'] + '<br>' +
			'Balance : ' + client['balance'] + '</p>'
		);
	});
}

$('#client-selected').on('change', function() {
	$('#client-selected-help').text('');
	client = getClientInfo(this.value);
});

function calculateNewBalance() {
	balance = client['balance'];
	var diff = $('#montant').val() - $('#prix').val();
	var result = Number(balance) + Number(diff);
	$('#new-balance').text('La nouvelle balance sera de ' + result);
}

$('#montant').change(calculateNewBalance);

$('#prix').change(function(){
	calculateNewBalance();
	if (client['nom_lieu'] == 'Palais de la femme')
		$('#montant-chq').val(this.value);
	$('#montant').val(this.value);
});

$('#reset-form').click(function() {
	location.reload();
});

$('#date-achat').change(function() {
	$('#date-achat-help').text('');
});

// Form check before validation
$('#buy-form').submit(function(e) {
	$('#client-selected-help').text('');
	$('#date-achat-help').text('');
	$('#type-achat-help').text('');
	if (!$('#client-selected').val()) {
		e.preventDefault();
		$('#client-selected-help').text('Veuillez selectionner un client');
	}
	if ($('#date-achat').val() == '') {
		e.preventDefault();
		$('#date-achat-help').text('Veuillez selectionner une date d\'achat');
	}
});
