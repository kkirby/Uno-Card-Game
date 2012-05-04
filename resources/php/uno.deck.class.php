<?php

class Uno_Deck {
	protected $_cards = array();
	protected $_owner;
	
	public static
		$CARD_LOCATION_TOP = 0,
		$CARD_LOCATION_BOTTOM = 1;
		
	public function __construct($owner){
		$this->setOwner($owner);
	}
	
	public function setOwner($owner){
		$this->_owner = $owner;
	}
	
	public function getOwner(){
		return $this->_owner;
	}
	
	public function addCard(Uno_Card $card,$location = false){
		if(!$locaton){
			$location = Uno_Deck::$CARD_LOCATION_TOP;
		}
		if($location == Uno_Deck::$CARD_LOCATION_TOP){
			$card->setOwner($this);
			array_unshift($this->_cards,$card);
		}
		else if($location == Uno_Deck::$CARD_LOCATION_BOTTOM){
			$card->setOwner($this);
			array_push($this->_cards,$card);
		}
	}
	
	public function popCard(){
		$card = array_pop($this->_cards);
		$card->clearOwner();
		return $card;
	}
	
	public function shiftCard(){
		$card = array_shift($this->_cards);
		if($card){
			$card->clearOwner();
			return $card;
		}
		else {
			return false;
		}
	}
	
	public function getCount(){
		return count($this->_cards);
	}

	public function getCards(){
		return $this->_cards;
	}
	
	public function shuffle(){
		shuffle($this->_cards);
	}
	
	public function removeCard(Uno_Card $card){
		$key = array_search($card,$this->_cards,true);
		if($key !== null){
			array_splice($this->_cards,$key,1);
		}
	}
	
	public function getCardById($id){
		foreach($this->_cards as $card){
			if($card->getId() == $id){
				return $card;
			}
		}
		return null;
	}
	
	public function findCards(Uno_Card $template){
		$returnCards = array();
		foreach($this->_cards as $card){
			$compare = $card->compareCard($template);
			if($compare[0] == true){
				$returnCards[] = $card;
			}
		}
		return $returnCards;
	}

}

?>