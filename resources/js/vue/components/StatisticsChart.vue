<template>
    <div class="mt-4" style="min-width:700px">
        <line-chart :chart-data="data" :height="120" :options="options" />
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
        let root = this
        this.fetchData()
        setInterval(function() {
            root.fetchData()
        }, 5000)
    },

    methods: {
        fetchData() {
            fetch('api-statistics/popularity-chart')
                .then(res => res.json())
                .then(data => {
                    this.data = data
                    this.options = data.options
                })
                .catch(err => console.error(err));
        }
    },

    components: {
        LineChart
    }
}
</script>