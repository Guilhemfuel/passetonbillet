<template>
    <div class="train-results px-4 px-sm-0">
        <div class="train-tickets">

            <ads type="megabanner" class="mt-3"></ads>

            <ads type="pave_bas" class="mt-3"></ads>


            <horizontal-ticket v-for="ticket in tickets"
                               :ticket="ticket"
                               :key="ticket.id"
                               class="mt-3"
            ></horizontal-ticket>

        </div>

        <div class="affiliate-train-tickets">

            <affiliate-ticket v-for="ticket in affiliateTickets"
                              :ticket="ticket"
                              :key="ticket.id"
                              class="mt-3"
            ></affiliate-ticket>

        </div>

    </div>
</template>

<script>
    import AffiliateTicket from './AffiliateTicket';

    export default {
        components: {
            'affiliate-ticket': AffiliateTicket
        },
        props: {
            searchValue: {required: true, type: Object},
        },
        data() {

            return {
                user: this.$root.user,
                loading: false,
                tickets: [],
                affiliateTickets: []
            }
        },
        mounted() {
            this.$root.$on('search', () => {
                this.search()
            });

            this.search();
        },
        computed: {
            ticketsWithOffers() {
                // Add offer information to each ticket
                var tickets = this.tickets;
                if (this.user == null || this.user.offers_sent === {}) return tickets;
                for (var i = 0; i < tickets.length; i++) {
                    for (var key in this.user.offers_sent) {
                        if (this.user.offers_sent[key].ticket_id == tickets[i].id) {
                            tickets[i].discussionId = this.user.offers_sent[key].id;
                            tickets[i].offerStatus = this.user.offers_sent[key].status;
                            tickets[i].offerPrice = this.user.offers_sent[key].price;
                        }
                    }
                }
                return tickets;
            }
        },
        methods: {
            updateLoading(value) {
                this.loading = value;
                this.$emit('loading', value);
            },
            search() {

                if (this.loading) return null;

                this.updateLoading(true);

                // Search tickets
                this.$http.get(this.route('api.tickets.buy'), {params: this.searchValue})
                    .then(response => {

                        this.$nextTick(() => {
                            this.updateLoading(false);
                            this.tickets = response.data.data;
                        });

                        // Log search
                        this.$root.logEvent('ticket_search', this.search);

                    }, response => {
                        this.updateLoading(false);
                        this.$message({
                            dangerouslyUseHTMLString: true,
                            message: this.trans('common.error'),
                            type: 'error',
                            showClose: true,
                            duration: 500
                        });
                    });

                // Search affiliates
                this.$http.get(this.route('api.tickets.affiliates.sncf'), {params: this.searchValue})
                    .then(response => {

                        this.$nextTick(() => {
                            this.affiliateTickets = response.data;
                        });

                    }, response => {
                        this.affiliateTickets = []
                    });
            }
        }
    }
</script>