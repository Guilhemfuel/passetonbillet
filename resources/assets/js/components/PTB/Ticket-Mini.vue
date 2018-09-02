<template>
    <div class="card card-ticket card-ticket-small">
        <div class="card-travel-info">
            <div class="content">
                <div class="station">
                    <p class="station-short">
                        {{ticket.train.departure_city.name.replace(/\s/g, '').substr(0, 3)}}.
                    </p>
                    <p class="time">
                        {{departure_time}}
                    </p>
                </div>
                <div class="date">
                    <span class="day">{{date.format('D')}}</span>
                    <span class="month">{{date.format('MMM')}}</span>
                </div>
                <div class="station">
                    <p class="station-short">
                        {{ticket.train.arrival_city.name.replace(/\s/g, '').substr(0, 3)}}.
                    </p>
                    <p class="time">
                        {{arrival_time}}
                    </p>
                </div>
            </div>
        </div>
        <div class="card-seller-info">
            <div class="price">
                <span>
                    <template v-if="discussion && discussion.price!=ticket.price">
                        <span class="old-price">{{ticket.currency_symbol}}{{ticket.price}}</span>
                        <span class="offer-price text-center">{{ticket.currency_symbol}}{{discussion.price}}</span>
                    </template>
                    <template v-else>
                    <span class="text-center"></span> {{ticket.currency_symbol}}{{ticket.price}}
                    </template>
                </span>
            </div>
            <div class="ticket-number" v-if="user && ticket.user.id ==user.id">
                {{ticket.eurostar_ticket_number}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            ticket: {type: Object, required: true},
            discussion: {type: Object},
        },
        data() {
            return {
                user: this.$root.user,
                date: new moment(this.ticket.train.departure_date, 'YYYY-MM-DD') || null,
                editing: false,
                priceOffer: this.ticket.price,
                state: 'default',
                errorMessage: ''
            }
        },
        computed: {
            departure_time: function () {
                return moment(this.ticket.train.departure_time, 'HH:mm:ss').format('HH:mm')
            },
            arrival_time: function () {
                return moment(this.ticket.train.arrival_time, 'HH:mm:ss').format('HH:mm')
            },
            pastTicket: function () {
                var now = moment();
                var departure = moment(this.ticket.train.departure_date, 'YYYY-MM-DD');
                return now.isAfter(departure)
            },
        },
    }
</script>