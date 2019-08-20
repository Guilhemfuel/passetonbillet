<template>
    <div class="train-results px-4 px-sm-0">
        <div class="train-tickets">

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
                affiliateTickets: [
                    {
                        "id": "FRPNO-GBSPX-20190830-20190830-26-NO_CARD-2-9007-false-FR",
                        "link": "https://www.oui.sncf/proposition?orig=FRPAR&dest=GBLON&departure=20190830-0713&roundtrip=N&direct=N&share=1&class=SECOND&profile_0=ADULT&nbpax=1&highlight=Y&nbTrains=1&trainNumber_0=9007&country=FR&va_ftc_a=101.00_30-08-2019_9007",
                        "departure_date": "2019-08-30T07:13:00",
                        "arrival_date": "2019-08-30T08:32:00",
                        "duration": 139,
                        "departure_city": {
                            "id": 4916,
                            "sncf_id": "FRPAR",
                            "name": "Paris",
                            "name_country_specific": null,
                            "short_name": null,
                            "slug": "paris",
                            "country": "FR"
                        },
                        "arrival_city": {
                            "id": 8267,
                            "sncf_id": "GBLON",
                            "name": "London",
                            "name_country_specific": "Londres",
                            "short_name": null,
                            "slug": "london",
                            "country": "GB"
                        },
                        "price": 101,
                        "stock": 26,
                        "type": "oui_sncf"
                    }
                ]
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