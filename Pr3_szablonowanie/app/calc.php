<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';
//załaduj Smarty
require_once _ROOT_PATH.'/smarty/libs/Smarty.class.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.
//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany

// 1. pobranie parametrów
function getParams(&$form){
	$form['kw'] = isset($_REQUEST['kw']) ? $_REQUEST['kw'] : null;
	$form['ok'] = isset($_REQUEST['ok']) ? $_REQUEST['ok'] : null;
	$form['opr'] = isset($_REQUEST['opr']) ? $_REQUEST['opr'] : null;

}

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$form,&$infos,&$msgs,&$hide_intro){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($form['kw']) && isset($form['ok']) && isset($form['opr']) ))	return false;
		// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
		// teraz zakładamy, ze nie jest to błąd. Po prostu nie wykonamy obliczeń
	$hide_intro = true;

	$infos [] = 'Przekazano parametry.';
	
	if ( $form['kw'] == "") $msgs [] = 'Nie podano kwoty okredytowania';
	if ( $form['ok'] == "") $msgs [] = 'Nie podano okres okredytowania';
	if ( $form['opr'] == "") $msgs [] = 'Nie podano procent okredytowania';
	
	//nie ma sensu walidować dalej gdy brak parametrów
	if ( count($msgs)==0 ) {
		// sprawdzenie, czy $kw, $ok i $opr są liczbami całkowitymi
		if (! is_numeric( $form['kw'] )) $msgs [] = 'Kwota nie jest liczbą';
		if (! is_numeric( $form['ok'] )) $msgs [] = 'Okres okredytowania nie jest liczbą';
		if (! is_numeric( $form['opr'] )) $msgs [] = 'Oprocentowanie nie jest liczbą';
		if ($form['ok'] == 0) $msgs[] = 'Okres okredytowania nie może być zerem';
		
		if ($form['kw'] < 0 ) $msgs [] = 'Kwota nie może być ujemną';
		if ($form['ok'] < 0 ) $msgs [] = 'Okres okredytowania nie może być ujemnym';
		if ($form['opr'] < 0 ) $msgs [] = 'Okres okredytowania nie może być ujemnym';
	}
	if (count($msgs)>0) return false;
	else return true;
	}


// 3. wykonaj zadanie jeśli wszystko w porządku

function process(&$form,&$infos,&$msgs,&$result){
	
	//konwersja parametrów na int
	$form['kw'] = floatval($form['kw']);
	$form['ok'] = intval($form['ok']);
	$form['opr'] = floatval($form['opr']);

	$n = ($form['opr'] / 100) * $form['ok'];
	$im = $form['ok'] * 12;

    //obliczenie miesięcznej płatności
	if ($form['opr'] == 0) {
        $result = $form['kw'] / ($form['ok'] * 12);
    } else {
        $result = ($form['kw'] * $n) / $im + ($form['kw'] / $im) ;
    }
	$result = number_format($result, 2, '.', '');

}
//inicjacja zmiennych
$form = null;
$infos = array();
$messages = array();
$result = null;
$hide_intro = false;
	
getParams($form);
if ( validate($form,$infos,$messages,$hide_intro) ){
	process($form,$infos,$messages,$result);
}

// 4. Przygotowanie danych dla szablonu

$smarty = new Smarty\Smarty();

$smarty->assign('app_url',_APP_URL);
$smarty->assign('root_path',_ROOT_PATH);
$smarty->assign('page_title','Przykład 04');
$smarty->assign('page_description','Profesjonalne szablonowanie oparte na bibliotece Smarty');
$smarty->assign('page_header','Szablony Smarty');

$smarty->assign('hide_intro',$hide_intro);

//pozostałe zmienne niekoniecznie muszą istnieć, dlatego sprawdzamy aby nie otrzymać ostrzeżenia
$smarty->assign('form',$form);
$smarty->assign('result',$result);
$smarty->assign('messages',$messages);
$smarty->assign('infos',$infos);

// 5. Wywołanie szablonu
$smarty->display(_ROOT_PATH.'/app/calc.html');