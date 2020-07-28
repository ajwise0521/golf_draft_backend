<template>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-header">Open Drafts</div>
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th>League</th>
									<th>Tournament</th>
									<th>Player Count</th>
									<th>Members</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="draft in drafts">
									<td>{{draft.league.name}}</td>
									<td>{{draft.tournament.name}}</td>
									<td></td>
									<td></td>
									<td><button v-if="draft.status == 'Active'" v-on:click="$router.push('/draft/' + draft.id)" class="btn btn-dark">GO</button></td>
								</tr>
							</tbody>
						</table>
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
				drafts: [],
			}
		},
		mounted() {
			this.getDrafts();
		},
		methods: {
			getDrafts: function() {
				axios.get('/api/drafts')
					.then(function(response) {
						this.drafts = response.data;
					}.bind(this));
			}
		}
	}
</script>