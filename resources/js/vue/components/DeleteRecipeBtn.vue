<script>
export default {
    data() {
        return {
            error: ""
        }
    },

    props: ["confirm", "recipeId", "deletedFail"],

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
                .catch(error => console.error(error));
            }
        }
    }
};
</script>