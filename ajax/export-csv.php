<?PHP

namespace Chirp;

// Original PHP code by Chirp Internet: www.chirp.com.au
// Please acknowledge use of this code by including this header.

function cleanData(&$str)
{
	if ($str == 't') $str = 'TRUE';
	if ($str == 'f') $str = 'FALSE';
	if (preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
		$str = "'$str";
	}
	if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// filename for download
$filename = "export_achats_" . date('Ymd') . ".csv";

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");
// header("Content-Type: text/plain");

$out = fopen("php://output", 'w');

$flag = false;
while ($row = $listeAchats->fetch(\PDO::FETCH_ASSOC)) {
	if (!$flag) {
		// display field/column names as first row
		fputcsv($out, array_keys($row), ',', '"');
		$flag = true;
	}
	array_walk($row, __NAMESPACE__ . '\cleanData');
	fputcsv($out, array_values($row), ',', '"');
}

fclose($out);
exit;
