import withMethod from '../../modules/_withMethod';

export default {
    data() {
        return {
            iconClass: '',
            amount: this.items.length,
            audio: new Audio(this.audioPath),
        };
    },

    props: ['recipeId', 'items', 'userId', 'tooltip', 'audioPath'],

    created() {
        this.toggleActive();
    },

    methods: {
        fetchItems() {
            fetch(this.url, withMethod('post'))
                .then(res => res.text())
                .then(data => {
                    if (data != 'fail') {
                        this.iconClass = data;
                        this.playSoundEffect();
                        data == 'active' ? this.amount++ : this.amount--;
                    }
                })
                .catch(err => console.error(err));
        },

        playSoundEffect() {
            this.audio.volume = 0.3;
            this.audio.play();
        },

        toggleActive() {
            if (this.userId) {
                let that = this;
                let checkIfAddedBefore = this.items.filter(item => {
                    return that.recipeId == item.recipe_id && that.userId == item.user_id;
                });
                this.iconClass = checkIfAddedBefore.length > 0 ? 'active' : '';
            }
        },
    },
};
