<?php

require_once $conf->root_path.'/lib/smarty/Smarty.class.php';
require_once $conf->root_path.'/lib/Messages.class.php';
require_once $conf->root_path.'/app/CalcForm.class.php';
require_once $conf->root_path.'/app/CalcResult.class.php';

class CalcCtrl {

	private $msgs;   //wiadomości dla widoku
	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku
	private $hide_intro; //zmienna informująca o tym czy schować intro

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->msgs = new Messages();
		$this->form = new CalcForm();
		$this->result = new CalcResult();
		$this->hide_intro = false;
	}

// 1. pobranie parametrów
	public function getParams(){
	$this->form->kw = isset($_REQUEST['kw']) ? $_REQUEST['kw'] : null;
	$this->form->ok	= isset($_REQUEST['ok']) ? $_REQUEST['ok'] : null;
	$this->form->opr = isset($_REQUEST['opr']) ? $_REQUEST['opr'] : null;

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
	if (! $this->msgs->isError()) {
		// sprawdzenie, czy $kw, $ok i $opr są liczbami całkowitymi
		if (! is_numeric( $this->form->kw )){
			$this->msgs->addError('Kwota nie jest liczbą');
		}
		if (! is_numeric( $this->form->ok )) {
			$this->msgs->addError('Okres okredytowania nie jest liczbą');
		}
		if (! is_numeric( $this->form->opr )) {
			$this->msgs->addError('Oprocentowanie nie jest liczbą');
		}
		if ($this->form->ok == 0) {
			$this->msgs->addError('Okres okredytowania nie może być zerem');
		}
		
		if ($this->form->kw < 0 ) {
			$this->msgs->addError('Kwota nie może być ujemną');
		}
		if ($this->form->ok < 0 ) {
			$this->msgs->addError('Okres okredytowania nie może być ujemnym');
		}
		if ($this->form->opr < 0 ) {
			$this->msgs->addError('Okres okredytowania nie może być ujemnym');
		}
	}
	return ! $this->msgs->isError();
	}


// 3. wykonaj zadanie jeśli wszystko w porządku

public function process(){
	$this->getparams();
	
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
		global $conf;

		$smarty = new Smarty();
		$smarty->assign('conf',$conf);

		$smarty->assign('page_title','Przykład 05');
		$smarty->assign('page_description','Obiektowość. Funkcjonalność aplikacji zamknięta w metodach różnych obiektów. Pełen model MVC.');
		$smarty->assign('page_header','Obiekty w PHP');
				
		$smarty->assign('hide_intro',$this->hide_intro);
		
		$smarty->assign('msgs',$this->msgs);
		$smarty->assign('form',$this->form);
		$smarty->assign('res',$this->result);

		$smarty->display($conf->root_path.'/app/calc.html');
	}
}