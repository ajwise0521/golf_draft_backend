<template>
	<table v-if="pastPicks.length > 0"class="table">
		<thead class="thead-dark">
			<tr>
				<th>Draft Pick</th>
				<th>Name</th>
				<th>Rank</th>
				<th>Drafted By</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="player in pastPicks">
				<td>{{player.draft_pick}}</td>
				<td>{{player.player.name}}</td>
				<td>{{player.player.rank}}</td>
				<td>{{player.userName}}</td>
			</tr>
		</tbody>
	</table>
</template>

<script>
	export default {
		props: ['pastPicks']
	}

</script>