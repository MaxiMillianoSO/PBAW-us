<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$kw = $_REQUEST ['kw'];
$ok = $_REQUEST ['ok'];
$opr = $_REQUEST ['opr'];
$operation = $_REQUEST ['op'];

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($kw) && isset($ok) && isset($opr) && isset($operation))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $kw == "") {
	$messages [] = 'Nie podano kwoty okredytowania';
}
if ( $ok == "") {
	$messages [] = 'Nie podano okres okredytowania';
}
if ( $opr == "") {
	$messages [] = 'Nie podano procent okredytowania';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $kw )) {
		$messages [] = 'Kwota nie jest liczbą';
	}
	if (! is_numeric( $ok )) {
		$messages [] = 'Okres okredytowania nie jest liczbą';
	}	
	if (!is_numeric($opr)) {
    $messages[] = 'Procent okredytowania nie jest liczbą';
	}
}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
	//konwersja parametrów na int
	$kw = floatval($kw);
	$ok = intval($ok);
	$opr = floatval($opr);
	
	//wykonanie operacji
	switch ($operation) {
		case 'plat_jed' :
			$result = $kw * pow((1 + $opr / (12 * 100)), 12 * $ok);
			break;
		case 'plat_mies' :
			if ($opr == 0) {
				$result = $kw; // bez odsetek
			} else {
				$result = $kw * ((pow((1 + $opr / (12 * 100)), 12 * $ok) - 1) / ($opr / (12 * 100)));
			}
			break;
		default :
			$result = $kw * pow((1 + $opr / (12 * 100)), 12 * $ok);
			break;
	}
}

// 4. Wywołanie widoku z przekazaniem zmiennych
include 'calc_view.php';