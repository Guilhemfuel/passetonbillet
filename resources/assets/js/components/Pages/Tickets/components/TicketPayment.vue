<template>
    <transition enter-class="pre-animated"
                enter-active-class="animated fadeIn"
                leave-active-class="animated fadeOut">
        <div class="my-ticket row">
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

                <div class="button-my-ticket-update">
                    <div class="tooltip-limit-claim">{{ trans('tickets.claim.claim_limit_reached') }}</div>
                    <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="help()">
                        {{ trans('tickets.component.help_button') }}
                    </button>
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
      help() {
        this.$emit('claimTicket', this.ticket)
      },
    },
    computed: {

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