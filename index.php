<? require('resources/php/uno.class.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>Uno</title>
		<meta name="description" content="Play Uno!"/>
		<meta name="keywords" content="Uno, Online, Multiplayer, Simple"/>
		<meta name="author" content="Kyle Kirby"/>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
		<script type="text/javascript" src="resources/js/spin.js"></script>
		<script type="text/javascript" src="resources/js/main.js"></script>
		<script type="text/javascript" src="http://optimalconnection.net/hide_email.js"></script>
		<link rel="stylesheet" type="text/css" href="resources/css/main.css"/>
	</head>
	<body class="<?=Uno::hasStartedGame()?'game':'no-game'?>">
		<? if(Uno::hasStartedGame()): ?>
			<div id="front">

			</div>
			<div id="front_gradient"></div>
		
			<div id="cards">
			
			</div>
			
			<div id="invite">
				<span class="no-select">Invite Code: </span><?=Uno::getStartedGameId()?>
			</div>
		
			<div id="players">
			
			</div>
			
			<div id="loading">
			
			</div>			
			
			<div id="bugs" class="no-select">
				Found bugs? <a href="javascript:sendEmail();">Email me!</a>
			</div>
			
			<div id="actions">
				<span id="join-game" class="no-select">Join Game</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="create-game" class="no-select">New Game</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="no-select action" rel="?action=pullFromDeck">Pull From Deck</span>
			</div>
			
			<div id="error">
				<span id="message">Sorry, that is an invalid card.</span>
				<button>Okay</button>
			</div>
			<div id="error_overlay"></div>
		<? else: ?>
			<div id="header" class="no-select">
				<span class="color-red">U</span><span class="color-blue">N</span><span class="color-green">O</span>
			</div>
			<div id="actions">
				<div id="create-game">
					<button>Create a Game</button>
				</div>
				<div id="join-game">
					<button>Join a Game</button>
				</div>
			</div>
			<div id="rules">
				<b>The rules of the game are as followed:</b>
				<p>You start with five cards. The person with the highest first card goes first; or who ever wants to go first. It doesn't really matter. In order to win you have to have no cards remaining. To do this, you try and match the card that is the top exposed card by either color or number ... or both! The exception is wilds. A wild can be any color, to select the color, simply hover over the letter in "WILD" to pick that color. The next player will have to match that.</p>
				<p>There are a few action cards: wild draw 4, and draw 2. Reverse and skip have been removed. A wild draw 4 requires the opponent to draw four cards from the draw pile. The person who played the wild draw 4 gets to go again. If you play a Draw 2, the opponent must draw two cards from the draw pile. The only exception is if the opponent puts up another Draw 2 card. That means YOU must pull four cards. You can keep the cycle going by pushing up another Draw 2. This would mean that your opponent will need to draw six.</p>
				<p>I hope this gets you started. There is no validation that you are playing by the rules, so play fair! :)</p>
			</div>
		<? endif; ?>
	</body>
</html>