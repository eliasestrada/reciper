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

    props: ["visitorId"],

    methods: {
        fetchData() {
            fetch(`/api/recipes-random/${this.visitorId}`)
                .then(res => res.json())
                .then(res => (this.recipes = res.data))
                .catch(err => console.log(err));
        }
    }
};
</script>