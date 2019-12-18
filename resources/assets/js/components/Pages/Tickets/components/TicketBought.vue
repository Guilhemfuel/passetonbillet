<template>
    <transition enter-class="pre-animated"
                enter-active-class="animated fadeIn"
                leave-active-class="animated fadeOut">
        <div class="my-ticket">
            <div class="front">
                <div>
                    N°{{ ticket.id }}<br>
                    <span class="font-weight-bold">{{ formatedDate(ticket.train.departure_date) }}</span>
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

                <div class="button-responsive">
                    <div class="button-my-ticket-update mt-2 mr-2">
                        <a class="btn btn-ptb btn-upper text-uppercase w-100" :href="this.route('public.ticket.download', [this.ticket.id])" target="_blank">
                            {{ trans('tickets.component.download') }}
                        </a>
                    </div>

                    <div class="button-my-ticket-change mt-2">
                        <div v-if="isDisabled" class="tooltip-limit-claim">{{ trans('tickets.claim.claim_limit_reached') }}</div>
                        <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="help()" :disabled=isDisabled>
                            {{ trans('tickets.component.help_button') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
  export default {
    props: {
      ticket: {required: true}
    },
    data() {
      return {
      }
    },
    methods: {
      formatedDate(date) {
        return new moment(date, 'YYYY-MM-DD').format('L');
      },
      handleResponse(response) {
        if(response.body.message) { this.$message({message: response.body.message, type: response.body.status}) }
      },
      downloadTicket() {
        window.location.href = this.route('public.ticket.download', [this.ticket.id]);
      },
      help() {
        this.$emit('claimTicket', this.ticket)
      },
    },
    computed: {
      isDisabled() {
        let dateDeparture = this.ticket.train.full_departure_date;
        let claimLimitPurchaser = this.ticket.claim_limit_purchaser;
        let dateNow = moment().format('YYYY-MM-DD HH:mm:ss');

        //If departure has started
        if(dateDeparture <= dateNow) {
          //If the limit time for claim is reached we disable the help button
          if(dateNow > claimLimitPurchaser) {
            return true;
          }
        }

        return false;
      }
    }
  }
</script>