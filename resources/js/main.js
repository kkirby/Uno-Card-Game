var lastUpdateId = 0;
var lock = false;

var update = function(){
	if(lock == false){
		jQuery.getJSON('update.php?updateId=' + lastUpdateId,{},updateCallback);
	}
}

var updateCallback = function(data, textStatus, jqXHR){
	toggleLoadingSpinner(false);
	lock = false;
	if(typeof data.error != 'undefined'){
		showError(data.error);
	}
	if(data.update == true){
		lastUpdateId = data.updateId;
		$('#front').html(data.html.front);
		$('#cards').html(data.html.playerCards);
		$('#players').html(data.html.players);
		updateActions();
		updateNoSelects();
	}
}

var updateActions = function(){
	$('.action').not('[rel^="?null"]').not('.action-activated').each(function(){
		$(this).addClass('not-null')
			.addClass('action-activated')
			.click(function(){
				doAction($(this).attr('rel'));
			});
	});
}

var doAction = function(action){
	if(lock == false){
		toggleLoadingSpinner(true);
		lock = true;
		jQuery.getJSON('sendUpdate.php' + action,{},updateCallback);
	}
}

var toggleLoadingSpinner = function(start){
	if(start == true){
		$('#loading').show().spin({
		  lines: 12,
		  length: 7,
		  width: 4,
		  radius: 10,
		  color: '#000',
		  speed: 1,
		  trail: 60,
		  shadow: false
		});
	}
	else {
		$('#loading').hide().spin(false);
	}
}

var showError = function(message){
	$('#error #message').html(message);
	$('#error').show().animate({
		opacity: 1
	},300);
	$('#error_overlay').show().animate({
		opacity: .3
	},300);
}

var updateNoSelects = function(){
	$('.no-select').not('.no-select-activated').addClass('no-select-activated').mousedown(function(){
		return false;
	});
}

$(function(){
	if(!$('body').hasClass('no-game')){
		update();
	}
	updateNoSelects();
	
	$('.no-game #join-game button, .game #join-game').click(function(){
		var id = prompt('Invite ID','');
		$.ajax({
			url: 'sendUpdate.php?action=joinGame&id=' + id,
			success: function(){
				window.location.reload()
			}
		});
	});
	
	$('.no-game #create-game button, .game #create-game').click(function(){
		$.ajax({
			url: 'sendUpdate.php?action=createGame',
			success: function(){
				window.location.reload()
			}
		});
	});
	
	$('#error button').click(function(){
		$('#error, #error_overlay').css({
			opacity: 0,
			display: 'none'
		});
	});
	
	setInterval(update,1000);
	
});