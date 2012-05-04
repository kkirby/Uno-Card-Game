<?php

class Uno_Game {
	protected $_id;
	protected $_deck;
	protected $_front;
	protected $_players = array();
	protected $_time;
	
	protected $_playerColors = array(
		'#FF0000',
		'#962929',
		'#96298A',
		'#E022CA',
		'#4B22E0',
		'#3D2C7D',
		'#2C6A7D',
		'#1AB8E8',
		'#1BB355',
		'#77B58F',
		'#75B535',
		'#B5B535',
		'#E8E81A'
	);
	
	protected $_playerColorsIndex = 0;
	
	public function __construct(){
		$this->_deck = new Uno_Deck($this,true);
		$this->_front = new Uno_Deck($this);
		shuffle($this->_playerColors);
	}
	
	public function setId($id){
		$this->_id = $id;
	}
	
	public function getId(){
		return $this->_id;
	}
	
	public function getDeck(){
		return $this->_deck;
	}
	
	public function setDeck(Uno_Deck $deck){
		$deck->setOwner($this);
		$this->_deck = $deck;
	}
	
	public function getFront(){
		return $this->_front;
	}
	
	public function getPlayer($id){
		return @$this->_players[$id];
	}
	
	public function addPlayer(Uno_Player $player){
		$this->_players[$player->getId()] = $player;
	}
	
	public function createPlayer(){
		$player = new Uno_Player(count($this->_players));
		$player->setColor($this->getNewPlayerColor());
		$this->addPlayer($player);
		return $player;
	}
	
	public function getPlayers(){
		return $this->_players;
	}
	
	public function setTime($time){
		$this->_time = $time;
	}
	
	public function getTime(){
		return $this->_time;
	}
	
	public function getNewPlayerColor(){
		return $this->_playerColors[(++$this->_playerColorsIndex) % (count($this->_playerColors))];
	}
	
}

?>