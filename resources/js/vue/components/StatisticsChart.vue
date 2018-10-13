<template>
    <div class="mt-4" style="min-width:700px">
        <line-chart :chart-data="data" :height="100" />
    </div>
</template>

<script>
import LineChart from '../LineChart.js'
export default {
    data() {
        return {
            data: [],
        }
    },

    mounted() {
        let root = this
        setInterval(function() {
            root.fetchData()
        }, 5000)
        this.fetchData()
    },
     
    methods: {
        fetchData() {
            fetch('api-statistics/likes-views-chart')
            .then(res => res.json())
            .then(data => this.data = data)
            .catch(err => console.error(err))
        }
    },

    components: {
        LineChart
    }
}
</script>