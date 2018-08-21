<template>
	<span>
		<span v-if="!error">
			<button @click="deleteRecipe" type="button" class="btn red tooltipped" :data-tooltip="deleteRecipeTip" data-position="top">
				<i class="material-icons">delete</i>
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