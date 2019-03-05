<script>
export default {
    data() {
        return {
            error: '',
        }
    },

    props: ['confirm', 'recipeSlug', 'deletedFail'],

    methods: {
        deleteRecipe() {
            if (confirm(this.confirm)) {
                this.$axios.delete(`/recipes/${this.recipeSlug}`)
                    .then(data => {
                        data.data === 'success'
                            ? (window.location.href = '/users/other/my-recipes')
                            : (this.error = this.deletedFail)
                    })
                    .catch(err => console.error(err))
            }
        },
    },
}
</script>