<?php
require_once('resources/php/uno.class.php');
$action = isset($_GET['action']) ? $_GET['action'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$color = isset($_GET['color']) ? $_GET['color'] : null;

if($action == 'createGame'){
	Uno::startGame();
}
else if($action == 'joinGame' && $id !== null){
	Uno::joinGame($id);
}
else if($action == 'pullFromDeck'){
	Uno::pullFromDeckToOwnDeck();
}
else if($action == 'pushToFront' && $id !== null){
	$error = Uno::pushCardToFront($id,$color);
}
else if($action == 'debugGame'){
	if($id){
		$game = Uno::getGameById($id);
	}
	else {
		$game = Uno::getStartedGame();
	}
	Uno::debugGame($game);
}
else if($action == 'debugSession'){
	echo '<pre>';
	print_r($_SESSION);
	echo '</pre>';
}
include('update.php');
?>