<script>
export default {
    data() {
        return {
            type: 'password',
            icon: 'visibility'
        }
    },
    
    methods: {
        changeType() {
            if (this.type === 'password') {
                this.type = 'text'
                this.icon = 'visibility_off'
            } else {
                this.type = 'password'
                this.icon = 'visibility'
            }
        }
    }
}
</script>