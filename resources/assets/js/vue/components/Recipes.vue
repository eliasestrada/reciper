<template>
	<div>
		<div class="row">
			<div class="col s12 m6 l3" v-for="recipe in recipes" :key="recipe.id">
				<div class="card">
					<div class="card-image waves-effect waves-block waves-light">
						<a :href="'/recipes/' + recipe.id" :title="recipe.title">
							<img :src="'storage/images/' + recipe.image" :alt="recipe.title" class="activator">
						</a>
					</div>
					<div class="card-content">
						<span class="card-title activator">
							{{ recipe.title }}
							<i class="material-icons right">more_vert</i>
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

		<!-- Pagination -->
		<ul v-if="pagin.prev_page_url || pagin.next_page_url" class="pagination">
			<li v-if="pagin.prev_page_url" class="page-item">
				<a @click="fetchRecipes(pagin.prev_page_url)" href="#" class="page-link">
					&laquo;
				</a>
			</li>
			<li class="page-item disabled">
				<a class="page-link">{{ pagin.current_page }} / {{ pagin.last_page }}</a>
			</li>
			<li v-if="pagin.next_page_url" class="page-item">
				<a @click="fetchRecipes(pagin.next_page_url)" href="#" class="page-link">
					&raquo;
				</a>
			</li>
		</ul>
	</div>
</template>

<script>
export default {
	data() {
		return {
			recipes: [],
			pagin: {}
		}
	},

	props: ['go'],

	created() {
		this.fetchRecipes()
	},
	 
	methods: {
		fetchRecipes(page_url) {
			let vm = this
			page_url = page_url || '/api/recipes'

			fetch(page_url)
			.then(res => res.json())
			.then(res => {
				this.recipes = res.data
				vm.makePagination(res.meta, res.links)
			})
			.catch(err => console.log(err))
		},

		makePagination(meta, links) {
			let pagin = {
				current_page: meta.current_page,
				last_page: meta.last_page,
				next_page_url: links.next,
				prev_page_url: links.prev
			}
			this.pagin = pagin
		}
	}
}
</script>