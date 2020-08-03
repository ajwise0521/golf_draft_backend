<template>
	<div>
		<ul class="list-group">
			<li class="list-group-item list-group-item-action" v-for="member in leagueMembers">
				{{ member.user.name }}				
			</li>
		</ul>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				
			}
		},
		props: ['leagueMembers'],
	}
</script>