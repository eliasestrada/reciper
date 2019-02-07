<script>
import LazyLoadImagesForVue from '../../modules/lazyLoadImagesForVue'

export default {
    data() {
        return {
            recipes: [],
        }
    },

    created() {
        this.fetchData()
    },

    props: ['visitorId'],

    methods: {
        fetchData() {
            this.$axios.get(`/api/recipes-random/${this.visitorId}`)
                .then(res => this.recipes = res.data.data)
                .catch(err => console.error(err))
        },

        runLazyLoadImagesForVue(target) {
            LazyLoadImagesForVue(target)
        }
    },
}
</script>
