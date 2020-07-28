<template>
	<div>
		<div class="row">
			<div class="col-md-2">
                <div class="card">
                    <div class="card-header">Available Players</div>
						<available-players></available-players>
                    <div class="card-body">	
                    </div>
                </div>
			</div>
			<div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Drafting Now: {{ currentPick.userName }}
                    </div>

                    <div class="card-body">
                    </div>
                </div>
			</div>
			<div class="col-md-4">
                <div class="card">
                    <div class="card-header">Teams
                    </div>
						<draft-team :leagueMembers="leagueMembers"></draft-team>
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
                leagueMembers: [],
                selectedLeagueMember: [],
                draft: [],
                currentPick: [],
            }
        },
        mounted() {
            eventBus.$on('current-pick-change', this.updateCurrentPick);
            this.getDraft();
        }, 
        components: {
        	'available-players': require('./available-players').default,
        	'draft-team': require('./draft-team').default
        },
        methods: {
            getLeagueMembers: function () {
                axios.get('/api/league-members/' + this.draft.league_id)
                    .then(response => {
                        this.leagueMembers = response.data;
                    });
            },
            getDraft: function () {
                axios.get('/api/draft/' + this.$route.params.draft_id)
                    .then(response => {
                        this.draft = response.data;
                        this.getLeagueMembers();
                    })
            },
            updateCurrentPick: function (pick) {
                this.currentPick = pick;
            }
        },
        beforeDestroy() {
            eventBus.$off('current-pick-change', this.updateCurrentPick);
        }
    }
</script>