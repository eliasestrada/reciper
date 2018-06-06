<template>
	<span>
		<div v-if="error">
			<p v-if="error" class="alert alert-danger mt-2">{{ error }}</p>
		</div>
		<span v-else>
			<button @click="deleteRecipe" type="button" class="edit-recipe-icon icon-delete"></button>
		</span>
	</span>
</template>

<script>
export default {
	data() {
		return {
			error: ''
		}
	},

	props: ['confirm', 'recipeId', 'deletedFail'],
	 
	methods: {
		deleteRecipe () {
			if (confirm(this.confirm)) {
				fetch(`/api/recipes/${this.recipeId}`, {
					method: 'delete'
				})
				.then(res => res.text())
				.then(data => {
					data === 'success'
						? window.location.href = '/users/my_recipes/all'
						: this.error = this.deletedFail
				})
				.catch(error => console.log(error))
			}
		}
	}
}
</script>