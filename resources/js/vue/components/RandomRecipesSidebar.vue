<template>
    <div>
        <div class="card" style="animation:appearWithRotate 1s;"
            v-for="recipe in recipes"
            :key="recipe.id">

            <div class="card-image">
                <a :href="'/recipes/' + recipe.id" :title="recipe.title">
                    <img :src="'/storage/images/' + recipe.image" :alt="recipe.title">
                </a>
            </div>
            <div class="card-content p-3">
                <p>{{ recipe.title }}</p>
            </div>
        </div>
    </div>
</template>

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