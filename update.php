<?php
require_once('resources/php/uno.class.php');
$updateId = isset($_GET['updateId']) ? $_GET['updateId'] : null;

if(Uno::getUpdateIdForGame(Uno::getStartedGameId()) == $updateId){
	$return = array(
		'update'=>false
	);
	if(isset($error)){
		$return['error'] = $error;
	}
	echo JSON_Encode($return);
}
else {
	$game = Uno::getStartedGame();
	$return = array(
		'update' => true,
		'updateId' => Uno::getUpdateIdForGame(Uno::getStartedGameId()),
		'html' => array(
			'front' => '',
			'playerCards' => '',
			'players' => ''
		)
	);
	
	if(isset($error)){
		$return['error'] = $error;
	}
	
	/*foreach($game->getPlayers() as $player){
		$return['players'][$player->getId()] = array(
			'cardCount' => $player->getDeck()->getCount()
		);
	}*/
	
	/*foreach($game->getPlayer(Uno::getStartedGamePlayerId())->getDeck()->getCards() as $card){
		$return['playerCards'][] = array(
			'label' => $card->getLabel(),
			'color' => $card->getColor(),
			'isWild' => $card->getIsWild()
		);
	}*/
	
	/*foreach($game->getFront()->getCards() as $card){
		$return['front'][] = array(
			'label' => $card->getLabel(),
			'color' => $card->getColor(),
			'isWild' => $card->getIsWild()
		);
	}*/
	
	ob_start();
		$cards = $game->getFront()->getCards();
		include('resources/templates/front.php');
	$html = ob_get_clean();
	$return['html']['front'] = $html;
	
	ob_start();
		$cards = $game->getPlayer(Uno::getStartedGamePlayerId())->getDeck()->getCards();
		include('resources/templates/cards.php');
	$html = ob_get_clean();
	$return['html']['playerCards'] = $html;
	
	ob_start();
		$players = $game->getPlayers();
		include('resources/templates/players.php');
	$html = ob_get_clean();
	$return['html']['players'] = $html;
	
	echo JSON_Encode($return);
}

?>