<template>
    <div>
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
                        <i class="fas fa-ellipsis-h right fa-15x red-text activator px-1"></i>
                    </div>
                </div>
                <div class="card-reveal">
                    <span class="card-title">{{ recipe.title }}</span>
                    <div><i class="fas fa-times right red-text card-title p-1"></i></div>
                    <a class="btn-small mt-3" :href="'/recipes/' + recipe.id">{{ go }}</a>
                    <p>{{ recipe.intro }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['recipes', 'go', 'mins', 'userId', 'favs'],

    methods: {
        returnFavs(recipe_id) {
            return this.favs.filter(fav => fav.recipe_id == recipe_id)
        }
    }
}
</script>