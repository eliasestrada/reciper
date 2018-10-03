<template>
    <div class="pt-3">
        <div class="row">
            <div class="col s12 m6 l3" v-for="recipe in recipes" :key="recipe.id">
                <div class="card hoverable">
                    <div class="card-image waves-effect waves-block waves-light">
                        <a :href="'/recipes/' + recipe.id" :title="recipe.title">
                            <img class="activator" :src="'storage/small/images/' + recipe.image" :alt="recipe.title">
                        </a>
                    </div>
                    <div class="card-content min-h">
                        <span style="height:75%" class="card-title activator">
                            {{ recipe.title_short }}
                        </span>
                        <div style="height:25%">
                            <div class="left" style="transform:translateY(-3px)">
                                <form v-if="favs" action="/favs" method="post" class="d-inline-block">
                                    <input type="hidden" name="_token" :value="csrf">
                                    <input type="hidden" name="recipe_id" :value="recipe.id">
                                    <button type="submit" class="p-0" style="background:none;border:none;">
                                        <i class="fas fa-star fa-15x star p-1" :class="userHasFav(recipe.id)"></i>
                                    </button>
                                </form>
                                <a v-else href="/login">
                                    <i class="fas fa-star fa-15x star"></i>
                                </a>
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
            };
        },
    
        props: {
            "go": { required: true },
            "favs": { default: null },
            "csrf": { required: true },
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
                    .catch(err => console.log(err));
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
                        .catch(err => console.log(err));
                    $state.loaded()
                }, 1000);
            },
            hash() {
                return window.location.hash.substring(1)
            },
            userHasFav(recipe) {
                if (this.favs) {
                    var result = this.favs.map(fav => {
                        return recipe == fav ? 'active' : '';
                    });
                    return result;
                }
            }
        },
        components: {
            InfiniteLoading,
        }
    };
</script>