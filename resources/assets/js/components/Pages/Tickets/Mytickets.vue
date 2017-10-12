<template>
    <div class="col-12">

        <div class="card" v-if="tickets.length==0">
            <div class="card-body">
                <h4 class="card-title">Your tickets</h4>
                <p class="card-text">
                    You don't have any tickets yet!
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 col-md-6 col-lg-4" v-for="ticket in tickets">
                <ticket :ticket="ticket" :lang="lang.component"></ticket>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: {
            tickets: {type: Array, required: true},
            routes: {type: Object, required: true},
            lang: {type: Object, required: true},
            user: {type: Object, required: true},
            csrf: {type: String, required:true},
        },
        data() {
            return {
                state: 'default',
            }
        },
        computed: {

        },
        methods: {

        }
    }
</script>