<template>
    <div class="col-12">
        <div class="card card-buy-sell-welcome">
            <div class="card-body">
                <div class="buttons-search">
                    <button :class="{'btn':true, 'btn-lastar':state=='buy','btn-outline-purple':state!='buy'} " @click="switchState('buy')">{{lang.component.buy}}</button>
                    <button :class="{'btn':true, 'btn-lastar':state=='sell','btn-outline-purple':state!='sell'} " @click="switchState('sell')">{{lang.component.sell}}</button>
                </div>
                <div id="action-content">

                    <transition enter-class="pre-animated"
                                enter-active-class="animated fadeIn"
                                leave-active-class="animated fadeOut">
                        <div v-if="state=='buy'" class="pt-4">
                            <buy-ticket-welcome :lang="lang" :csrf="csrf" :routes="routes" :api="api" :stations="stations"></buy-ticket-welcome>
                        </div>
                    </transition>
                    <transition enter-class="pre-animated"
                                enter-active-class="animated fadeIn"
                                leave-active-class="animated fadeOut">
                        <div v-if="state=='sell'">
                            <sell-ticket-welcome :lang="lang" :csrf="csrf" :routes="routes" ></sell-ticket-welcome>
                        </div>
                    </transition>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            stations: {type: Array, required: true},
            api: {type: Object, required: true},
            routes: {type: Object, required: true},
            lang: {type: Object, required: true},
            csrf: {type: String, required:true},
            state: {type: String, Default: 'buy', required: true}
        },
        computed: {},
        methods: {
            switchState(newState) {
                this.$emit('change-state', newState);
            }
        }
    }
</script>