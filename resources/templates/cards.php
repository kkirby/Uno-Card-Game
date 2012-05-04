<ul>
	<? foreach(array_reverse($cards) as $card): ?>
		<li>
			<? $rel = '?action=pushToFront&id=' . $card->getId(); ?>
			<?= include('card.php') ?>
		</li>
	<? endforeach; ?>
</ul>