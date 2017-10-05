<template>
	<div class="row">

		<a href="#"  class="btn btn-outline-primary" @click="load()">See answers</a>
		<div class="mt-2 col-12">
			<div class="card " v-for="response in responses">
				<div class="card-block">
					{{ response.message }}
				</div>
				<div class="card-footer text-muted">
					{{response.created_at}} by {{response.user.name}}
				</div>
			</div>
		</div>
		
	</div>
</template>

<script type="text/javascript">
export default {
	props:['message'],
	data(){
		return {
			responses:[],
		}
	},
	methods:{
		load(){
			axios.get('/api/messages/' + this.message + '/responses')
			.then(response => {
				this.responses = response.data;
			})
		}
	}
}
</script>