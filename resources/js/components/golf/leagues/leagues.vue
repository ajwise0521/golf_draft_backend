<template>
	<div>
		<ul class="list-group">
			<li class="list-group-item list-group-item-action" v-for="league in leagues">
				{{league.league.name}}
				<button v-if="selectedLeague.id != league.id" type="button" class="btn btn-dark float-right" data-toggle="modal" data-target="#draftModal" v-on:click="changeLeague(league)">Details</button>	
			</li>
		</ul>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				selectedLeague: ''
			}
		},
		props: ['leagues'],
		methods: {
			changeLeague: function (league) {
				this.selectedLeague = league;
				eventBus.$emit('league-changed', this.selectedLeague);
			}
		}
	}
</script>