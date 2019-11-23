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
        let dateBeforeTransfer = this.ticket.dateBeforeTransfer;
        let claimLimitSeller = this.ticket.claimLimitSeller;

        if(this.ticket.hasClaim) {
          if(claimLimitSeller > this.dateNow) {
            let diff = new moment(claimLimitSeller,"YYYY-MM-DD HH:mm:ss").diff(moment(this.dateNow,"YYYY-MM-DD HH:mm:ss"));
            this.timeLeft = Math.round(new moment.duration(diff).asHours());
          }
        }
        else {
          console.log(dateBeforeTransfer)
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
        if (this.ticket.hasClaim && !this.ticket.statusClaim) {
          return true;
        } else {
          return false;
        }
      },
      statusTicket() {

        let status_payout = this.ticket.statusTransactionPayout;
        let status_claim = this.ticket.statusClaim;

        if (this.timeLeft > 0) {
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
      console.log(this.ticket);
      this.calculTimeLeft()
    }
  }
</script>

<style scoped>
    .my-ticket {
        border-radius: 20px;
        background-color: white;
        margin: 10px 0;
        padding: 20px;
    }

    .my-ticket > div {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: center;
        color: #545454;
    }

    .my-ticket .status-payment {
        font-weight: bold;
        border: 3px solid #0b89e7;
        border-radius: 10px;
        padding: 10px;
    }

    .my-ticket.claim .status-payment {  border: 3px solid white;  }

    .my-ticket.claim {  background-color: #f8254a;  }

    .my-ticket.claim > div {  color: white;  }

    .my-ticket > div > div {  margin: 0 10px;  }

    .my-ticket .departure {  width: 350px;  }

    .tooltip-limit-claim {
        background-color: rgba(0, 0, 0, 0.85);
        color: white;
        position: absolute;
        font-size: 11px;
        border-radius: 10px;
        width: 250px;
        margin-left: -260px;
        visibility: hidden;
        opacity: 0;
        transition: all 0.8s ease;
        padding: 5px;
    }

    .button-my-ticket-change:hover .tooltip-limit-claim {
        visibility: visible;
        opacity: 1;
    }

    @media screen and (max-width: 768px) {

        .my-ticket {  flex-direction: column;  }
        .my-ticket button {  margin-top: 10px;  }
    }

    .my-ticket .price {  font-size: 25px;  }

    .button-my-ticket-change, .button-my-ticket-update {  width: 200px;  }

    .button-my-ticket-update button {  background-color: #0b89e7;  }
    .button-my-ticket-change button {  background-color: #9b9b9b;  }
</style>