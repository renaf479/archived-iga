<?php
	if(!$results) {
		echo 'Authentication Failed. Please try again';
	}
?>
<script type="text/javascript">
	var _results = '<?php echo addslashes(json_encode($results));?>';
</script>

<h1>Inside Gaming Awards 2013 Results</h1>
<table class="table table-striped table-bordered table-hover">
	<thead>
		<th data-ng-click="filter='meta.title';reverse=!reverse">Game Title</th>
		<th data-ng-click="filter='votes';reverse=!reverse">Votes (Total: {{total}})</th>
	</thead>
	<tr data-ng-repeat="result in results|orderBy:filter:reverse">
		<td>{{result.meta.title}}</td>
		<td>{{result.votes}}</td>
	</tr>
</table>