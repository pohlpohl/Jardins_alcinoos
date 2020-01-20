$('#pseudo-display a').click(function (e) {
	$('#pseudo-display').css("display", "none");
	$("#pseudo-modify").css("display", "block");
	$("#pseudo").focus();
});

$("#pseudo-modify .red").click(function (e) {
	$('#pseudo-display').css("display", "block");
	$("#pseudo-modify").css("display", "none");
});

$('#email-display a').click(function (e) {
	$('#email-display').css("display", "none");
	$("#email-modify").css("display", "block");
	$("#email").focus();
});

$("#email-modify .red").click(function (e) {
	$('#email-display').css("display", "block");
	$("#email-modify").css("display", "none");
});

$('#password-display').click(function (e) {
	$('#password-display').css("display", "none");
	$("#password-modify").css("display", "block");
	$("#old-password").focus();
});

$("#password-modify .red").click(function (e) {
	$('#password-display').css("display", "inline-block");
	$("#password-modify").css("display", "none");
});

$("#pseudo-modify").submit(function (e) {
	var regex = /^([a-zA-Z_\-àéèëêïîâ\s]([0-9])*){3,64}$/;
	if (!regex.test($("#pseudo").val())) {
		e.preventDefault();
		$("#pseudo-error").text('Le nouveau pseudo est invalide.');
	} else {
		var rawFormElement = this;
		e.preventDefault();
		$.ajax({
			method: "POST",
			url: "ajax/already-exists.php",
			data: { "pseudo": $("#pseudo").val() },
		}).done(function (data) {
			$("#pseudo-error").text('');
			if (data == 0) {
				$("#pseudo-error").text('Could not read data.');
			} else if (data == 1) {
				// no match, everything's good
				$("#pseudo-error").text('');
				rawFormElement.submit();
			} else if (data == 2) {
				$("#pseudo-error").text('Ce pseudo est déjà utilisé.');
			} else {
				$("#pseudo-error").text('Output problem : ' + data);
			}
		});
	}
});

$("#email-modify").submit(function (e) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!regex.test($("#email").val())) {
		$("#email-error").text('Nouvel email invalide.');
		e.preventDefault();
	} else {
		var rawFormElement = this;
		e.preventDefault();
		$.ajax({
			method: "POST",
			url: "ajax/already-exists.php",
			data: { "email": $("#email").val() },
		}).done(function (data) {
			$("#email-error").text('');
			if (data == 0) {
				$("#email-error").text('Could not read data.');
			} else if (data == 1) {
				// no match, everything's good
				$("#email-error").text('');
				rawFormElement.submit();
			} else if (data == 3) {
				$("#email-error").text('Cet email est déjà utilisé.');
			} else {
				$("#email-error").text('Output problem : ' + data);
			}
		});
	}
});

$("#password-modify").submit(function (e) {
	var rawFormElement = this;
	e.preventDefault();
	$.ajax({
		method: "POST",
		url: "ajax/valid-login.php",
		data: { "authentifier": $("#user-pseudo").text(), "password": $("#old-password").val() },
	}).done(function (data) {
		$("#password-error").text('');
		if (data == 0) {
			$("#password-error").text('Could not read data.');
		} else if (data == 1) {
			// good password
			if ($("#new-password").val().length <= 5) {
				$("#password-error").text('Mot de passe trop court.');
			} else if ($("#new-password").val() != $("#confirm").val()) {
				$("#password-error").text('La confirmation ne correspond pas au nouveau mot de passe.');
			} else {
				$("#password-error").text('');
				rawFormElement.submit();
			}
		} else if (data == 2) {
			$("#password-error").text('User authentifier error.');
		} else if (data == 3) {
			$("#password-error").text('Mauvais mot de passe.');
		} else {
			$("#password-error").text('Output problem : ' + data);
		}
	});
});

$('#image-form button').click(function (e) {
	if($('#image-form input')[0].value == "") {
		$("#image-error").text("Veuillez selectionner une image.");
		e.preventDefault();
	}
});
