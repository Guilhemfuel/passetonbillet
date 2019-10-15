<template>
    <div class="section-recent-tickets">
        <h2 class="text-center text-warning title">{{trans('tickets.sell.public.recent')}}</h2>

        <div class="tickets-horizontal-list">

            <div id="scroll-left-tickets" class="scroll-btn" @click.prevent="scroll('left')">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
            </div>
            <div id="scroll-right-tickets" class="scroll-btn" @click.prevent="scroll('right')">
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </div>

            <div id="recent-tickets" class="tickets" ref="recentTickets">
                <div class="d-inline-flex px-3" v-if="recentTickets.length > 0">
                    <div v-for="ticket in recentTickets" class="ticket-wrap"
                         :key="ticket.id">
                        <ticket :ticket="ticket" :buying="true">
                        </ticket>
                    </div>
                </div>
                <div class="tickets-placeholders px-3 d-inline-flex" v-else>
                    <div class="placeholder">
                        <loader class="mx-auto"></loader>
                    </div>
                    <div class="placeholder">
                        <loader class="mx-auto"></loader>
                    </div>
                    <div class="placeholder">
                        <loader class="mx-auto"></loader>
                    </div>
                    <div class="placeholder">
                        <loader class="mx-auto"></loader>
                    </div>
                    <div class="placeholder">
                        <loader class="mx-auto"></loader>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: {},
        data() {
            return {
                recentTickets: [],
            }
        },
        mounted() {
            this.$http.get(this.route('api.home.resource', ['recent_tickets']))
                .then(response => {
                    this.recentTickets = response.data.data;
                });
        },
        computed: {},
        methods: {
            scroll(direction) {
                let elem = this.$refs["recentTickets"];
                this.sideScroll(elem, direction, 25, 365, 25);
            },
            sideScroll(element, direction, speed, distance, step) {
                let scrollAmount = 0;
                var slideTimer = setInterval(function () {
                    if (direction == 'left') {
                        element.scrollLeft -= step;
                    } else {
                        element.scrollLeft += step;
                    }
                    scrollAmount += step;
                    if (scrollAmount >= distance) {
                        window.clearInterval(slideTimer);
                    }
                }, speed);
            }
        }
    }
</script>