<?php
require_once('resources/php/uno.card.class.php');
require_once('resources/php/uno.deck.class.php');
require_once('resources/php/uno.game.class.php');
require_once('resources/php/uno.player.class.php');
session_start();
class Uno {
	public static $SESSION_ID = 'UnoGame';
	public static $GAMES_LOCATION = 'resources/games';
	public static $GAMES_LOCATION_SUFFIX = '.serialize';
	public static $DECK_LOCATION = 'resources/templates/deck.serialize';
	
	public static function startGame(){
		$id = uniqid();
		$game = new Uno_Game;
		$game->setId($id);
		$game->setDeck(self::getNewDeck());
		$game->getDeck()->shuffle();
		$game->getFront()->addCard($game->getDeck()->popCard());
		$player = $game->createPlayer();
		for($i = 0; $i < 5; $i++){
			$player->getDeck()->addCard($game->getDeck()->popCard());
		}
		$_SESSION[self::$SESSION_ID] = array('id'=>$id,'player'=>$player->getId());
		self::saveGame($game,$id);
	}
	
	public static function hasStartedGame(){
		return $_SESSION[self::$SESSION_ID] != null;
	}
	
	public static function getStartedGame(){
		if(self::hasStartedGame()){
			return self::getGameById(self::getStartedGameId());
		}
		else {
			return null;
		}
	}
	
	public static function getStartedGameId(){
		if(self::hasStartedGame()){
			return $_SESSION[self::$SESSION_ID]['id'];
		}
		else {
			return null;
		}
	}
	
	public static function getStartedGamePlayerId(){
		if(self::hasStartedGame()){
			return $_SESSION[self::$SESSION_ID]['player'];
		}
		else {
			return null;
		}
	}
	
	public static function getGameById($id){
		if(file_exists(self::$GAMES_LOCATION . '/' . $id . self::$GAMES_LOCATION_SUFFIX)){
			return unserialize(file_get_contents(self::$GAMES_LOCATION . '/' . $id . self::$GAMES_LOCATION_SUFFIX));
		}
		else {
			return false;
		}
	}
	
	public static function joinGame($id){
		$game = self::getGameById($id);
		if($game !== false){
			$player = $game->createPlayer();
			for($i = 0; $i < 5; $i++){
				$player->getDeck()->addCard($game->getDeck()->popCard());
			}
			$_SESSION[self::$SESSION_ID] = array('id'=>$id,'player'=>$player->getId());
			self::saveGame($game);
		}
	}
	
	public static function pullFromDeckToOwnDeck(){
		$game = self::getStartedGame();
		$card = $game->getDeck()->shiftCard();
		if(!$card){
			$game->setDeck(Uno::getNewDeck());
			$card = $game->getDeck()->shiftCard();
		}
		$game->getDeck()->shuffle();
		$game->getPlayer(
			self::getStartedGamePlayerId()
		)->getDeck()->addCard($card);
		self::saveGame($game);
	}
	
	public static function pushCardToFront($id,$color = null){
		$game = self::getStartedGame();
		$playerDeck = $game->getPlayer(
			self::getStartedGamePlayerId()
		)->getDeck();
		$card = $playerDeck->getCardById($id);
		if($card){
			$card->getOwner()->removeCard($card);
			$frontCard = current($game->getFront()->getCards());
			if(
				!$frontCard ||
				$frontCard->getColor() == $card->getColor() ||
				$frontCard->getLabel() == $card->getLabel() ||
				$card->getIsWild() === true ||
				($frontCard->getIsWild() === true && $frontCard->getColor() == null)
			){
				if($color && $card->getIsWild() === true){
					$card->setColor($color);
				}
				$game->getFront()->addCard($card);
				self::saveGame($game);
			}
			else {
				return 'Not a valid card.';
			}
		}
	}
	
	public static function saveGame(Uno_Game $game){
		$game->setTime(time());
		file_put_contents(self::$GAMES_LOCATION . '/' . $game->getId() . self::$GAMES_LOCATION_SUFFIX,serialize($game));
	}
	
	public static function getUpdateIdForGame($id){
		return filemtime(self::$GAMES_LOCATION . '/' . $id . self::$GAMES_LOCATION_SUFFIX);
	}
	
	public static function getNewDeck(){
		return unserialize(file_get_contents(self::$DECK_LOCATION));
	}
	
	public static function debugGame($game){
		echo 'Total Cards: ' . $game->getDeck()->getCount() . '<br/>';
		foreach(array_slice($game->getDeck()->getCards(),0,5) as $card){
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Id: " . $card->getId() . '<br/>';
			echo "&nbsp;&nbsp;&nbsp;Color: " . $card->getColor() . '<br/>';
			echo "&nbsp;&nbsp;&nbsp;Label: " . $card->getLabel() . '<br/>';
			echo "&nbsp;&nbsp;&nbsp;Wild: " . ($card->getIsWild() ? 'true' : 'false') . '<br/><br/>';
		}
		
		echo "Front: <br/>";
		foreach(array_slice($game->getFront()->getCards(),0,5) as $card){
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Id: " . $card->getId() . '<br/>';
			echo "&nbsp;&nbsp;&nbsp;Color: " . $card->getColor() . '<br/>';
			echo "&nbsp;&nbsp;&nbsp;Label: " . $card->getLabel() . '<br/>';
			echo "&nbsp;&nbsp;&nbsp;Wild: " . ($card->getIsWild() ? 'true' : 'false') . '<br/><br/>';
		}
		echo "<br/>";

		echo 'Total Players: ' . count($game->getPlayers()) . '<br/>';
		foreach($game->getPlayers() as $player){
			echo "&nbsp;&nbsp;&nbsp;Id: " . $player->getId() . "<br/>";
			echo "&nbsp;&nbsp;&nbsp;Total Cards: " . $player->getDeck()->getCount() . "<br/><br/>";
			foreach(array_slice($player->getDeck()->getCards(),0,5) as $card){
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Id: " . $card->getId() . '<br/>';
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Color: " . $card->getColor() . '<br/>';
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Label: " . $card->getLabel() . '<br/>';
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Wild: " . ($card->getIsWild() ? 'true' : 'false') . '<br/><br/>';
			}
		}
		echo '<hr/>';
	}
}

?>