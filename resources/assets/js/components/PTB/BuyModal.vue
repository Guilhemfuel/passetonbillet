<template>
    <div>
        <modal :is-open="trulyOpened"
               @close-modal="closeModal()"
               class="review-modal">

            <div id="previousModal" @click="previousModal">
                <
            </div>

            <div v-if="state == 'recap'">
                <div class="modal-body row">
                    <div class="col-sm-12 col-md-12 text-center m-auto">
                        <h4 class="card-text text-center font-weight-bold">
                            Acheter le billet de {{ ticket.user.first_name }}
                        </h4>
                        <p class="card-text text-center font-weight-bold">
                            Vous recevrez le billet instantanément
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
                                Acheter {{ ticket.price }}{{ ticket.currency_symbol }}
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <div v-else-if="state == 'show_cards'">
                <div class="modal-body row">
                    <div class="col-sm-12 col-md-8 text-center m-auto">
                        <p class="card-text text-center font-weight-bold">
                            Choisissez un moyen de paiement
                        </p>

                        <label v-for="card in userCards" :key="card.Id" class="credit-card" :for="'card-' + card.Id">{{ card.Alias }}
                            <input type="radio" :id="'card-' + card.Id" name="card" :value="card.Id">
                        </label>

                        <div>
                            <button class="btn-add-payment w-100" @click.prevent="addCardRegistration">
                                Ajouter un moyen de paiement
                            </button>
                        </div>

                        <div v-if="typeof userCards === 'object' && userCards[0]">
                            <button class="btn btn-ptb btn-upper text-uppercase mt-3 w-100"
                                    @click.prevent="addCardRegistration">
                                Acheter {{ ticket.price }}{{ ticket.currency_symbol }}
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <div v-else-if="state == 'add_card'">
                <div class="modal-body row">
                    <div class="col-sm-12 col-md-8 text-center m-auto">
                        <p class="card-text text-center font-weight-bold">
                            Ajouter un moyen de paiement
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
                                    Ajouter
                                </button>
                            </div>
                        </form>
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
        modalBuyOpened: this.isOpen == null ? false : null,
        date: new moment(this.ticket.train.departure_date, 'YYYY-MM-DD') || null,
        form: {
          _token: window.csrf,
        },
        userCards: {},
        CardRegistrationURL: null,
        formRegistrationCard: {
          data: null,
          accessKeyRef: null,
          cardNumber: null,
          cardExpirationDate: null,
          cardCvx: null,
          idCard: null,
        }
      }
    },
    mounted() {
      console.log(this.ticket)
    },
    computed: {
      trulyOpened() {
        if (this.isOpen == true || this.modalBuyOpened == true) {
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
          console.log(this.previousState)
        }
      },
    },
    methods: {
      closeModal() {
        // Only update that if modal not controlled externally
        if (this.isOpen == null) {
          this.modalBuyOpened = false;
        }
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
        if (response.body.state) {
          if(response.body.state === 'phone_not_verified') {
            this.modalPhoneOpen = true
          } else {
            this.state = response.body.state;
          }
        }
        if (response.body.message) {
          this.$message({message: response.body.message, type: response.body.type})
        }
      },
      getAllCards() {
        this.$http.get(this.route('api.user.get.cards'))
          .then(response => {
            console.log(response)
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

            this.updateCardRegistration(response.body)
          });
      },
      updateCardRegistration(data) {
        this.$http.post(this.route('api.user.update.card.registration'), {'data': data, 'id': this.formRegistrationCard.idCard})
          .then(response => {
            console.log(response.body)
            //Back to the user cards screen
            this.getAllCards()
          });
      },
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