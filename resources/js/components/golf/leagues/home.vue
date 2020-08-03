<template>
	<div>
        <modal :show="show_add_modal">
          	<select class="form-control" v-model="selectedTournament">
          		<option value=''>Select a Tournament</option>
          		<option v-for="tournament in availableTournaments" :value="tournament.id">{{tournament.name}}</option>
          	</select>
          	<div>
          		<div style="border: 1px black; border-radius: 15px">
          			<label>Who is Playing?</label>
					<li class="list-group-item list-group-item-action" v-for="member in leagueMembers">
						{{member.user.name}}
						<div class="float-right">
						<input type="checkbox" class="form-check-input" v-model="member.selected">
						</div>	
					</li>
          		</div>
          	</div>
				<modal-footer class="sticky-bottom">
					<button v-on:click="createDraft" class="btn-save btn btn-primary btn-sm">Save</button>
				</modal-footer>
        </modal>
		<div class="row">
			<div class="col-md-2">
                <div class="card">
                    <div class="card-header">Leagues</div>
						<leagues :leagues="leagues"></leagues>
                    <div class="card-body">	
                    </div>
                </div>
			</div>
			<div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        League Info 
                        <button class="btn btn-primary" v-on:click="show_add_modal=true" v-if="selectedLeague != null">Create Draft</button>
                    </div>

                    <div class="card-body">
                    </div>
                </div>
			</div>
			<div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                    	League Players
                    </div>
						<league-members :leagueMembers="leagueMembers"></league-members>
                    <div class="card-body">
                    </div>
                </div>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				leagues: [],
				selectedLeague: null,
				leagueMembers: [],
				selectedLeagueMembers: [],
				show_add_modal: false,
				availableTournaments: [],
				selectedTournament: '',

			}
		},
		mounted() {
			eventBus.$on('league-changed', this.leagueChanged);
			this.getLeagues();
			this.getAvailableTournaments();
		},

		methods:{
			getLeagues: function () {
				axios.get('api/user/leagues/' + vueStore.state.auth.user_id)
					.then(response => {
						this.leagues = response.data;
					});
			},
			leagueChanged: function (league) {
				this.selectedLeague = league;
				this.getLeagueMembers();
			},
			getLeagueMembers: function () {
				axios.get('api/league-members/' + this.selectedLeague.league_id) 
					.then(response => {
						this.leagueMembers = response.data;
						this.leagueMembers.forEach((member) => {
							member.selected = false;
						});
					});
			},
			closeAddModal: function () {
				this.show_add_modal = false;
			},
			getAvailableTournaments: function () {
				axios.get('api/tournaments/available') 
					.then(response => {
						this.availableTournaments = response.data;
					});
			},
			createDraft: function () {
				axios.post('api/draft/create', {
					tournament: this.selectedTournament, 
					members: this.leagueMembers
				})
					.then(response => {

					});
			}
		},
		components: {
			'leagues': require('./leagues').default,
			'league-members': require('./league-members').default,
		},
		beforeDestroy() {
			eventBus.$off('league-changed', this.leagueChanged);
		}
	}
</script>