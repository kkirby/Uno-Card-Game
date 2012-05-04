<?php

class Uno_Front {
	protected $_cards = array();
	
	public function addCard(Uno_Card $card){
		array_unshift($card,$this->_cards);
	}
	
	public function getCards(){
		return $this->_cards;
	}
	
}

?>