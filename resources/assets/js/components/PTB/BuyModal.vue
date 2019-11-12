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
                        Choisissez un moyen de paiement
                    </p>
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
      }
    }
  }
</script>