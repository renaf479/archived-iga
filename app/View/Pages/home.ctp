
<div id="" class="" data-ng-controller="igaController" data-ng-init="init()">
	<div data-ng-repeat="game in games">
		<span>{{game.Game.meta.title}}</span>
		<span>{{game.Game.votes}}</span>
	</div>
</div>