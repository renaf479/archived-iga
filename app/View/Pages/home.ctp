<div id="" class="" data-ng-controller="igaController" data-ng-init="init()">
	<div id="notification" class="transition" data-ng-show="notification">{{notification}}</div>
	<div id="header">
		<div id="header-container">
			<a href="/" id="header-logo">Inside Gaming Awards</a>
			<ul id="social">
				<li>
					<a href="http://youtube.com/machinima" id="social-youtube" class="social-icon transition" target="_blank" data-ng-click="trackEvent('link', 'Youtube')">Youtube</a>
				</li>
				<li>
					<a href="http://twitter.com/machinima_com" id="social-twitter" class="social-icon transition" target="_blank" data-ng-click="trackEvent('link', 'Twitter')">twitter</a>
				</li>
				<li>
					<a href="http://facebook.com/Machinima" id="social-facebook" class="social-icon transition" target="_blank" data-ng-click="trackEvent('link', 'Facebook')">facebook</a>
				</li>
				<li>
					<a href="https://plus.google.com/+Machinima/posts" id="social-google" class="social-icon transition" target="_blank" data-ng-click="trackEvent('link', 'Google+')">google</a>
				</li>
				<li>
					<a href="http://instagram.com/machinima" id="social-instagram" class="social-icon transition" target="_blank" data-ng-click="trackEvent('link', 'Instagram')">instagram</a>
				</li>
			</ul>
			<div id="twitter-feed">
				<carousel id="" interval="carousel.interval">
					<slide data-ng-repeat="tweet in tweets">{{tweet.text}}</slide>
				</carousel>
				<div id="twitter-logo" class="transition">twitter</div>
			</div>
		</div>
	</div>
	<div id="video">
		<h2 id="video-header">Inside Gaming Daily</h2>
		<iframe id="video-player" width="780" height="439" src="//www.youtube.com/embed/BfJVgXBfSH8" frameborder="0" allowfullscreen></iframe>
	</div>
	
	<h2 id="games-header">Game of the Year</h2>
	<div id="games-container">
		<div id="games-countdown">
			<timer id="gamesCountdown-timer" countdown="countdown" interval="1000">
				<span id="countdownTimer-days" class="countdownTimer-digit">
					{{days}}
					<label class="countdownTimer-label">Days</label>
				</span>
				<span id="countdownTimer-hours" class="countdownTimer-digit">
					{{hours}}
					<label class="countdownTimer-label">Hours</label>
				</span>
				<span id="countdownTimer-minutes" class="countdownTimer-digit">
					{{minutes}}
					<label class="countdownTimer-label">Minutes</label>
				</span>
				<span id="countdownTimer-seconds" class="countdownTimer-digit">
					{{seconds}}
					<label class="countdownTimer-label">Seconds</label>
				</span>
			</timer>
			<h3 id="gamesCountdown-header" class="clear">Vote for your favorite below!</h3>
		</div>
		
		
		<div id="games-list">
			<div id="game-{{$index}}" class="game" data-ng-repeat="game in games">
				<h3 class="game-title">{{game.meta.title}}</h3>
				<game-art data-ng-model="game" class="game-art transition"></game-art>
				<div class="game-vote">
					<vote-button data-type="twitter" data-ng-model="game" data-ng-click="vote(game, 'twitter')">twitter</vote-button>
					<vote-button data-type="facebook" data-ng-model="game" data-ng-click="vote(game, 'facebook')">facebook</vote-button>
					<button class="gameVote-general transition" data-ng-click="vote(game)" data-ng-disabled="voteDisabled">Vote{{game.id}}</button>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div id="footer">
		<div id="footer-newsletter">
			<span id="newsletter-header">Newsletter</span>
			<form id="newsletter-form" name="newsletterForm" action="http://machinima.us4.list-manage.com/subscribe/post?u=22cb3ccbfa1254a4b05ceca93&amp;id=7711b4a200" method="post" target="_blank" data-ng-model="newsletter" novalidate>
				<input type="email" name="EMAIL" id="newsletter-input" data-ng-model="newsletter.email" placeholder="Enter your email address..." required/>
				<button name="subscribe" id="newsletter-submit" class="transition" data-ng-disabled="newsletterForm.$invalid" data-ng-click="subscribe()">Submit</button>
			</form>
		</div>
		<div id="footer-legal">
			<span id="legal-message">Don't worry, we don't spam ever</span>
			<span id="legal-copyright">&copy;2013 Machinima, Inc. All rights reserved </span>
		</div>
	</div>
	<script>
		var domain		= 'http://iga.willfu.com';
	
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		//ga('create', 'UA-45443905-1', 'insidegamingawards.com');
		ga('create', 'UA-45443905-1', {'cookieDomain': 'none'});//Localhost debug
		ga('send', 'pageview');
	
	</script>
</div>