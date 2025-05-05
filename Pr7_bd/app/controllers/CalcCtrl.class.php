<?php

namespace app\controllers;

//zamieniamy zatem 'require' na 'use' wskazując jedynie przestrzeń nazw, w której znajduje się klasa
use app\forms\CalcForm;
use app\transfer\CalcResult;

class CalcCtrl {

	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->form = new CalcForm();
		$this->result = new CalcResult();
	}

// 1. pobranie parametrów
	public function getParams(){
	$this->form->kw = getFromRequest('kw');
	$this->form->ok	= getFromRequest('ok');
	$this->form->opr = getFromRequest('opr');

}

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku
	public function validate(){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($this->form->kw) && isset($this->form->ok) && isset($this->form->opr)))	{
		return false;
	}	
	if ( $this->form->kw == "") {getMessages()->addError('Nie podano kwoty okredytowania'); }
	if ( $this->form->ok == "") {getMessages()->addError('Nie podano okres okredytowania'); }
	if ( $this->form->opr == ""){getMessages()->addError('Nie podano procent okredytowania'); }
	
	//nie ma sensu walidować dalej gdy brak parametrów
	if (! getMessages()->isError()) {
		// sprawdzenie, czy $kw, $ok i $opr są liczbami całkowitymi
		if (! is_numeric( $this->form->kw )){
			getMessages()->addError('Kwota nie jest liczbą');
		}
		if (! is_numeric( $this->form->ok )) {
			getMessages()->addError('Okres okredytowania nie jest liczbą');
		}
		if (! is_numeric( $this->form->opr )) {
			getMessages()->addError('Oprocentowanie nie jest liczbą');
		}
		if ($this->form->ok == 0) {
			getMessages()->addError('Okres okredytowania nie może być zerem');
		}
		
		if ($this->form->kw < 0 ) {
			getMessages()->addError('Kwota nie może być ujemną');
		}
		if ($this->form->ok < 0 ) {
			getMessages()->addError('Okres okredytowania nie może być ujemnym');
		}
		if ($this->form->opr < 0 ) {
			getMessages()->addError('Okres okredytowania nie może być ujemnym');
		}
	}
	return ! getMessages()->isError();
	}


// 3. wykonaj zadanie jeśli wszystko w porządku

public function action_calcCompute(){
	$this->getparams();
	
	if ($this->validate()) {
	
	//konwersja parametrów na int
	$this->form->kw = floatval($this->form->kw);
	$this->form->ok = intval($this->form->ok);
	$this->form->opr = floatval($this->form->opr);

	$n = ($this->form->opr / 100) * $this->form->ok;
	$im = $this->form->ok * 12;

    //obliczenie miesięcznej płatności
if (!inRole('admin') && ($this->form->kw > 100000 || $this->form->opr < 10)){
		getMessages()->addError('Tylko administrator może mieć kwotę wyższą za 100000 lub oprocentowanie mniejsze za 10% !');
} else {
	if ($this->form->opr == 0) {
         $this->result->result = $this->form->kw / ($this->form->ok * 12);
    } else {
        $this->result->result = ($this->form->kw * $n) / $im + ($this->form->kw / $im) ;
    }
	$this->result->result = number_format($this->result->result, 2, '.', '');
}
}
$this->generateView();
}

public function action_calcShow(){
		getMessages()->addInfo('Witaj w kalkulatorze okredytowania');
		$this->generateView();
	}


// 4. Przygotowanie danych dla szablonu
public function generateView(){

		getSmarty()->assign('user',unserialize($_SESSION['user']));
				
		getSmarty()->assign('page_title','Super kalkulator - role');

		getSmarty()->assign('form',$this->form);
		getSmarty()->assign('res',$this->result);
		
		getSmarty()->display('calc.tpl');
	}
}