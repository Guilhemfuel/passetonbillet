<template>
    <div :class="'card card-ticket '+className">
        <div class="card-travel-info">
            <div class="day">
                <span>{{date.format('D')}}</span>
            </div>
            <div class="month">
                {{date.format('MMMM')}}
            </div>
            <div class="row cities">
                <div class="col-5 departure">
                    <i class="fa fa-train fa-2x" aria-hidden="true"></i><br>
                    <span class="city">{{ticket.train.departure_city.name}}</span><br>
                    <span class="time">{{arrival_time}}</span>
                </div>
                <div class="col-2 arrow">
                    <i class="fa fa-long-arrow-right fa-2x" aria-hidden="true"></i>
                </div>
                <div class="col-5 arrival">
                    <i class="fa fa-train fa-2x" aria-hidden="true"></i><br>
                    <span class="city">{{ticket.train.arrival_city.name}}</span><br>
                    <span class="time">{{departure_time}}</span>
                </div>
            </div>
        </div>
        <div class="card-seller-info">
            <button class="btn btn-pink btn-buy btn-sm" v-if="!selecting">{{lang.buy}}</button>
            <button class="btn btn-pink btn-buy btn-sm" v-if="selecting" @click.prevent="sell">{{lang.sell}}</button>

            <div class="price" v-if="!selecting">
                <span v-if="ticket.currency == 'GBP'">£{{ticket.price}}</span>
                <span v-if="ticket.currency == 'EUR'">€{{ticket.price}}</span>
            </div>
            <div class="price" v-if="selecting">
                <span v-if="ticket.bought_currency == 'GBP'">£{{ticket.bought_price}}</span>
                <span v-if="ticket.bought_currency == 'EUR'">€{{ticket.bought_price}}</span>
            </div>
            <div class="seller"  v-if="!selecting">
                {{lang.sold_by}} <b>{{ticket.user.full_name}}</b>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            ticket: {type: Object, required: true},
            lang: {type: Object, required: true},
            // Selecting when user is selling a ticket (no in db yet, no user)
            selecting: {type: Boolean, default: false},
            className: ''
        },
        data() {
            return {
                date: new moment(this.ticket.train.departure_date,'YYYY-MM-DD') || null
            }
        },
        computed: {
            departure_time: function() {
                return moment(this.ticket.train.arrival_time,'HH:mm:ss').format('HH:mm')
            },
            arrival_time: function() {
                return moment(this.ticket.train.departure_time,'HH:mm:ss').format('HH:mm')
            }
        },
        methods: {
            sell() {
                if(!this.selecting) return;
                this.$emit('sell',this.ticket.id);
            }
        }
    }
</script>