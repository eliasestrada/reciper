<template>
    <div class="mt-4" style="min-width:700px">
        <line-chart :chart-data="data" :height="100" :options="options" />
    </div>
</template>

<script>
import LineChart from '../LineChart.js'
export default {
    data() {
        return {
            data: [],
            options: {}
        }
    },

    mounted() {
        setInterval(function() {
            fetch('api-statistics/likes-views-chart')
                .then(res => res.json())
                .then(data => this.data = data)
                .catch(err => console.error(err));
        }, 5000)

        fetch('api-statistics/likes-views-chart')
            .then(res => res.json())
            .then(data => {
                this.data = data
                this.options = data.options
            })
            .catch(err => console.error(err));
    },

    components: {
        LineChart
    }
}
</script>