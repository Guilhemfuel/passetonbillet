<template>
    <div class="col-sm-3 col-xs-6 pt-4">
        <div class="card pt-3">
            <h4 class="title text-center">
                <loader class="mx-auto" v-if="count==-1"></loader>
                <span v-else>{{count}}</span>
                <br>
                <a :href="link" class="stat-link">
                    <i :class="['fa fa-2x',icon]"></i>
                </a>
            </h4>
            <div class="card-body text-center">
                {{label}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            link: {type:String, required:true},
            icon: {type:String, required:true},
            label: {type:String, required:true},
            endpoint: {type:String, required:true},
        },
        data() {
            return {
                count: -1,

            }
        },
        mounted() {
            this.refreshCount();
            setInterval(() => this.refreshCount(), 60 * 1000);
        },
        computed: {},
        methods: {
            refreshCount() {
                this.$http.get(this.endpoint)
                    .then(response => {
                        this.count = response.data.count;
                    });
            }
        }
    }
</script>