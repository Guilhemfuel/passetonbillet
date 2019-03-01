<template>
    <div class="col-12">

        <h1 class="card-title text-center mb-0">{{trans('tickets.owned.title')}}</h1>

        <div class="row px-5">
            <div class="col-12 text-center py-3">
                <div class="mx-auto">
                    <el-radio-group v-model="state" class="mr-2" :label="state" @change="rerender">
                        <el-radio-button :label="stateValues.selling">{{trans('tickets.owned.selling')}}</el-radio-button>
                        <el-radio-button :label="stateValues.sold">{{trans('tickets.owned.sold')}}</el-radio-button>
                    </el-radio-group>
                    <el-radio-group v-model="state" class="ml-2" :label="state" @change="rerender">
                        <el-radio-button :label="stateValues.offered">{{trans('tickets.owned.offers_sent')}}</el-radio-button>
                        <el-radio-button :label="stateValues.bought">{{trans('tickets.owned.bought')}}</el-radio-button>
                    </el-radio-group>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4" v-for="ticket in currentTickets" :key="ticket.id">
                <template v-if="state==stateValues.bought">
                    <ticket :ticket="ticket" :bought="true"></ticket>
                </template>
                <template v-else-if="state==stateValues.sold">
                    <ticket :ticket="ticket" :display="true"></ticket>
                </template>
                <template v-else-if="state==stateValues.selling">
                    <ticket :ticket="ticket"  :share-modal-default="justSold(ticket)"></ticket>
                </template>
                <template v-else-if="state==stateValues.offered">
                    <ticket :ticket="ticket"></ticket>
                </template>
            </div>
            <div class="col-12">
                <p class="text-center" v-if="currentTickets.length==0">
                    <template v-if="state==stateValues.bought">
                        {{trans('tickets.owned.no_bought_tickets')}} <a
                            :href="route('public.ticket.buy.page')">{{trans('tickets.owned.no_bought_tickets_cta')}}</a>
                    </template>
                    <template v-else-if="state==stateValues.sold">
                        {{trans('tickets.owned.no_sold_tickets')}} <a
                            :href="route('public.ticket.sell.page')">{{trans('tickets.owned.no_sold_tickets_cta')}}</a>
                    </template>
                    <template v-else-if="state==stateValues.selling">
                        {{trans('tickets.owned.no_selling_tickets')}} <a
                            :href="route('public.ticket.buy.page')">{{trans('tickets.owned.no_selling_tickets_cta')}}</a>
                    </template>
                    <template v-else-if="state==stateValues.offered">
                        {{trans('tickets.owned.no_offered_tickets')}} <a
                            :href="route('public.ticket.buy.page')">{{trans('tickets.owned.no_bought_tickets_cta')}}</a>
                    </template>
                </p>
            </div>
        </div>

    </div>
</template>

<script>

    export default {
        props: {
            tickets: {type: Array, required: true},
            boughtTickets: {type: Array, required: true},
            offerSent: {type: Array, required: true},
            lang: {type: Object, required: true},
            defaultState: {required: true},

            stateValues: {
                type: Object, default: () => {
                    return {
                        sold: 1,
                        bought: 2,
                        selling: 3,
                        offered: 4
                    }
                }
            },
        },
        data() {
            return {
                state: this.defaultState,
                rerenderer: 0
            }
        },
        computed: {
            sellingTickets: function () {
                var ticketsToReturn = [];
                for (var i = 0; i < this.tickets.length; i++) {
                    var now = moment();
                    var departure = moment(this.tickets[i].train.departure_date + this.tickets[i].train.departure_time, 'YYYY-MM-DD HH:mm:ss');
                    if (!now.isSameOrAfter(departure) && this.tickets[i].buyer == null) {
                        ticketsToReturn.push(this.tickets[i])
                    }
                }
                return ticketsToReturn;
            },
            soldTickets: function () {
                var ticketsToReturn = [];
                for (var i = 0; i < this.tickets.length; i++) {
                    if (this.tickets[i].buyer != null) {
                        ticketsToReturn.push(this.tickets[i])
                    }
                }
                return ticketsToReturn;
            },
            currentTickets: function () {
                var actualTickets = [];
                if (this.state == this.stateValues.sold) {
                    actualTickets = this.soldTickets;
                } else if (this.state == this.stateValues.bought) {
                    actualTickets = this.boughtTickets;
                } else if (this.state == this.stateValues.selling) {
                    actualTickets = this.sellingTickets;
                } else if (this.state == this.stateValues.offered) {
                    for (var i = 0; i < this.offerSent.length; i++) {
                        var ticket = this.offerSent[i].ticket;
                        ticket.offerStatus = this.offerSent[i].status;
                        ticket.offerPrice = this.offerSent[i].price;
                        ticket.discussionId = this.offerSent[i].id;
                        actualTickets.push(ticket);
                    }
                }

                function compare(a, b) {
                    if (a.train.departure_date < b.train.departure_date)
                        return 1;
                    if (a.train.departure_date > b.train.departure_date)
                        return -1;
                    return 0;
                }

                return actualTickets.sort(compare);
            }
        },
        methods: {
            // To fix the issue of rerendering we change the key
            rerender() {
                this.rerenderer = this.rerenderer + 1;
            },
            setPageTitle() {
                let basePath = 'ticket/owned/';
                switch (this.state) {
                    case 1:
                        window.history.pushState('My Tickets', 'My Tickets - Sold', 'sold');
                        break;
                    case 2:
                        this.$emit('changePath', 'selling')
                        window.history.pushState('My Tickets', 'My Tickets - Bought', 'bought');
                        break;
                        break;
                    case 3:
                        this.$emit('changePath', 'selling')
                        window.history.pushState('My Tickets', 'My Tickets - Selling', 'selling');
                        break;
                        break;
                    case 4:
                        this.$emit('changePath', 'selling')
                        window.history.pushState('My Tickets', 'My Tickets - Offers', 'offers');
                        break;
                        break;
                }

            },
            /**
             * Return true if on page because this ticket was just added to be sold on PTB
             * @param ticket
             * @returns {*|boolean}
             */
            justSold(ticket) {
                return this.$root.currentPage.data.addedTicket
                    && this.$root.currentPage.data.addedTicket.id == ticket.id
            }

        },
        watch: {
            state: function () {
                this.setPageTitle();
            }
        },
        mounted() {
            window.history.replaceState('My Tickets', 'My Tickets - Offers', '/ticket/owned/');
            this.setPageTitle();
        }
    }
</script>