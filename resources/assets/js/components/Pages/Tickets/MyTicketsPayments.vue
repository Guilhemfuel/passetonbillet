<template>
    <div class="col-12">

        <loader class="mx-auto" v-if="loading"></loader>
        <div class="row mt-3" v-else>

            <h3 class="card-title text-left mb-0">Mes prochains voyage</h3>
            <div v-for="ticket in tickets" :key="'post' + ticket.id" class="col-12">
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
              this.tickets = response.data.data;
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