<template>
	<div>
        <div class="modal fade" id="draftModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                	You are about to draft {{selectedPlayer.name}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-on:click="draftPlayer" type="button" class="btn btn-dark" data-dismiss>Draft</button>
              </div>
            </div>
          </div>
        </div>
		<ul class="list-group">
			<li class="list-group-item list-group-item-action" v-for="player in players">
				{{player.rank}}. {{player.name}}			
				<button v-if="isDrafting && draftStatus == 'Active'" type="button" class="btn btn-dark float-right" data-toggle="modal" data-target="#draftModal" v-on:click="selectedPlayer = player">Draft</button>	
			</li>
		</ul>
	</div>
</template>

<script>
    export default {
        data: function() {
        	return {
        		players: [],
        		draftModalOpen: false,
        		selectedPlayer: {
        			name: '',
        		},
                currentPick: [],
                isDrafting: false,
                draftStatus: null,
        	}
        },
        props: ['draft'],
        mounted() {
        	eventBus.$on('draft-player', this.draftPlayer)
        	eventBus.$on('close-draft-modal', this.closeDraftModal)
            eventBus.$on('player-drafted', this.playerDrafted)

            this.playerDrafted();

            Pusher.logToConsole = true;

            var pusher = new Pusher('fef224f1e53af53c6251', {
              cluster: 'us2'
            });

            var channel = pusher.subscribe('draft-page');
            channel.bind('player-drafted', function(data) {
                eventBus.$emit('player-drafted', true);
                toastr.success(data.message);
                eventBus.$emit('update-recent-picks', true);
                this.draftStatus = data.draftStatus;

            });
        },
        methods: {
        	closeDraftModal: function () {
        		this.draftModalOpen = false;
        	},
        	draftPlayer: function () {
        		axios.post('api/draft-player/' + this.currentPick.id, this.selectedPlayer)
        			.then(function(response) {
        				toastr.success('You Drafted ' + this.selectedPlayer.name + '!');
        				this.resetSelectedPlayer();
                        this.isDrafting = false;
        			}.bind(this));
        	},
        	resetSelectedPlayer: function () {
        		this.selectedPlayer = {
        			name: ''
        		};
        	},
            loadPlayers: function() {
                axios.get('api/get-players/' + this.$route.params.draft_id + '/' + vueStore.state.auth.user_id)
                    .then(function(response) {
                        this.players = response.data;
                    }.bind(this));
            },
            getCurrentDraftPick: function () {
                axios.get('/api/current-pick/' + this.$route.params.draft_id)
                    .then(function(response) {
                        this.currentPick = response.data;
                        eventBus.$emit('current-pick-change', this.currentPick);
                        this.checkIsDrafting();
                    }.bind(this))
            },
            checkIsDrafting: function () {
                if(vueStore.state.auth.user_id == this.currentPick.user_id) {
                    this.isDrafting = true;
                    this.playSound('sounds/your_turn_to_draft.mp3');
                }
                console.log(vueStore.state.auth.user_id);
                console.log(this.currentPick.user_id);
                console.log('hello again');
            },
            playerDrafted: function() {
                this.loadPlayers();
                this.getCurrentDraftPick();
            },
            playSound (sound) {
              if(sound) {
                var audio = new Audio(sound);
                audio.play();
              }
            }
        },
        beforeDestroy() {
            eventBus.$off('draft-player', this.draftPlayer)
            eventBus.$off('close-draft-modal', this.closeDraftModal)
            eventBus.$off('player-drafted', this.playerDrafted)
        },
        watch: {
            draft: function (draft) {
                this.draftStatus = draft.status;
            }
        }
    }
</script>