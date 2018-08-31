<template>
    <div class="review mt-2" v-if="this.user && !submitted">
        <p class="text-center mb-0">
            <a href="#"
               @click.prevent="modalReviewOpened=true">{{trans('common.review.link')}}</a>
        </p>
        <modal :is-open="modalReviewOpened"
               @close-modal="modalReviewOpened=false"
               :title="trans('common.review.modal.title')"
               class="review-modal">

            <vue-form class="container-fluid" :callback="sendReview">
                <div class="row">
                    <div class="col-12">
                        <p>{{trans('common.review.modal.text')}}</p>
                    </div>
                    <div class="col-12 mb-4 text-center">
                        <el-rate v-model="review.mark"
                                 class="mx-auto"
                                 text-color="#FF9600"

                        ></el-rate>

                    </div>

                    <input-textarea-basic name="text"
                                          v-model="review.text"
                                          validation="required"
                                          :placeholder="trans('common.review.modal.placeholder')"
                                          class="col-12"
                    >

                    </input-textarea-basic>
                    <div class="col-12">
                        <button class="btn btn-block btn-ptb" type="submit">
                            {{trans('common.review.modal.send')}}
                        </button>
                    </div>
                </div>
            </vue-form>
        </modal>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                modalReviewOpened: false,
                review: {
                    mark: 0,
                    text: ""
                },
                submitted: false,
                user: this.$root.user
            }
        },
        computed: {},
        methods: {
            sendReview() {
                this.$http.post(this.route('api.reviews.store'), this.review).then(response => {

                    // Sucess
                    this.modalReviewOpened = false;
                    this.submitted = true;

                    this.$message({
                        message: this.trans('common.review.thanks'),
                        type: 'success',
                        duration: 5000
                    });

                }, response => {
                    // failure
                    this.$message({
                        message: this.trans("common.error"),
                        type: 'error',
                        duration: 5000
                    });
                    this.modalReviewOpened = false;
                    this.submitted = true;
                });
            }
        }
    }
</script>