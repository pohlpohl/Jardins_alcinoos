var avgChart = $('#avg-stats');
var sumChart = $('#sum-stats');
var statsDate = $('.stats-date');
var date = new Date();

async function getSalesFromDate(dateSelected) {
	var dataJSON = await $.ajax({
		method: "POST",
		url: "ajax/get-sales.php",
		data: { "date": dateSelected },
	}).done(function (data) {});
	var dataArray = JSON.parse(dataJSON);
	resultArray = [
		[0, 0, 0, 0, 0, 0, 0],
		[0, 0, 0, 0, 0, 0, 0],
		[0, 0, 0, 0, 0, 0, 0],
		[0, 0, 0, 0, 0, 0, 0],
		[0, 0, 0, 0, 0, 0, 0],
	];
	dataArray[0].forEach(day => {
		resultArray[0][day['week_day']] = day['ca'];
		resultArray[1][day['week_day']] = day['chqs'];
	});
	dataArray[1].forEach(day => {
		resultArray[2][day['week_day']] = day['ca'];
		resultArray[3][day['week_day']] = day['chqs'];
		resultArray[4][day['week_day']] = day['nbr_clients'];
	});
	return resultArray;
}

statsDate.text("Semaine du " + date.toLocaleDateString("fr-FR", {weekday: "long", day: '2-digit', month: 'long', year: 'numeric'}) + " :");
Chart.defaults.global.defaultFontColor = 'white';
(async function () {
	var resultArray = await getSalesFromDate(date.toISOString());
	var avgBarChart = new Chart(avgChart, {
		type: 'bar',
		data: {
			labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
			datasets: [{
				barPercentage: 0.95,
				label: 'Moyennes achats',
				data: resultArray[0],
				backgroundColor: 'rgba(255, 99, 132, 0.2)',
				borderColor: 'rgba(255, 99, 132, 1)',
				borderWidth: 1
			}, {
				barPercentage: 0.95,
				label: 'Moyennes chèques',
				data: resultArray[1],
				backgroundColor: 'rgba(54, 162, 235, 0.2)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			}]
		}
	});
	var sumBarChart = new Chart(sumChart, {
		type: 'bar',
		data: {
			labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
			datasets: [{
				barPercentage: 0.95,
				label: 'Sommes achats',
				data: resultArray[2],
				backgroundColor: 'rgba(255, 99, 132, 0.2)',
				borderColor: 'rgba(255, 99, 132, 1)',
				borderWidth: 1
			}, {
				barPercentage: 0.95,
				label: 'Sommes chèques',
				data: resultArray[3],
				backgroundColor: 'rgba(54, 162, 235, 0.2)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			}, {
				barPercentage: 0.95,
				label: 'Nombre de clients',
				data: resultArray[4],
				backgroundColor: 'rgba(0, 153, 51, 0.2)',
				borderColor: 'rgba(0, 153, 51, 1)',
				borderWidth: 1
			}]
		}
	});
})();

$('#place-selected').on('change', function (e) {
	var valueSelected = this.value;
	selectPlace(valueSelected);
});
