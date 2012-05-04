<?php

class Uno_Player {
	protected $_id;
	protected $_deck;
	protected $_color;
	
	public function __construct($id){
		$this->_id = $id;
		$this->_deck = new Uno_Deck($this);
	}
	
	public function getId(){
		return $this->_id;
	}
	
	public function getDeck(){
		return $this->_deck;
	}
	
	public function getColor(){
		return $this->_color;
	}
	
	public function setColor($color){
		$this->_color = $color;
	}
}

?>