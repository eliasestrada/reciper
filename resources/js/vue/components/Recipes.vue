<template>
	<div>
		<div class="row">
			<div class="col s12 m6 l3" v-for="recipe in recipes" :key="recipe.id">
				<div class="card">
					<div class="card-image waves-effect waves-block waves-light">
						<a :href="'/recipes/' + recipe.id" :title="recipe.title">
							<img class="activator" :src="'storage/images/small/' + recipe.image" :alt="recipe.title">
						</a>
					</div>
					<div class="card-content min-h">
						<span class="card-title activator">
							{{ recipe.title_short }}
						</span>
					</div>
					<div class="card-reveal">
						<span class="card-title ">
							{{ recipe.title }}
							<i class="material-icons right">close</i>
						</span>
						<p>
							<a :href="'/recipes/' + recipe.id" :title="recipe.title">{{ go }}</a>
						</p>
						<p>{{ recipe.intro }}</p>
					</div>
				</div>
			</div>
		</div>
	
		<infinite-loading v-if="!theEnd" @infinite="infiniteHandler"></infinite-loading>
	</div>
</template>

<script>
	import InfiniteLoading from 'vue-infinite-loading';

	export default {
		
		data() {
			return {
				recipes: [],
				newRecipes: [],
				next: '',
				theEnd: false
			};
		},
	
		props: ["go"],

		created() {
			fetch('/api/recipes')
			.then(res => res.json())
			.then(res => {
				this.recipes = res.data
				this.next = res.links.next
			})
			.catch(err => console.log(err));
		},
	
		methods: {
			fetchRecipes(page_url) {
				page_url = page_url || "/api/recipes";
	
				fetch(page_url)
					.then(res => res.json())
					.then(res => {
						if (res.links.next != null) {
							this.newRecipes = res.data
							this.next = res.links.next
						} else {
							this.theEnd = true
						}
					})
					.catch(err => console.log(err));
				},

			infiniteHandler($state) {
				setTimeout(() => {
					fetch(this.next)
						.then(res => res.json())
						.then(res => {
							if (res.links.next != null) {
								this.recipes = this.recipes.concat(res.data)
								this.next = res.links.next	
								console.log(this.next)
							} else {
								console.log('no')
								this.theEnd = true
							}
						})
						.catch(err => console.log(err));
					$state.loaded()
				}, 1000);
			},
		},
		components: {
			InfiniteLoading,
		},
	};
</script>