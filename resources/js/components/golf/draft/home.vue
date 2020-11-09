<template>
	<div>
		<div class="row">
			<div class="col-md-2">
                <div class="card">
                    <div class="card-header">Available Players</div>
						<available-players :draft="draft">
                        </available-players>
                    <div class="card-body">	
                    </div>
                </div>
			</div>
			<div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div v-if="draft.status == 'Active'">Drafting Now: {{ currentPick.userName }}</div>
                        <button class="btn btn-dark float-right" v-else-if="isOwner" v-on:click="startDraft">Start</button>
                    </div>

                    <div class="card-body">
                        <past-picks :pastPicks="pastPicks"></past-picks>
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
                pastPicks: [],
                isOwner: false,
            }
        },
        mounted() {
            eventBus.$on('current-pick-change', this.updateCurrentPick);
            eventBus.$on('update-recent-picks', this.getPastPicks);
            eventBus.$on('update-draft', this.updateDraft);
            this.getPastPicks();
            this.getDraft();

            Pusher.logToConsole = true;

            var pusher = new Pusher('fef224f1e53af53c6251', {
              cluster: 'us2'
            });

            var channel = pusher.subscribe('draft-page');
            channel.bind('draft-started', function(data) {
                eventBus.$emit('update-draft', data.data);
            });
        }, 
        components: {
        	'available-players': require('./available-players').default,
        	'draft-team': require('./draft-team').default,
            'past-picks': require('./past-picks').default
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
                        this.checkOwner();
                    })
            },
            updateCurrentPick: function (pick) {
                this.currentPick = pick;
            },
            getPastPicks: function () {
                axios.get('/api/draft/past-picks/' + this.$route.params.draft_id)
                    .then(response => {
                        this.pastPicks = response.data;
                    });
            },
            checkOwner: function () {
                if(this.draft.league.created_by == vueStore.state.auth.user_id)
                    this.isOwner = true;
            },
            startDraft: function () {
                axios.post('api/draft/start/' + this.draft.id)
                    .then(response => {
                        this.getDraft();
                    })
            },
            updateDraft: function (draft) {

                this.draft = draft;
            }
        },
        beforeDestroy() {
            eventBus.$off('update-recent-picks', this.getPastPicks);
            eventBus.$off('current-pick-change', this.updateCurrentPick);
            eventBus.$off('update-draft', this.updateDraft);
        }
    }
</script>