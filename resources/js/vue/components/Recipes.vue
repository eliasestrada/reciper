<template>
    <div class="pt-3">
        <div class="row">
            <div class="col s12 m6 l3" v-for="recipe in recipes" :key="recipe.id">
                <div class="card hoverable">
                    <div class="card-image waves-effect waves-block waves-light">
                        <a :href="'/recipes/' + recipe.slug" :title="recipe.intro">
                            <img class="activator lazy-load-img"
                                :src="`storage/blur/recipes/${recipe.image}`"
                                :data-lazy-load="`storage/small/recipes/${recipe.image}`"
                                :alt="recipe.title"
                            >
                        </a>
                    </div>
                    <div class="card-content min-h">
                        <span style="height:75%" class="card-title activator">
                            {{ recipe.title }}
                        </span>
                        <div style="height:25%">
                            <div class="left">
                                <btn-favs
                                    :recipe-id="recipe.id"
                                    :audio-path="audioPath"
                                    :items="returnFavs(recipe.id)"
                                    :tooltip="tooltip"
                                    :user-id="userId"
                                ></btn-favs>
                            </div>
                            <span class="left card-time">
                                <i class="fas fa-clock fa-1x z-depth-2 main-light circle red-text ml-5 mr-1"></i>
                                {{ recipe.time }} {{ mins }}
                            </span>
                            <i class="fas fa-ellipsis-h right fa-15x red-text activator px-1"></i>
                        </div>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title">{{ recipe.title }}</span>
                        <div>
                            <i class="fas fa-times right red-text card-title p-1"></i>
                        </div>
                        <a class="btn-small mt-3" :href="`/recipes/${recipe.slug}`">{{ go }}</a>
                        <p>{{ recipe.intro }}</p>
                    </div>
                </div>
            </div>
        </div>

        <infinite-loading v-show="!theEnd" @infinite="infiniteHandler"></infinite-loading>
    </div>
</template>

<script>
import InfiniteLoading from "vue-infinite-loading";
import LazyLoadImages from "../../modules/_lazyLoadImages";

export default {
    data() {
        return {
            recipes: [],
            newRecipes: [],
            next: "",
            theEnd: false
        };
    },

    props: {
        go: { required: true },
        favs: { default: null },
        userId: { default: null },
        mins: { default: "min" },
        audioPath: { required: true },
        tooltip: { required: true }
    },

    created() {
        this.makeFirstRequest();

        window.onhashchange = () => {
            this.theEnd = false;
            this.makeFirstRequest();
        };
    },

    methods: {
        makeFirstRequest() {
            Event.$emit("hash-changed", this.hash());

            this.$axios.get(`/api/recipes/${this.hash()}`)
                .then(res => {
                    this.recipes = res.data.data
                    this.runLazyLoadImagesFunction()

                    res.data.links.next != null
                        ? (this.next = res.data.links.next)
                        : (this.theEnd = true)
                })
                .catch(err => console.error(err));
        },

        infiniteHandler($state) {
            setTimeout(() => {
                this.$axios.get(this.next)
                    .then(res => {
                        if (this.next != res.data.links.next && res.data.links.next != null) {
                            this.recipes = this.recipes.concat(res.data.data);
                            this.next = res.data.links.next;
                        } else {
                            this.theEnd = true;
                        }
                    })
                .catch(err => console.error(err));
                $state.loaded();
            }, 1000);
        },

        hash() {
            return window.location.hash.substring(1);
        },

        userHasFav(recipe_id) {
            if (this.favs) {
                var result = this.favs.map(fav => {
                    return recipe_id == fav.recipe_id ? "active" : "";
                });
                return result;
            }
        },

        returnFavs(recipe_id) {
            return this.favs.filter(fav => fav.recipe_id == recipe_id);
        },

        runLazyLoadImagesFunction() {
            setTimeout(() => {
                LazyLoadImages()
            }, 100);
        },
    },

    components: {
        InfiniteLoading
    }
}
</script>
