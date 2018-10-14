<template>
    <section>
        <a v-if="userId" class="p-0" @click="fetchFavs">
            <i class="fas fa-star fa-15x star" :class="icon"></i> 
            <span v-text="amount" style="transform:translate(-2px, 5px);color:#6b6b6b" class="d-inline-block"></span>
        </a>
        <a v-else href="/login" class="p-0">
            <i class="fas fa-star fa-15x star"></i> 
            <span v-text="amount" style="transform:translate(-4px, 5px);color:#6b6b6b" class="d-inline-block"></span>
        </a>
    </section>
</template>

<script>
export default {
    data() {
        return {
            icon: '',
            amount: this.favs.length
        }
    },

    created() {
        this.toggleActive()
    },

    props: {
        'recipeId': { required: true },
        'favs': { default: null },
        'userId': { default: null },
    },
     
    methods: {
        fetchFavs() {
            fetch('/favs/' + this.recipeId, {
                method: "POST",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                })
            })
                .then(res => res.text())
                .then(data => {
                    if (data != 'fail') {
                        this.playSound()
                        this.icon = data
                        if (data == 'active') {
                            this.amount++
                        } else {
                            this.amount--
                        }
                    }
                })
                .catch(err => console.error(err))
        },
        toggleActive() {
            if (this.userId) {
                this.icon = this.favs.map(fav => {
                    return this.recipeId == fav.recipe_id && this.userId == fav.user_id ? 'active' : '';
                });
            }
        },
        playSound() {
            $('favs-effect').volume = 0.7
            $('favs-effect').play()
        },
    },
}
</script>