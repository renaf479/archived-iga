<div id="" class="" data-ng-controller="igaController" data-ng-init="init()">
	<div id="notification" class="transition" data-ng-show="notification">{{notification}}</div>
	<div id="header">
		<div id="header-container">
			<a href="/" id="header-logo">Inside Gaming Awards</a>
			<ul id="social">
				<li>
					<a href="http://youtube.com/machinima" id="social-youtube" class="social-icon transition" target="_blank">Youtube</a>
				</li>
				<li>
					<a href="http://twitter.com/machinima_com" id="social-twitter" class="social-icon transition" target="_blank">twitter</a>
				</li>
				<li>
					<a href="http://facebook.com/Machinima" id="social-facebook" class="social-icon transition" target="_blank">facebook</a>
				</li>
				<li>
					<a href="http://twitter.com/machinima_com" id="social-google" class="social-icon transition" target="_blank">twitter</a>
				</li>
				<li>
					<a href="http://instagram.com/machinima" id="social-instagram" class="social-icon transition" target="_blank">instagram</a>
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
	
	<div id="games-container">
		<div id="games-countdown">
			<timer id="gamesCountdown-timer" countdown="countdown" interval="1000">
				<span id="countdownTimer-days" class="countdownTimer-digit">{{days}}</span>
				<span id="countdownTimer-hours" class="countdownTimer-digit">{{hours}}</span>
				<span id="countdownTimer-minutes" class="countdownTimer-digit">{{minutes}}</span>
				<span id="countdownTimer-seconds" class="countdownTimer-digit">{{seconds}}</span>
			</timer>
			
		</div>
		<div id="games-corner"></div>
		
		<div id="games-list">
			<div id="" class="game" data-ng-repeat="game in games">
				<h3 class="game-title">{{game.meta.title}}</h3>
				<game-art data-ng-model="game" class="game-art transition"></game-art>
				<div class="game-vote">
					<button class="gameVote-twitter transition" data-ng-click="vote(game, 'twitter')" data-ng-disabled="voteDisabled">Twitter</button>
					<button class="gameVote-facebook transition" data-ng-click="vote(game, 'facebook')" data-ng-disabled="voteDisabled">Facebook</button>
					<button class="gameVote-general transition" data-ng-click="vote(game)" data-ng-disabled="voteDisabled">Vote{{game.id}}</button>
				</div>
			</div>
		</div>
	</div>
	<div id="footer">
		<div id="footer-newsletter">
			<span id="newsletter-header">Newsletter</span>
			<form id="newsletter-form" name="newsletterForm" novalidate>
				<input type="email" id="newsletter-input" data-ng-model="email" placeholder="Enter your email address..." required/>
				<button id="newsletter-submit" class="transition" data-ng-disabled="newsletterForm.$invalid">Submit</button>
			</form>
		</div>
		<div id="footer-legal">
			<span id="legal-message">Don't worry, we don't spam ever</span>
			<span id="legal-copyright">&copy;2013 Machinima, Inc. All rights reserved </span>
		</div>
	</div>
</div>