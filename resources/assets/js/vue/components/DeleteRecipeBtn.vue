<template>
	<span>
		<div v-if="error">
			<!-- <p v-if="error" class="alert alert-danger mt-2">{{ error }}</p> -->
		</div>
		<span v-else>
			<button @click="deleteRecipe" type="button" class="btn-floating red btn-large tooltipped" :data-tooltip="deleteRecipeTip" data-position="left">
				<i class="large material-icons">delete</i>
			</button>
		</span>
	</span>
</template>

<script>
export default {
  data() {
    return {
      error: ""
    };
  },

  props: ["confirm", "recipeId", "deletedFail", "deleteRecipeTip"],

  methods: {
    deleteRecipe() {
      if (confirm(this.confirm)) {
        fetch(`/api/recipes/${this.recipeId}`, {
          method: "delete"
        })
          .then(res => res.text())
          .then(data => {
            data === "success"
              ? (window.location.href = "/users/other/my-recipes")
              : (this.error = this.deletedFail);
          })
          .catch(error => console.log(error));
      }
    }
  }
};
</script>