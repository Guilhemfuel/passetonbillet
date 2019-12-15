<template>
    <div class="section-feedback" id="section-feedback">
        <h2 class="text-center text-warning title">{{trans('welcome.feedback.title')}}</h2>
        <div class="container-fluid">
            <div class="row px-5">
                <template v-if="reviews.length > 0">
                    <div class="px-2 col-12 col-md-4 mt-4" v-for="review in reviews" :key="review.id">
                       <Review :review="review"></Review>
                    </div>
                </template>
                <template v-else>
                    <div class="px-2 col-12 col-md-4 mt-4">
                        <div class="placeholder">
                            <loader class="mx-auto"></loader>
                        </div>
                    </div>
                    <div class="px-2 col-12 col-md-4 mt-4">
                        <div class="placeholder">
                            <loader class="mx-auto"></loader>
                        </div>
                    </div>
                    <div class="px-2 col-12 col-md-4 mt-4">
                        <div class="placeholder">
                            <loader class="mx-auto"></loader>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <ReviewModal></ReviewModal>
    </div>
</template>

<script>
    import ReviewModal from './components/ReviewModal';
    import Review from './components/Review';

    export default {
        components: {
            ReviewModal,
            Review
        },
        props: {},
        data() {
            return {
                reviews: [],
            }
        },
        mounted() {
            this.$http.get(this.route('api.home.resource', ['reviews']))
                .then(response => {
                    this.reviews = response.data.data;
                });
        },
        computed: {},
        methods: {
        }
    }
</script>