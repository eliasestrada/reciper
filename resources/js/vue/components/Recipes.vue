<template>
    <div class="pt-3">
        <div class="row">
            <div class="col s12 m6 l3" v-for="recipe in recipes" :key="recipe.id">
                <div class="card hoverable">
                    <div class="card-image waves-effect waves-block waves-light">
                        <a :href="`/recipes/${recipe.slug}`" :title="recipe.intro">
                            <div class="placeholder-image"
                                :style="{ 'background-color': setRandomBgColor() }"
                            ></div>

                            <img class="activator lazy-load-img-vue"
                                :src="`storage/small/recipes/${recipe.image}`"
                                :alt="recipe.title"
                                @load="runLazyLoadImagesForVue($event.target)"
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
                        <a class="btn-small mt-3" :href="`/recipes/${recipe.slug}`">
                            {{ go }}
                        </a>
                        <p>{{ recipe.intro }}</p>
                    </div>
                </div>
            </div>
        </div>
        <preloader v-if="loading"></preloader>
    </div>
</template>

<script>
import LazyLoadImagesForVue from '../../modules/lazyLoadImagesForVue'
import Preloader from './templates/Preloader'

export default {
    data() {
        return {
            recipes: [],
            loading: false,
            url: null,
            theEnd: false,
        }
    },

    props: {
        go: { required: true },
        favs: { default: null },
        userId: { default: null },
        mins: { default: "min" },
        audioPath: { required: true },
        tooltip: { required: true },
    },

    created() {
        this.fetchRecipes(true)

        window.addEventListener('scroll', () => {
            if (!this.theEnd) {
                this.onScroll()
            }
        })

        window.onhashchange = () => {
            this.theEnd = false
            this.url = null
            this.fetchRecipes(true)
        }
    },

    methods: {
        fetchRecipes(reload = false) {
            this.loading = true

            const hash = window.location.hash.substring(1)
            const url = this.url === null ? `/api/recipes/${hash}` : this.url

            Event.$emit("hash-changed", hash)

            this.$axios.get(url)
                .then(res => {
                    if (res.data.links.next !== null) {
                        this.url = res.data.links.next
                    } else {
                        this.theEnd = true
                    }

                    this.recipes = reload ? res.data.data : this.recipes.concat(res.data.data)
                    this.loading = false
                })
                .catch(err => {
                    console.error(err)
                    this.loading = false
                })
        },

        onScroll() {
            const wrap = document.getElementById('recipes-page')
            const contentHeight = wrap.offsetHeight
            const yOffset = window.pageYOffset
            const currentPosition = yOffset + window.innerHeight

            if (currentPosition >= contentHeight && !this.loading) {
                this.fetchRecipes()
            }
        },

        userHasFav(recipe_id) {
            if (this.favs) {
                const result = this.favs.map(fav => {
                    return recipe_id == fav.recipe_id ? "active" : ""
                })
                return result
            }
        },

        returnFavs(recipe_id) {
            return this.favs.filter(fav => fav.recipe_id == recipe_id)
        },

        setRandomBgColor() {
            return `rgba(
                ${Math.floor(Math.random() * Math.floor(254))},
                ${Math.floor(Math.random() * Math.floor(254))},
                ${Math.floor(Math.random() * Math.floor(254))},
                0.3
            )`
        },

        runLazyLoadImagesForVue(target) {
            LazyLoadImagesForVue(target)
        }
    },

    components: {
        Preloader,
    }
}
</script>
