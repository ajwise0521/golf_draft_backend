<template>
	<div class="container">
		<div class="col-xs-offset-2 col-xs-8 row">
            <select v-on:change="getMemberTeam" v-model="selectedLeagueMember"  class="form-control">
            	<option value="" disabled>Select a Team to view</option>
                <option v-for="leagueMember in leagueMembers" :value="leagueMember.user_id">{{leagueMember.user.name}}</option>
            </select>
		</div>
		</hr>
		<div class="row">
						<table v-if="teamPlayers.length > 0"class="table">
							<thead class="thead-dark">
								<tr>
									<th>Draft Pick</th>
									<th>Name</th>
									<th>Rank</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="player in teamPlayers" v-if="player.player">
									<td>{{player.draft_pick}}</td>
									<td>{{player.player.name}}</td>
									<td>{{player.player.rank}}</td>
								</tr>
							</tbody>
						</table>
		</div>
	</div>
</template>	
<script>
	export default {
		data() {
			return {
				draftTeam: [],
				selectedLeagueMember: '',
				teamPlayers: [],
			}
		},
		props: ['leagueMembers'],

		mounted() {
			console.log('league member: ' + vueStore.state.auth.use_id);
			this.selectedLeagueMember = vueStore.state.auth.user_id;
			this.getMemberTeam();
			eventBus.$on('update-team-players', this.getMemberTeam)
            Pusher.logToConsole = true;

            var pusher = new Pusher('fef224f1e53af53c6251', {
              cluster: 'us2'
            });

            var channel = pusher.subscribe('draft-page');
            channel.bind('player-drafted', function(data) {
            		eventBus.$emit('update-team-players');

            });
		},
		methods: {	
			getMemberTeam: function () {
					axios.get('/api/players/' + this.$route.params.draft_id + '/' + this.selectedLeagueMember)
						.then(response => {
							this.teamPlayers = response.data;
						})

			}
		},
		beforeDestroy() {
			eventBus.$off('update-team-players', this.getMemberTeam);
		}
	}
</script>