<ul>
	<? foreach(array_slice($cards,0,7) as $card): ?>
		<?php
			$style = '';
			if($card->getPreviousOwner()){
				$style = 'border-bottom: solid 4px ' . $card->getPreviousOwner()->getOwner()->getColor();
			}
		?>
		<li style="<?=$style?>">
			<? $rel = '?null'; ?>
			<?= include('card.php') ?>
		</li>
	<? endforeach; ?>
</ul>