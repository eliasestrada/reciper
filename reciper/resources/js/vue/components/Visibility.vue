<script>
export default {
    data() {
        return {
            type: 'password',
            icon: 'fa-eye',
        };
    },

    methods: {
        changeType() {
            if (this.type === 'password') {
                this.type = 'text';
                this.icon = 'fa-eye-slash';
            } else {
                this.type = 'password';
                this.icon = 'fa-eye';
            }
        },
    },
};
</script>