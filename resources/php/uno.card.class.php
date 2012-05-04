<?php

class Uno_Card {
	protected $_id;
	protected $_color;
	protected $_isWild = false;
	protected $_label;
	protected $_owner;
	protected $_previousOwner;
	
	public function setColor($color){
		$this->_color = $color;
	}
	
	public function setIsWild($isWild){
		$this->_isWild = $isWild;
	}
	
	public function setLabel($label){
		$this->_label = $label;
	}
	
	public function getColor(){
		return $this->_color;
	}
	
	public function getIsWild(){
		return $this->_isWild;
	}
	
	public function getLabel(){
		return $this->_label;
	}
	
	///
	
	public function getOwner(){
		return $this->_owner;
	}
	
	public function setOwner(Uno_Deck $owner){
		if($this->_owner){
			$this->_previousOwner = $this->_owner;
		}
		$this->_owner = $owner;
	}
	
	public function getPreviousOwner(){
		return $this->_previousOwner;
	}
	
	public function setId($id){
		$this->_id = $id;
	}
	
	public function getId(){
		return $this->_id;
	}
	
	public function clearOwner(){
		$this->_owner = null;
	}
	
	public function compareCard(Uno_Card $card){
		$compareableFields = array('getColor','getIsWild','getLabel','getOwner');
		$matchedFields = array();
		$nullFields = array();
		foreach($compareableFields as $field){
			$returnValue = $card->$field();
			if($returnValue != null && $returnValue == $this->$field()){
				$matchedFields[] = $field;
			}
			else if($returnValue == null){
				$nullFields[] = $field;
			}
		}
		return array(
			count($matchedFields) + count($nullFields) == count($compareableFields),
			$matchedFields,
			$nullFields
		);
	}

}

?>