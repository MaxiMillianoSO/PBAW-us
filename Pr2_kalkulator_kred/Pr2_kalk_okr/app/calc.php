<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.
//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';

// 1. pobranie parametrów
function getParams(&$kw,&$ok,&$opr){
	$kw = isset($_REQUEST['kw']) ? $_REQUEST['kw'] : null;
	$ok = isset($_REQUEST['ok']) ? $_REQUEST['ok'] : null;
	$opr = isset($_REQUEST['opr']) ? $_REQUEST['opr'] : null;	
}

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$kw,&$ok,&$opr,&$messages){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($kw) && isset($ok) && isset($opr))) {
		// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
		// teraz zakładamy, ze nie jest to błąd. Po prostu nie wykonamy obliczeń
		return false;
	}

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($kw) && isset($ok) && isset($opr) )) {
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
if (count ( $messages ) != 0) return false;
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $kw )) {
		$messages [] = 'Kwota nie jest liczbą';
	}
	if (! is_numeric( $ok )) {
		$messages [] = 'Okres okredytowania nie jest liczbą';
	}	
	if (!is_numeric($opr)) {
    $messages[] = 'Oprocentowanie nie jest liczbą';
	}
	if ($kw < 0 ) {
		$messages [] = 'Kwota nie może być ujemną';
	}
	if ($ok < 0) {
		$messages [] = 'Okres okredytowania nie może być ujemnym';
	}	
	if ($opr < 0) {
    $messages[] = 'Oprocentowanie nie może być ujemnym';
	}
	if (count ( $messages ) != 0) return false;
	else return true;
}

// 3. wykonaj zadanie jeśli wszystko w porządku

function process(&$kw,&$ok,&$opr,&$messages,&$result){
	global $role;
	
	//konwersja parametrów na int
	$kw = floatval($kw);
	$ok = intval($ok);
	$opr = floatval($opr);

	$n = ($opr / 100) * $ok;
	$im = $ok * 12;

    //obliczenie miesięcznej płatności
	if ($role != 'admin' && ($kw > 100000 || $opr < 10)){
		$messages [] = 'Tylko administrator może mieć kwotę wyższą za 100000 lub oprocentowanie mniejsze za 10% !';
} else {
	if ($opr == 0) {
        $result = $kw / ($ok * 12);
    } else {
        $result = ($kw * $n) / $im + ($kw / $im) ;
    }
}
}
//definicja zmiennych kontrolera
$kw = null;
$ok = null;
$opr = null;
$result = null;
$messages = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($kw,$ok,$opr);
if ( validate($kw,$ok,$opr,$messages) ) { // gdy brak błędów
	process($kw,$ok,$opr,$messages,$result);
}

// 4. Wywołanie widoku z przekazaniem zmiennych
include 'calc_view.php';