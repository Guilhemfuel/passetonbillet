<template>
    <div class="flip-container">
        <div :class="{'flipper':true, 'flipped':editing}">
            <div :class="[className,{'card':true, 'card-ticket':true, 'front':true}]">
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
                    <template v-if="!pastTicket && !display">
                        <button class="btn btn-pink btn-buy btn-sm" v-if="!selecting && buying" @click="editing=true">
                            {{lang.buy}}
                        </button>
                        <button class="btn btn-pink btn-buy btn-sm" v-if="selecting" @click.prevent="sell">
                            {{lang.sell}}
                        </button>
                        <button class="btn btn-pink btn-buy btn-sm" v-if="bought" @click="editing=true">
                            {{lang.infos}}
                        </button>
                    </template>
                    <template v-if="!pastTicket && (user && ticket.user.id == user.id) && !display">
                        <button class="btn btn-pink btn-buy btn-sm" @click="editing=true">{{lang.edit}}</button>
                    </template>

                    <div class="price" v-if="!selecting">
                        <span v-if="ticket.currency == 'GBP'">£{{ticket.price}}</span>
                        <span v-if="ticket.currency == 'EUR'">€{{ticket.price}}</span>
                    </div>
                    <div class="price" v-if="selecting">
                        <span v-if="ticket.bought_currency == 'GBP'">£{{ticket.bought_price}}</span>
                        <span v-if="ticket.bought_currency == 'EUR'">€{{ticket.bought_price}}</span>
                    </div>
                    <div class="seller" v-if="!selecting">
                        {{lang.sold_by}} <b>{{ticket.user.full_name}}</b>
                    </div>
                </div>
            </div>
            <div :class="{'card':true, 'card-ticket':true, 'back':true, className:className, 'past-ticket':pastTicket}">
                <!-- User modifying his ticket-->
                <template v-if="!buying">
                    <template v-if="bought">
                        <div class="card-travel-info">
                            <a href="#" class="float-left" @click.prevent="editing=false"><i
                                    class="fa fa-chevron-circle-left"
                                    aria-hidden="true"></i></a>
                            <p class="float-center text-center mb-0 edit-title">{{lang.infos}}</p>
                        </div>
                        <div class="card-seller-info card-buying">
                            <p >{{lang.booking_name}}: <span class="text-primary">{{ticket.buyer_name}}</span></p>
                            <p >{{lang.booking_code}}: <span class="text-primary">{{ticket.eurostar_code}}</span></p>
                        </div>
                    </template>
                    <template v-else>
                        <div class="card-travel-info">
                            <a href="#" class="float-left" @click.prevent="editing=false"><i
                                    class="fa fa-chevron-circle-left"
                                    aria-hidden="true"></i></a>
                            <p class="float-center text-center mb-0 edit-title">{{lang.edit_ticket}}</p>
                        </div>
                        <div class="card-seller-info card-buying" v-if="(user && ticket.user.id == user.id)">
                            <p>{{lang.delete}}</p>
                            <form method="POST" :action="deleteUrl(ticket.id)">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" :value="csrf">
                                <input type="hidden" name="ticket_id" :value="ticket.id">
                                <button class="btn btn-danger mx-auto d-block mt-3">Delete ticket</button>
                            </form>
                        </div>
                    </template>
                </template>
                <!-- User buying the ticket-->
                <template v-else>
                    <div class="card-travel-info">
                        <a href="#" class="float-left" @click.prevent="editing=false"><i
                                class="fa fa-chevron-circle-left"
                                aria-hidden="true"></i></a>
                        <p class="float-center text-center mb-0 edit-title">{{lang.buy_ticket}}</p>
                    </div>
                    <div class="card-seller-info card-buying">
                        <template v-if="state=='default'">

                            <p class="text-center"><b>{{date.format('dddd, MMMM Do YYYY')}}</b></p>
                            <p class="text-center"><b>{{departure_time}}</b> {{ticket.train.departure_city.name}}</p>
                            <p class="text-center"><b>{{arrival_time}}</b> {{ticket.train.arrival_city.name}}</p>
                            <p class="text-center">{{lang.sold_by}} <b
                                    class="text-primary">{{ticket.user.full_name}}</b>
                            </p>
                            <form class="row mt-2" v-if="state=='default'">
                                <div class="col-12 text-center">
                                 <span v-if="errors.has('price')||errorMessage!=''" class="invalid-feedback">
                                    {{errors.has('price') ? errors.first('price') : errorMessage}}
                                </span>
                                </div>
                                <div class="col-12 col-sm-10 col-md-8 mx-auto">

                                    <div class="input-group">
                                        <span class="input-group-addon">{{ticket.currency == 'GBP' ? '£' : '€'}}</span>
                                        <input type="text"
                                               :class="'form-control' + (errors.has('price')?' is-invalid':'')"
                                               :aria-label="lang.price"
                                               :placeholder="lang.price"
                                               v-model="priceOffer"
                                               name="price"
                                               v-validate="'required|numeric|min_value:0|max_value:'+ticket.price">
                                    </div>
                                    <button class="btn btn-pink btn-block mt-2" @click.prevent="makeOffer">
                                        {{lang.send_offer}}
                                    </button>

                                </div>
                                <p class="text-center mt-2">{{lang.if_interested}}</p>
                            </form>
                        </template>
                        <div v-else-if="state=='offering'">
                            <loader class-name="mx-auto mt-4"></loader>
                        </div>
                        <template v-else-if="state=='offered'">
                            <p>Le vendeur a bien reçu votre offre! Il vous recontactera si il est interessé.</p>
                        </template>
                        <template v-else-if="state=='register'" >
                            <p class="text-center">La sécurité est notre premier soucis. Ainsi, vous devez etre inscrit pour commnuniquer avec les autres membres. <br><br> <a :href="routes.register">Inscrivez-vous pour envoyer votre offre!</a></p>
                        </template>
                    </div>

                </template>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            ticket: {type: Object, required: true},
            api: {type: Object, required: false},
            routes: {type: Object, required: false},
            lang: {type: Object, required: true},
            user: {type: Object, required: false, default:null},
            // Selecting when user is selling a ticket (no in db yet, no user)
            selecting: {type: Boolean, default: false},
            // If the ticket is dislayed on the buying page
            buying: {type: Boolean, default: false},
            // Display only Mode
            display: {type: Boolean, default: false},

            bought: {type: Boolean, default: false},
            csrf: {type: String, required:false},


            className: '',
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
        mounted(){
            if (this.offerDone){
                this.state=='offered';
            }
        },
        computed: {
            departure_time: function () {
                return moment(this.ticket.train.arrival_time, 'HH:mm:ss').format('HH:mm')
            },
            arrival_time: function () {
                return moment(this.ticket.train.departure_time, 'HH:mm:ss').format('HH:mm')
            },
            pastTicket: function () {
                var now = moment();
                var departure = moment(this.ticket.train.departure_date, 'YYYY-MM-DD');
                return now.isAfter(departure)
            },
            offerDone: function () {
                if (this.buying && this.user){
                    return this.user.offers_sent.includes(this.ticket.id);
                }
                return false;
            },
        },
        methods: {
            sell() {
                if (!this.selecting) return;
                this.$emit('sell', this.ticket.id);
            },
            deleteUrl(ticket_id) {
                if (!this.routes.tickets || !this.routes.tickets.delete) return null;
                return this.routes.tickets.delete.replace('ticket_id',ticket_id)
            },
            makeOffer() {


                if (this.user == undefined || this.user == null){
                    this.state = 'register';
                    console.log(this.state);
                    return;
                }
                console.log(this.user);

                this.$validator.validateAll().then((result) => {
                    this.state = 'offering';
                    this.errorMessage = '';
                    this.$http.post(this.api.tickets.offer, {
                        price: this.priceOffer,
                        ticket_id: this.ticket.id
                    }).then(response => {
                        // Success in offer
                        if (response.ok) {
                            this.state = 'offered';
                            return;
                        }
                    }, response => {
                        if (!response.ok) {
                            this.state = 'default';
                            this.errorMessage = response.body.message;
                        }
                    });
                });
            }
        }
    }
</script>