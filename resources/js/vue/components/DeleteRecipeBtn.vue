<script>
export default {
    data() {
        return {
            error: '',
        }
    },

    props: ['confirm', 'recipeId', 'deletedFail'],

    methods: {
        deleteRecipe() {
            if (confirm(this.confirm)) {
                this.$axios.delete(`/recipes/${this.recipeId}`)
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