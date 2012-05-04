<?php
$rel = @$rel ? $rel : '';
if($card->getIsWild() && !$card->getColor()){
	$colors = array('red','blue','green','yellow');
	$html = '';
	foreach(str_split($card->getLabel()) as $key => $letter){
		$pickedColor = $colors[$key%count($colors)];
		$html .= '<span class="action color-' . $pickedColor . ' wild" rel="' . $rel . '&color=' . $pickedColor .'">' . $letter . '</span>';
	}
	return $html;
}
else {
	return '<span class="action color-' . $card->getColor() . '" rel="'. $rel . '">' . $card->getLabel() . '</span>';
}
?>