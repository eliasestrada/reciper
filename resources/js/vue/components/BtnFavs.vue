<template>
    <div>
        <a title="@lang('forms.login')" class="p-0" @click="fetchFavs">
            <i class="fas fa-star fa-15x star" :class="icon"></i>
            <span v-text="amount"></span>
        </a>
        <audio ref="audio" src="/storage/audio/favs-effect.mp3" class="hide" type="audio/mpeg"></audio>
    </div>
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

    props: ['recipeId', 'favs'],
     
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
                this.playSound()
                this.icon = data
                if (data == 'active') {
                    this.amount++
                } else {
                    this.amount--
                }
            })
            .catch(err => console.log(err))
        },
        toggleActive() {
            if (this.favs) {
                this.icon = this.favs.map(fav => {
                    return this.recipeId == fav ? 'active' : '';
                });
            }
        },
        playSound() {
            this.$refs.audio.volume = 0.2
            this.$refs.audio.play()
        },
    },
}
</script>