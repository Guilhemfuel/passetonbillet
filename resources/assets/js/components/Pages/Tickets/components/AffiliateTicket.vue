<template>
    <a target="_blank" :href="ticket.link" :class="[ticket.type,'ticket-horizontal','d-block']">
        <div class="container">
            <div class="row">
                <div class="trip-info d-flex">
                    <div class="price-duration">
                        <p class="price">€{{ticket.price}}</p>
                        <p class="duration">{{duration}}</p>
                    </div>
                    <svg height="100" width="30">
                        <polygon points="0,0 0,100 30,0 " style="fill:white;"/>
                    </svg>
                    <div class="trip col">
                        <div class="row justify-content-center align-content-center d-lg-flex d-none">
                            <div class="from">
                                <p class="city">{{ticket.departure_city.name}}</p>
                                <p class="time">{{departure_time}}</p>
                            </div>
                            <div class="arrow px-2">
                                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            </div>
                            <div class="to">
                                <p class="city">{{ticket.arrival_city.name}}</p>
                                <p class="time">{{arrival_time}}</p>
                            </div>
                        </div>
                        <div class="row flex-column justify-content-center align-content-center mobile-view d-lg-none d-flex">
                            <div class="from d-flex">
                                <p class="time">{{departure_time}}</p>
                                <p class="city">{{ticket.departure_city.name}}</p>
                            </div>
                            <div class="to d-flex">
                                <p class="time">{{arrival_time}}</p>
                                <p class="city">{{ticket.arrival_city.name}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col justify-content-between d-flex">

                    <div class="logo flex-grow-1">
                        <img v-if="ticket.type='oui_sncf'"
                                alt="provider logo"
                             src="/img/logo/logo-oui-sncf.png">
                    </div>

                    <!-- Displaying information -->
                    <div class="action-type d-none d-lg-flex">
                        <p class="ticket-type"
                           v-html="trans('tickets.component.type.second_hand')">
                        </p>
                        <button class="btn btn-ptb btn-upper ml-3">
                            {{trans('tickets.component.details')}}
                        </button>
                    </div>

                    <div class="action-type-mobile d-flex d-lg-none align-content-center justify-content-center flex-column">
                        <p class="ticket-type"
                           v-html="trans('tickets.component.type.new')">
                        </p>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </div>


                </div>
            </div>
        </div>
    </a>

</template>

<script>

    export default {
        props: {
            ticket: {type: Object, required: true},
        },
        data() {
            return {
                user: this.$root.user,
            }
        },
        mounted() {

        },
        computed: {
            arrival_time: function () {
                return moment(this.ticket.arrival_date).format('HH:mm')
            },
            departure_time: function () {
                return moment(this.ticket.departure_date).format('HH:mm')
            },
            duration: function () {
                return Math.floor(this.ticket.duration / 60) + 'h' + (this.ticket.duration % 60);
            },
        },
        methods: {
            ucFirst(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            },
        }
    }
</script>