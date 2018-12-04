<script>
import LazyLoadImages from "../../modules/_lazyLoadImages"

export default {
    data() {
        return {
            recipes: [],
        };
    },

    created() {
        this.fetchData()
    },

    props: ['visitorId'],

    methods: {
        fetchData() {
            this.$axios.get(`/api/recipes-random/${this.visitorId}`)
                .then(res => {
                    this.recipes = res.data.data
                    this.runLazyLoadImagesMethod()
                })
                .catch(err => console.error(err))
        },

        runLazyLoadImagesMethod() {
            setTimeout(() => {
                LazyLoadImages()
            }, 10)
        },
    },
};
</script>
