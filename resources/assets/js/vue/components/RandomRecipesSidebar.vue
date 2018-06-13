<template>
	<ul class="unstyled-list">
		<li v-for="recipe in recipes" :key="recipe.id" class="side-bar-recipe" style="animation:appearWithRotate 1s;">
			<a :href="'/recipes/' + recipe.id" :title="recipe.title">
				<img :src="'/storage/images/' + recipe.image" :alt="recipe.title">
			</a>
			<div class="side-bar-content">
				<h3>{{ recipe.title }}</h3>
			</div>
		</li>
	</ul>
</template>

<script>
export default {
	data() {
		return {
			recipes: []
		}
	},

	created() {
		this.fetchData()
	},

	props: ['resipeId'],
	 
	methods: {
		fetchData() {
			fetch('/api/recipes/other/random/' + this.resipeId)
			.then(res => res.json())
			.then(res => this.recipes = res.data)
			.catch(err => console.log(err))
		}
	}
}
</script>