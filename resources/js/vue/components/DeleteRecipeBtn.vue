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
                fetch(`/recipes/${this.recipeId}`, {
                    method: "DELETE",
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    })
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