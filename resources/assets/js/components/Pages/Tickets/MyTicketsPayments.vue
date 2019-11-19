<template>
    <div class="col-12">

        <loader class="mx-auto" v-if="loading"></loader>
        <div class="row mt-3" v-else>

            <h3 class="card-title text-left mb-0">Mes conflits</h3>
            <div v-for="ticket in ticketsWithClaims" :key="'post' + ticket.id" class="col-12">
                <div>
                    <ticket-payment :ticket="ticket" @claimTicket="claim"></ticket-payment>
                </div>
            </div>


            <h3 class="card-title text-left mb-0">Mes paiements en attente</h3>
            <div v-for="ticket in ticketsInWait" :key="'post' + ticket.id" class="col-12">
                <div>
                    <ticket-payment :ticket="ticket" @claimTicket="claim"></ticket-payment>
                </div>
            </div>

            <h3 class="card-title text-left mb-0">Mes paiements passés</h3>
            <div v-for="ticket in ticketsFinish" :key="'post' + ticket.id" class="col-12">
                <div>
                    <ticket-payment :ticket="ticket" @claimTicket="claim"></ticket-payment>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        tickets: [],
        ticketsWithClaims: null,
        ticketsInWait: null,
        ticketsFinish: null,
        loading: true,
        dateNow: Date.parse(new moment().format("YYYY[-]MM[-]DD")),
        ticketClaim: null,
      }
    },
    methods: {
      loadData() {
        if (this.tickets.length === 0) {
          this.$http.get(this.route('api.tickets.owned', ['payment']))
            .then(response => {
              this.tickets = response.data;

              console.log(this.tickets);

              this.ticketsWithClaims = response.data.ticketsWithClaims;
              this.ticketsInWait = response.data.ticketsInWait;
              this.ticketsFinish = response.data.ticketsFinish;

              this.loading = false;
            });
        } else {
          this.loading = false;
        }
      },
      claim(ticket) {
        this.ticketClaim = ticket;
      }
    },
    computed: {},
    mounted() {
      this.loadData();
    }
  }
</script>