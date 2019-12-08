<template>
    <div class="card card-review">
    <div class="card-body">
        <el-rate
                class="rate"
                :value="review.mark"
                disabled
        ></el-rate>
        <p class="comment">
            {{ review.text }}
        </p>
    </div>
    <div class="card-footer">
        <div class="row m-0">
            <img
                    is-lazy="true"
                    v-lazy="review.picture" class="picture"
                    alt="user profile picture"/>
            <p class="col name">
                {{ review.name }}
            </p>
        </div>
    </div>
    </div>
</template>

<script>
    export default {
        props: {
            review: {type: Object, required:true}
        },
        data() {
            return {
            }
        },
        mounted() {

        },
        computed: {},
        methods: {

        }
    }
</script>