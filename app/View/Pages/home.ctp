<div id="" class="" data-ng-controller="igaController" data-ng-init="init()">

	<div id="social">
		<ul id="social-icons">
			<li>
				<a href="http://facebook.com/Machinima" target="_blank">facebook</a>
			</li>
			<li>
				<a href="http://twitter.com/machinima_com" target="_blank">twitter</a>
			</li>
			<li>
				<a href="http://instagram.com/machinima" target="_blank">instagram</a>
			</li>
			<li>
				<a href="http://youtube.com/machinima" target="_blank">Youtube</a>
			</li>
		</ul>
	</div>
	<div id="twitter">
	</div>
	
	<div id="video">
		<iframe width="780" height="439" src="//www.youtube.com/embed/BfJVgXBfSH8?rel=0" frameborder="0" allowfullscreen></iframe>
	</div>
	
	<div id="games">
		<div id="" class="game" data-ng-repeat="game in games">
			<h3 class="game-title">{{game.meta.title}}</h3>
			<span>{{game.votes}}</span>
			<div class="game-vote">
				<button class="gameVote-twitter" data-ng-click="vote(game, 'twitter')" data-ng-disabled="voteDisabled(game.id)">Twitter</button>
				<button class="gameVote-facebook" data-ng-click="vote(game, 'facebook')" data-ng-disabled="voteDisabled(game.id)">Facebook</button>
				<button class="gameVote-general" data-ng-click="vote(game)" data-ng-disabled="voteDisabled(game.id)">Vote{{game.id}}</button>
			</div>
		</div>
	</div>
</div>