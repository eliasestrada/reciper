<template>
	<div>
		<div class="card" v-for="recipe in recipes" :key="recipe.id" style="animation:appearWithRotate 1s;">
			<div class="card-image">
				<a :href="'/recipes/' + recipe.id" :title="recipe.title">
					<img :src="'/storage/images/' + recipe.image" :alt="recipe.title">
				</a>
			</div>
			<div class="card-content p-3">
				<p>{{ recipe.title }}</p>
			</div>
		</div>
	</div>
</template>

<script>
export default {
  data() {
    return {
      recipes: []
    };
  },

  created() {
    this.fetchData();
  },

  props: ["resipeId"],

  methods: {
    fetchData() {
      fetch("/api/recipes/other/random/" + this.resipeId)
        .then(res => res.json())
        .then(res => (this.recipes = res.data))
        .catch(err => console.log(err));
    }
  }
};
</script>