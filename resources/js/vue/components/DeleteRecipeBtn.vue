<script>
import withMethod from '../../modules/_withMethod';

export default {
    data() {
        return {
            error: '',
        };
    },

    props: ['confirm', 'recipeId', 'deletedFail'],

    methods: {
        deleteRecipe() {
            if (confirm(this.confirm)) {
                fetch(`/recipes/${this.recipeId}`, withMethod('delete'))
                    .then(res => res.text())
                    .then(data => {
                        data === 'success'
                            ? (window.location.href = '/users/other/my-recipes')
                            : (this.error = this.deletedFail);
                    })
                    .catch(err => console.error(err));
            }
        },
    },
};
</script>