<div id="" class="" data-ng-controller="igaController" data-ng-init="init()">

	<div id="header">
		<div id="header-container">
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
				<carousel id="">
					<slide data-ng-repeat="tweet in tweets">{{tweet.text}}</slide>
				</carousel>
				<a href="" id="twitter-link" class="transition">twitter</a>
			</div>
		</div>
	</div>
	<div id="video">
		<h2 id="video-header">Inside Gaming Daily</h2>
<!-- 		<iframe width="780" height="439" src="//www.youtube.com/embed/BfJVgXBfSH8?rel=0" frameborder="0" allowfullscreen></iframe> -->
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
					<button class="gameVote-twitter" data-ng-click="vote(game, 'twitter')" data-ng-disabled="voteDisabled">Twitter</button>
					<button class="gameVote-facebook" data-ng-click="vote(game, 'facebook')" data-ng-disabled="voteDisabled">Facebook</button>
					<button class="gameVote-general" data-ng-click="vote(game)" data-ng-disabled="voteDisabled">Vote{{game.id}}</button>
				</div>
			</div>
		</div>
	</div>
</div>