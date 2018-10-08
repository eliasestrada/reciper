<template>
    <div class="pt-3">
        <div class="row">
            <div class="col s12 m6 l3" v-for="recipe in recipes" :key="recipe.id">
                <div class="card hoverable">
                    <div class="card-image waves-effect waves-block waves-light">
                        <a :href="'/recipes/' + recipe.id" :title="recipe.intro">
                            <img class="activator" :src="'storage/small/images/' + recipe.image" :alt="recipe.title">
                        </a>
                    </div>
                    <div class="card-content min-h">
                        <span style="height:75%" class="card-title activator">
                            {{ recipe.title }}
                        </span>
                        <div style="height:25%">
                            <div class="left">
                                <btn-favs :recipe-id="recipe.id" :favs="returnFavs(recipe.id)" :user-id="userId"></btn-favs>
                            </div>
                            <div class="left">
                                <i class="fas fa-clock fa-1x z-depth-2 main-light circle red-text ml-5 mr-1"></i>
                                {{ recipe.time }} {{ mins }}
                            </div>
                            <i class="fas fa-ellipsis-h right fa-15x red-text activator"></i>
                        </div>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title">{{ recipe.title }}</span>
                        <div><i class="fas fa-times right red-text card-title"></i></div>
                        <a class="btn-small mt-3" :href="'/recipes/' + recipe.id">{{ go }}</a>
                        <p>{{ recipe.intro }}</p>
                    </div>
                </div>
            </div>
        </div>
    
        <infinite-loading v-show="!theEnd" @infinite="infiniteHandler"></infinite-loading>
    </div>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading';

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
                        } else {
                            this.theEnd = true
                        }
                    })
                    .catch(err => console.error(err));
            },
            infiniteHandler($state) {
                setTimeout(() => {
                    fetch(this.next)
                        .then(res => res.json())
                        .then(res => {
                            if (this.next != res.links.next && res.links.next != null) {
                                this.recipes = this.recipes.concat(res.data)
                                this.next = res.links.next
                            } else {
                                this.theEnd = true
                            }
                        })
                        .catch(err => console.error(err));
                    $state.loaded()
                }, 1000);
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
            returnFavs(recipe_id) {
                return this.favs.filter(fav => fav.recipe_id == recipe_id)
            }
        },
        components: {
            InfiniteLoading,
        }
    };
</script>