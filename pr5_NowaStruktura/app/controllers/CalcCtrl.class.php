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
	if ( ! (isset($this->form->kw) && isset($this->form->ok) && isset($this->form->opr) ))	{
		return false;
	} else {
	$this->hide_intro = true;
	}

	$infos [] = 'Przekazano parametry.';
	
	if ( $this->form->kw == "") {$this->msgs->addError('Nie podano kwoty okredytowania'); }
	if ( $this->form->ok == "") {$this->msgs->addError('Nie podano okres okredytowania'); }
	if ( $this->form->opr == ""){$this->msgs->addError('Nie podano procent okredytowania'); }
	
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
			getMessages()->addError('Okres oprocentowania nie może być ujemnym');
		}
	}
	return ! getMessages()->isError();
	}


// 3. wykonaj zadanie jeśli wszystko w porządku

public function process(){
	$this->getParams();
	
	if ($this->validate()) {
	
	//konwersja parametrów na int
	$this->form->kw = floatval($this->form->kw);
	$this->form->ok = intval($this->form->ok);
	$this->form->opr = floatval($this->form->opr);

	$n = ($this->form->opr / 100) * $this->form->ok;
	$im = $this->form->ok * 12;

    //obliczenie miesięcznej płatności
	if ($this->form->opr == 0) {
        $this->result->result = $this->form->kw / ($this->form->ok * 12);
    } else {
        $this->result->result = ($this->form->kw * $n) / $im + ($this->form->kw / $im) ;
    }
	$this->result->result = number_format($this->result->result, 2, '.', '');

}
$this->generateView();
}


// 4. Przygotowanie danych dla szablonu
		public function generateView(){
		//nie trzeba już tworzyć Smarty i przekazywać mu konfiguracji i messages
		// - wszystko załatwia funkcja getSmarty()
		
		getSmarty()->assign('page_title','Przykład 06b');
		getSmarty()->assign('page_description','Kolejne rozszerzenia dla aplikacja z jednym "punktem wejścia". Do nowej struktury dołożono automatyczne ładowanie klas wykorzystując w strukturze przestrzenie nazw.');
		getSmarty()->assign('page_header','Kontroler główny');
					
		getSmarty()->assign('form',$this->form);
		getSmarty()->assign('res',$this->result);
		
		getSmarty()->display('calc.tpl'); // już nie podajemy pełnej ścieżki - foldery widoków są zdefiniowane przy ładowaniu Smarty
	}
}