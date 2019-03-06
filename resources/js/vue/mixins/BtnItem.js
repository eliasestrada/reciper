export default {
    data() {
        return {
            iconClass: '',
            amount: this.items.length,
            audio: document.querySelector('#click-audio'),
        }
    },

    props: ['recipeId', 'items', 'userId', 'tooltip', 'audioPath'],

    created() {
        this.toggleActive()
    },

    methods: {
        fetchItems() {
            this.$axios.post(this.url)
                .then(data => {
                    if (data.statusText === 'OK') {
                        this.iconClass = data.data
                        this.playSoundEffect()
                        data.data == 'active' ? this.amount++ : this.amount--
                    }
                })
                .catch(err => console.error(err))
        },

        playSoundEffect() {
            this.audio.volume = 0.1
            this.audio.play()
        },

        toggleActive() {
            if (this.userId) {
                let that = this
                let checkIfAddedBefore = this.items.filter(item => {
                    return that.recipeId == item.recipe_id && that.userId == item.user_id
                })
                this.iconClass = checkIfAddedBefore.length > 0 ? 'active' : ''
            }
        },
    },
}
