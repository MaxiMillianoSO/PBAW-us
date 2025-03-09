<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator</title>
</head>
<body>

<form action="<?php print(_APP_URL);?>/app/calc.php" method="get">
	<label for="id_op">Operacja: </label>
	<select name="op">
		<option value="plat_jed" <?php if (isset($operation) && $operation == 'plat_jed') echo 'selected'; ?>>Plata jednorazowa</option>
        <option value="plat_mies" <?php if (isset($operation) && $operation == 'plat_mies') echo 'selected'; ?>>Plata miesięczna</option>
	</select><br />
	<label for="id_x">Rata Okredytowania: </label>
	<input id="id_x" type="text" name="kw" value="<?php isset($kw)?print($kw):""; ?>" /><br />
	<label for="id_y">Okres czasu (lata): </label>
	<input id="id_y" type="text" name="ok" value="<?php isset($ok)?print($ok):""; ?>" /><br />
	<label for="id_z">Oprocentowanie (%): </label>
	<input id="id_z" type="text" name="opr" value="<?php isset($opr)?print($opr):""; ?>" /><br />
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
<?php echo 'Wynik: '.number_format($result, 2, '.', ''); ?>
</div>
<?php } ?>

</body>
</html>