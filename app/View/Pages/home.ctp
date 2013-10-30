<div id="" class="" data-ng-controller="igaController" data-ng-init="init()">

	<div id="header">
		<div id="social">
			<ul id="social-icons">
				<li>
					<a href="http://facebook.com/Machinima" class="iga-button" target="_blank">facebook</a>
				</li>
				<li>
					<a href="http://twitter.com/machinima_com" class="iga-button" target="_blank">twitter</a>
				</li>
				<li>
					<a href="http://instagram.com/machinima" class="iga-button" target="_blank">instagram</a>
				</li>
				<li>
					<a href="http://youtube.com/machinima" class="iga-button" target="_blank">Youtube</a>
				</li>
			</ul>
		</div>
		<carousel id="twitter-feed">
			<slide data-ng-repeat="tweet in tweets">{{tweet.text}}</slide>
		</carousel>
	</div>
	<div id="video">
		<h2 id="video-header">Inside Gaming Daily</h2>
		<iframe width="780" height="439" src="//www.youtube.com/embed/BfJVgXBfSH8?rel=0" frameborder="0" allowfullscreen></iframe>
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
				<div class="game-vote">
					<button class="gameVote-twitter iga-button" data-ng-click="vote(game, 'twitter')" data-ng-disabled="voteDisabled">Twitter</button>
					<button class="gameVote-facebook iga-button" data-ng-click="vote(game, 'facebook')" data-ng-disabled="voteDisabled">Facebook</button>
					<button class="gameVote-general" data-ng-click="vote(game)" data-ng-disabled="voteDisabled">Vote{{game.id}}</button>
				</div>
			</div>
		</div>
	</div>
</div>