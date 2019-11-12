<template>
    <div class="call-component">
        <modal :is-open="trulyOpened"
               @close-modal="closeModal()"
               class="review-modal">

            <div v-if="state == 'recap'">
                <div class="modal-body">
                    <h3>Acheter le billet de {{ ticket.user.first_name }}</h3>
                    <p>Vous recevrez le billet instantanément</p>

                    <p>{{date.format('dddd D MMMM YYYY')}}</p>

                    <div>
                        <div class="from">
                            <p class="city">{{ticket.train.departure_city.name}}</p>
                            <p class="time">{{departure_time}}</p>
                        </div>
                        <div class="arrow px-2">
                            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        </div>
                        <div class="to">
                            <p class="city">{{ticket.train.arrival_city.name}}</p>
                            <p class="time">{{arrival_time}}</p>
                        </div>
                    </div>

                    <button v-if="this.ticket.hasPdf" class="btn btn-ptb btn-upper ml-3" @click.prevent="buyTicket">
                        {{trans('tickets.component.buy')}} {{ticket.bought_currency_symbol}}{{ticket.price}}
                    </button>
                </div>
            </div>

            <div v-else-if="state == 'buy_ticket'">
                <div class="modal-body">
                    <p class="card-text text-justify">
                        liste cartes test
                    </p>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <button class="btn btn-ptb btn-upper ml-3" @click.prevent="addCardRegistration">
                                Ajouter un moyen de paiement
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else-if="state == 'add_card'">
                <div class="modal-body">
                    <p class="card-text text-justify">
                        Title
                    </p>

                    <div class="row">
                        <form :action="CardRegistrationURL" method="post">
                            <input type="hidden" name="data" :value="formRegistrationCard.data"/>
                            <input type="hidden" name="accessKeyRef" :value="formRegistrationCard.accessKeyRef"/>

                            <label for="cardNumber">Card Number</label>
                            <input type="text" name="cardNumber" value="" v-model="formRegistrationCard.cardNumber"/>
                            <div class="clear"></div>

                            <label for="cardExpirationDate">Expiration Date</label>
                            <input type="text" name="cardExpirationDate" value="" v-model="formRegistrationCard.cardExpirationDate"/>
                            <div class="clear"></div>

                            <label for="cardCvx">CVV</label>
                            <input type="text" name="cardCvx" value="" v-model="formRegistrationCard.cardCvx"/>
                            <div class="clear"></div>

                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-ptb btn-upper ml-3" @click.prevent="saveCardRegistration">
                                        Ajouter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </modal>

        <phone-modal :is-open="modalPhoneOpen" @close-modal="modalPhoneOpen=false;"></phone-modal>
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
        modalPhoneOpen: false,
        modalBuyOpened: this.isOpen == null ? false : null,
        date: new moment(this.ticket.train.departure_date, 'YYYY-MM-DD') || null,
        form: {
          _token: window.csrf,
        },
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
      buyTicket() {
        this.$http.post(this.route('api.ticket.buy', [this.ticket.id]), this.form)
          .then(response => {
            this.handleResponse(response)
          });
      },
      addCardRegistration() {
        this.$http.get(this.route('api.ticket.add.card.registration'))
          .then(response => {

            console.log(response)

            let data = response.body;

            this.CardRegistrationURL = data.CardRegistrationURL;

            this.formRegistrationCard.data = data.PreregistrationData;
            this.formRegistrationCard.accessKeyRef = data.AccessKey;

            console.log()

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
        this.$http.post(this.route('api.ticket.update.card.registration'), {'data': data, 'id': this.formRegistrationCard.idCard})
          .then(response => {
            console.log(response)
          });
      }
    }
  }
</script>