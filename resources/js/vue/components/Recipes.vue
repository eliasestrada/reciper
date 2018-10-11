<script>
    export default {
        data() {
            return {
                recipes: [],
                next: '',
                theEnd: false,
            };
        },

        created() {
            this.makeFirstRequest()
            window.onhashchange = () => {
                this.theEnd = false
                this.makeFirstRequest()
            }
        },
    
        methods: {
            makeFirstRequest() {
                Event.$emit('hash-changed', this.hash())

                fetch('/api/recipes/' + this.hash())
                    .then(res => res.json())
                    .then(res => {
                        this.recipes = res.data

                        if (res.links.next != null) {
                            this.next = res.links.next
                            Event.$emit('next-link-is-ready', res.links.next)
                        } else {
                            this.theEnd = true
                        }
                    })
                    .catch(err => console.error(err));
            },
            hash() {
                return window.location.hash.substring(1)
            },
            userHasFav(recipe_id) {
                if (this.favs) {
                    var result = this.favs.map(fav => {
                        return recipe_id == fav.recipe_id ? 'active' : '';
                    });
                    return result;
                }
            }
        }
    };
</script>