<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator</title>
</head>
<body>

<form action="<?php print(_APP_URL);?>/app/calc.php" method="get">
	<label for="id_kw">Kwota kredytu: </label>
    <input id="id_kw" type="text" name="kw" value="<?php isset($kw)?print($kw):""; ?>" /><br />
    <label for="id_ok">Okres kredytowania (w latach): </label>
    <input id="id_ok" type="text" name="ok" value="<?php isset($ok)?print($ok):""; ?>" /><br />
    <label for="id_opr">Oprocentowanie (% rocznie): </label>
    <input id="id_opr" type="text" name="opr" value="<?php isset($opr)?print($opr):""; ?>" /><br />
    <input type="submit" value="Oblicz" />
</form>	

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php echo 'Suma oplaty miesięcznie: '.number_format($result, 2, '.', ''); ?>
</div>
<?php } ?>

</body>
</html>
