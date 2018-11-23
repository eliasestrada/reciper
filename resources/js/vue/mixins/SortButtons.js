export default {
    data() {
        return {
            btns: [
                {
                    title: this.newBtn,
                    icon: 'fa-clock',
                    link: 'new',
                    isActive: false,
                },
                {
                    title: this.mostLikedBtn,
                    icon: 'fa-heart',
                    link: 'most_liked',
                    isActive: false,
                },
                {
                    title: this.simpleBtn,
                    icon: 'fa-concierge-bell',
                    link: 'simple',
                    isActive: false,
                },
                {
                    title: this.breakfastBtn,
                    icon: 'fa-utensils',
                    link: 'breakfast',
                    isActive: false,
                },
                {
                    title: this.lunchBtn,
                    icon: 'fa-utensils',
                    link: 'lunch',
                    isActive: false,
                },
                {
                    title: this.dinnerBtn,
                    icon: 'fa-utensils',
                    link: 'dinner',
                    isActive: false,
                },
                {
                    title: this.myViewesBtn,
                    icon: 'fa-eye',
                    link: 'my_viewes',
                    isActive: false,
                },
            ]
        }
    }
}