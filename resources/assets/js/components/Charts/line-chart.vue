<script>
    import { Line } from 'vue-chartjs'

    export default {
        extends: Line,
        props: {
            dataset: {type: Object, required: false},
            animation: {type: Boolean, required: false, default: true},
            title: {type: String, required: false, default: null}
        },
        mounted () {
            this.renderChart(this.dataset,
                {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        animateRotate: this.animation
                    },
                    title: {
                        display: this.title != null,
                        text: this.title,
                        fontFamily: 'Assistant',
                        fontSize: 16
                    }
                });
        }
    }
</script>