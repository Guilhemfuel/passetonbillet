<template>
    <div class="card card-ticket card-ticket-small">
        <div class="card-travel-info">
            <div class="content">
                <div class="station">
                    <p class="station-short">
                        {{ticket.train.departure_city.short_name.substr(2, 5)}}
                    </p>
                    <p class="time">
                        {{departure_time}}
                    </p>
                </div>
                <div class="date">
                    <span class="day">{{date.format('D')}}</span>
                    <span class="month">{{date.format('MMMM')}}</span>
                </div>
                <div class="station">
                    <p class="station-short">
                        {{ticket.train.arrival_city.short_name.substr(2, 5)}}
                    </p>
                    <p class="time">
                        {{arrival_time}}
                    </p>
                </div>
            </div>
        </div>
        <div class="card-seller-info">
            <div class="price">
                <span v-if="ticket.currency == 'GBP'">
                    <template v-if="discussion && discussion.price!=ticket.price">
                        <span class="old-price">£{{ticket.price}}</span><span class="offer-price text-center">£{{discussion.price}}</span>
                    </template>
                    <template v-else>
                    <span class="text-center"></span> £{{ticket.price}}
                    </template>
                </span>
                <span v-if="ticket.currency == 'EUR'">
                    <template v-if="discussion.price && discussion.price!=ticket.price">
                        <span class="old-price">€{{ticket.price}}</span><span class="offer-price text-center">€{{discussion.price}}</span>
                    </template>
                    <template v-else>
                    <span class="text-center"></span> €{{ticket.price}}
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
            lang: {type: Object, required: true},
            user: {type: Object, required: false},
        },
        data() {
            return {
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