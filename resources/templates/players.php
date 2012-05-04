<ul>
	<? foreach($players as $player): ?>
	<? $me = $player->getId() == Uno::getStartedGamePlayerId(); ?>
	<? $cards = $player->getDeck()->getCount() . ' card' . ($player->getDeck()->getCount() > 1 || $player->getDeck()->getCount() == 0 ? 's' : '') ?>
	<li style="color: <?= $player->getColor() ?>" class="no-select">
		<? if($me): ?>
			You have <?=$cards?>
		<? else: ?>
	 	Player <?= $player->getId()+1 ?> has <?= $cards ?>
		<? endif; ?>
	</li>
	<? endforeach; ?>
</ul>