<template>
    <div class="pt-3">
        <card :prop-recipes="recipes"
            :go="go"
            :mins="mins"
            :user-id="userId"
            :favs="favs"
            :propTheEnd="theEnd">
        </card>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                recipes: [],
                newRecipes: [],
                next: '',
                theEnd: false,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };
        },
    
        props: {
            "go": { required: true },
            "favs": { default: null },
            "userId": { default: null },
            "mins": { default: 'min' }
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
            },
        },
        computed: {
            giveLink() {
                return this.next;
            },
        }
    };
</script>