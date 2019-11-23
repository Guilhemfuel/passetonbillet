<template>
    <div>
        <modal :is-open="trulyOpened"
               @close-modal="closeModal()"
               class="review-modal">

            <div id="previousModal" @click="previousModal">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </div>

            <div v-if="!this.$root.user.country_profil">

                <h3>{{ trans('profile.modal.verify_identity.complete_profil') }}</h3>

                <form method="post" :action="route('public.profile.country.add')">

                    <input type="hidden" name="_token" :value="form._token">

                    <input-country name="country_residence"
                                   :label="trans('profile.modal.verify_identity.country_residence')"
                                   validation="required"
                                   v-model="formCompleteProfil.country_residence"
                                   :placeholder="trans('profile.modal.verify_identity.country_residence')"
                    ></input-country>

                    <input-country name="nationality"
                                   :label="trans('profile.modal.verify_identity.nationality')"
                                   validation="required"
                                   v-model="formCompleteProfil.nationality"
                                   :placeholder="trans('profile.modal.verify_identity.nationality')"
                    ></input-country>

                    <input-date
                            name="birthdate"
                            v-model="formCompleteProfil.birthdate"
                            class-name="col-xs-12"
                            :label="trans('auth.register.birthdate')"
                            placeholder="DD/MM/YYYY"
                            format="dd/MM/yyyy"
                            value-format="dd/MM/yyyy"
                            default-value-format="DD/MM/YYYY">
                    </input-date>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-ptb-blue btn-block" @click.prevent="completeProfil">
                                {{trans('profile.modal.verify_identity.complete_profil')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div v-else>
                <div v-if="state == 'recap'">
                    <div class="modal-body row">
                        <div class="col-sm-12 col-md-12 text-center m-auto">
                            <h4 class="card-text text-center font-weight-bold">
                                {{trans('tickets.buy_modal.buy_ticket_of')}} {{ ticket.user.first_name }}
                            </h4>
                            <p class="card-text text-center font-weight-bold">
                                {{trans('tickets.buy_modal.instant_receive')}}
                            </p>

                            <div class="recap-ticket">

                                <h3>{{date.format('dddd D MMMM YYYY')}}</h3>

                                <div class="row d-flex align-items-center recap-time">
                                    <div class="col-5 from">
                                        <p class="city">{{ticket.train.departure_city.name}}</p>
                                        <p class="time">{{departure_time}}</p>
                                    </div>
                                    <div class="col-2 arrow px-2">
                                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-5 to">
                                        <p class="city">{{ticket.train.arrival_city.name}}</p>
                                        <p class="time">{{arrival_time}}</p>
                                    </div>
                                </div>
                            </div>

                            <div v-if="this.ticket.hasPdf">
                                <button class="btn btn-ptb btn-upper text-uppercase mt-3 w-100" @click.prevent="getAllCards">
                                    {{trans('tickets.component.buy')}} {{ ticket.price }}{{ ticket.currency_symbol }}
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <div v-else-if="state == 'show_cards'">
                    <div class="modal-body row">
                        <div class="col-sm-12 col-md-8 text-center m-auto">
                            <p class="card-text text-center font-weight-bold">
                                {{trans('tickets.buy_modal.choose_payment')}}
                            </p>

                            <label v-for="card in userCards" :key="card.Id" class="credit-card" :for="'card-' + card.Id">{{ card.Alias }}
                                <input type="radio" :id="'card-' + card.Id" name="card" :value="card.Id" @change="formBuy = card.Id">
                            </label>

                            <div>
                                <button class="btn-add-payment w-100" @click.prevent="addCardRegistration">
                                    {{trans('tickets.buy_modal.add_payment')}}
                                </button>
                            </div>

                            <div v-if="typeof userCards === 'object' && userCards[0]">
                                <button class="btn btn-ptb btn-upper text-uppercase mt-3 w-100"
                                        @click.prevent="buy">
                                    {{trans('tickets.component.buy')}} {{ ticket.price }}{{ ticket.currency_symbol }}
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <div v-else-if="state == 'add_card'">
                    <div class="modal-body row">
                        <div class="col-sm-12 col-md-8 text-center m-auto">
                            <p class="card-text text-center font-weight-bold">
                                {{trans('tickets.buy_modal.add_payment')}}
                            </p>

                            <form :action="CardRegistrationURL" method="post" id="formRegistrationCard" class="w-100 m-auto row">
                                <input type="hidden" name="data" :value="formRegistrationCard.data"/>
                                <input type="hidden" name="accessKeyRef" :value="formRegistrationCard.accessKeyRef"/>

                                <div class="col-12">
                                    <input type="text" name="cardNumber" value="" v-model="formRegistrationCard.cardNumber" placeholder="NUMÉRO DE LA CARTE"/>
                                    <div class="clear"></div>
                                </div>

                                <div class="col-6">
                                    <input type="text" name="cardExpirationDate"
                                           value="" v-model="formRegistrationCard.cardExpirationDate"
                                           placeholder="MM/AA" maxlength="5"/>
                                    <div class="clear"></div>
                                </div>

                                <div class="col-6">
                                    <input type="text" name="cardCvx" value="" v-model="formRegistrationCard.cardCvx" placeholder="CVC" maxlength="3"/>
                                    <div class="clear"></div>
                                </div>

                                <div class="col-sm-12 col-md-12">
                                    <button class="btn btn-ptb btn-upper mt-3 w-100" @click.prevent="saveCardRegistration">
                                        {{trans('tickets.buy_modal.add')}}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
  export default {
    props: {
      ticket: {required: true},
      isOpen: {required: false, default: null}
    },
    data() {
      return {
        state: 'recap',
        previousState: [],
        date: new moment(this.ticket.train.departure_date, 'YYYY-MM-DD') || null,
        form: {
          _token: window.csrf,
        },
        userCards: {},
        CardRegistrationURL: null,
        formCompleteProfil: {
          country_residence: null,
          nationality: null,
          birthdate: null,
        },
        formRegistrationCard: {
          data: null,
          accessKeyRef: null,
          cardNumber: null,
          cardExpirationDate: null,
          cardCvx: null,
          idCard: null,
        },
        formBuy: null,
      }
    },
    mounted() {

    },
    computed: {
      trulyOpened() {
        if (this.isOpen == true) {
          if (!this.$root.user) {
            this.state = '';
            window.location.href = this.route('login');
          }
          return true;
        }
        return false;
      },
      arrival_time: function () {
        return moment(this.ticket.train.arrival_time, 'HH:mm:ss').format('HH:mm')
      },
      departure_time: function () {
        return moment(this.ticket.train.departure_time, 'HH:mm:ss').format('HH:mm')
      }
    },
    watch: {
      state: function(newVal, oldVal) {
        if(oldVal !== newVal) {
          if (!(this.previousState.includes(oldVal))) {
            this.previousState.push(oldVal);
          }
        }
      }
    },
    methods: {
      closeModal() {
        this.$emit('close-modal');
      },
      previousModal() {
        if(this.previousState.includes(this.state)) {
          let position = this.previousState.indexOf(this.state);
          if (position > 0) {
            this.state = this.previousState[position - 1]
          } else {
            this.closeModal()
          }
        } else {
          if(this.previousState.length > 0) {
            this.state = this.previousState[this.previousState.length - 1]
          } else {
            this.closeModal()
          }
        }
      },
      handleResponse(response) {
        if(response.body.message) { this.$message({message: response.body.message, type: response.body.type}) }
      },
      completeProfil() {
        console.log(this.formCompleteProfil);
        this.$http.post(this.route('public.profile.country.add'), this.formCompleteProfil)
          .then(response => {
            this.handleResponse(response);
            if(response.body.type === 'success') {
              this.state = 'recap';
              this.$root.user.country_profil = true;
            }
          });
      },
      getAllCards() {
        this.$http.get(this.route('api.user.get.cards'))
          .then(response => {
            if(typeof response.body === 'object') {
              this.userCards = response.body;
            }
            this.state = 'show_cards';
          });
      },
      addCardRegistration() {
        this.$http.get(this.route('api.user.add.card.registration'))
          .then(response => {

            let data = response.body;

            this.CardRegistrationURL = data.CardRegistrationURL;

            this.formRegistrationCard.data = data.PreregistrationData;
            this.formRegistrationCard.accessKeyRef = data.AccessKey;
            this.formRegistrationCard.idCard = data.Id;

            this.state = 'add_card';
          });
      },
      saveCardRegistration() {

        Vue.http.interceptor.before = function (request) {
          request.headers.delete('X-Socket-ID');
          request.headers.delete('X-CSRF-TOKEN');
          request.headers.delete('Content-Type');
        };

        //Do not try to use JSON.stringify or give the full Object to Mangopay because it doesn't works.
        let serialize = 'data=' + this.formRegistrationCard.data + '&accessKeyRef=' + this.formRegistrationCard.accessKeyRef + '&cardNumber=' + this.formRegistrationCard.cardNumber + '&cardExpirationDate=' + this.formRegistrationCard.cardExpirationDate + '&cardCvx=' + this.formRegistrationCard.cardCvx;

        this.$http.post(this.CardRegistrationURL, serialize)
          .then(response => {

            Vue.http.interceptor.before = (request) => {
              request.headers.set('X-Socket-ID', window.Echo.socketId());
              request.headers.set('X-CSRF-TOKEN', this.form._token);
              request.headers.set('Content-Type', 'application/json');
            };

            if(response.body.includes("errorCode")) {
              this.$message({message: this.trans('tickets.buy_modal.error'), type: 'error'})
            } else if (response.body.message) {
              this.$message({message: response.body.message, type: 'error'})
            } else {
              this.updateCardRegistration(response.body)
            }

          });
      },
      updateCardRegistration(data) {
        this.$http.post(this.route('api.user.update.card.registration'), {'data': data, 'id': this.formRegistrationCard.idCard})
          .then(response => {
            //Back to the user cards screen
            this.getAllCards()
          });
      },
      buy() {
        if(this.formBuy) {
          this.$http.post(this.route('api.ticket.buy', [this.ticket.id]), {'idCard': this.formBuy})
            .then(response => {
              console.log(response.body)
              if(response.body.redirect) {
                window.location.href = response.body.redirect;
              } else if (response.body.message) {
                this.$message({message: response.body.message, type: 'error'})
              } else {
                this.$message({message: this.trans('tickets.buy_modal.error'), type: 'error'})
              }
            });
        }
      }
    }
  }
</script>

<style>
    #formRegistrationCard input {
        width: 100%;
        border-radius: 10px;
        margin: 5px 0;
        background-color: #f6f6f7;
        border: none;
        display: block;
        padding: 10px 10px;
        color: #8b8b8b;
        font-weight: bold;
        text-transform: uppercase;
    }

    #previousModal {
        color: #ff9600;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }

    .recap-ticket {
        background-color: #f6f6f7;
        border-radius: 10px;
    }

    .recap-ticket .recap-time {
        font-weight: bold;
        font-size: 18px;
    }

    .recap-ticket .recap-time p {
        margin: 0;
    }

    .recap-ticket h3 {
        font-weight: bold;
        text-align: center;
        color: #ff9600;
    }

    .btn-add-payment {
        border-radius: 10px;
        border: solid 1px #dedede;
        background-color: transparent;
        text-align: center;
        color: #4a4a4a;
        font-size: 16px;
        font-weight: bold;
        padding: 10px;
    }

    .btn-add-payment:hover {
        cursor: pointer;
        background-color: #f5f5f5;
    }

    .credit-card {
        display: block;
        margin: 10px 0;
        border-radius: 10px;
        border: solid 1px #dedede;
        background-color: transparent;
        text-align: center;
        color: #4a4a4a;
        font-size: 16px;
        font-weight: bold;
        padding: 10px;
    }

    .credit-card:hover {
        cursor: pointer;
        background-color: #f6f6f7;
    }

    .credit-card.selected {
        background-color: #f6f6f7;
    }
</style>