<template>
    <transition enter-class="pre-animated"
                enter-active-class="animated fadeIn"
                leave-active-class="animated fadeOut">
        <div class="my-ticket" v-bind:class="{ 'claim': currentlyInClaim }">
            <div class="front">
                <div class="status-payment">
                    {{ statusTicket }}
                </div>

                <div class="d-flex justify-content-between departure">
                    <div>
                        <span class="font-weight-bold text-uppercase">{{ ticket.train.departure_city.name }}</span><br>
                        {{ ticket.train.departure_time }}
                    </div>

                    <div>
                        <i aria-hidden="true" class="fa fa-long-arrow-right"></i>
                    </div>

                    <div>
                        <span class="font-weight-bold text-uppercase">{{ ticket.train.arrival_city.name }}</span><br>
                        {{ ticket.train.arrival_time }}
                    </div>
                </div>

                <div class="font-weight-bold price">
                    {{ ticket.price }}{{ ticket.currency_symbol }}
                </div>

                <div class="button-my-ticket-update">
                    <div class="tooltip-limit-claim">{{ trans('tickets.claim.claim_limit_reached') }}</div>
                    <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="help()">
                        <span v-if="currentlyInClaim">
                            {{ trans('tickets.component.resolve') }}
                        </span>
                        <span v-else>
                            {{ trans('tickets.component.help_button') }}
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
  export default {
    props: {
      ticket: {required: true},
    },
    data() {
      return {
        timeLeft: 0,
        dateNow: moment().format('YYYY-MM-DD HH:mm:ss'),
      }
    },
    methods: {
      formatedDate(date) {
        return new moment(date, 'YYYY-MM-DD').format('L');
      },
      handleResponse(response) {
        if(response.body.message) { this.$message({message: response.body.message, type: response.body.status}) }
      },
      calculTimeLeft() {
        let dateBeforeTransfer = this.ticket.date_before_transfer;
        let claimLimitSeller = this.ticket.claim_limit_seller;

        if(this.ticket.has_claim) {
          if(claimLimitSeller > this.dateNow) {
            let diff = new moment(claimLimitSeller,"YYYY-MM-DD HH:mm:ss").diff(moment(this.dateNow,"YYYY-MM-DD HH:mm:ss"));
            this.timeLeft = Math.round(new moment.duration(diff).asHours());
          }
        }
        else {
          if(dateBeforeTransfer > this.dateNow) {
            let diff = new moment(dateBeforeTransfer,"YYYY-MM-DD HH:mm:ss").diff(moment(this.dateNow,"YYYY-MM-DD HH:mm:ss"));
            this.timeLeft = Math.round(new moment.duration(diff).asHours());
          }
        }
      },
      help() {
        this.$emit('claimTicket', this.ticket)
      },
    },
    computed: {
      currentlyInClaim() {
        if (this.ticket.has_claim && !this.ticket.status_claim) {
          return true;
        } else {
          return false;
        }
      },
      statusTicket() {

        let status_payout = this.ticket.status_transaction_payout;
        let status_claim = this.ticket.status_claim;

        if (this.timeLeft > 0) {
          if (this.timeLeft > 72) {
            this.timeLeft = Math.round(this.timeLeft / 24);
            return this.timeLeft + ' ' + this.trans('tickets.claim.days_left');
          }
          return this.timeLeft + ' ' + this.trans('tickets.claim.hours_left');
        }

        if (status_payout) {
          if (status_payout === 'SUCCEEDED') {
            return this.trans('tickets.claim.succeeded');
          }

          if (status_payout === 'CREATED') {
            return this.trans('tickets.claim.created');
          }

          if (status_payout === 'NO_BANK_ACCOUNT') {
            return this.trans('tickets.claim.no_bank_account');
          }

          if (status_payout === 'NO_KYC') {
            return this.trans('tickets.claim.no_kyc');
          }

          if (status_payout === 'FAILED') {
            return this.trans('tickets.claim.failed');
          }
        }

        if (status_claim) {
          if (status_claim === 'WON') {
            return this.trans('tickets.claim.won');
          }

          if (status_claim === 'LOST') {
            return this.trans('tickets.claim.lost');
          }

          if (status_claim === 'EQUALITY') {
            return this.trans('tickets.claim.equality');
          }
        }
      }
    },
    mounted () {
      this.calculTimeLeft()
    }
  }
</script>