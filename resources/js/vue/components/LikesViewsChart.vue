<template>
    <div class="mt-4">
        <line-chart :chart-data="data" :height="100" :options="options" />
    </div>
</template>

<script>
import LineChart from '../LineChart.js'
export default {
    data() {
        return {
            data: [],
            options: {
                responsive: true,
                maintainAspect: true
            }
        }
    },

    created() {
        this.fetchData()
    },
     
    methods: {
        fetchData() {
            fetch('api-statistics/likes-views-chart')
            .then(res => res.json())
            .then(data => {
                this.data = data
            })
            .catch(err => console.log(err))
        }
    },

    components: {
        LineChart
    }
}
</script>