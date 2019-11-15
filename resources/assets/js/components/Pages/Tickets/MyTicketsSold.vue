<template>
    <div class="col-12">

        <h1 class="card-title text-left mb-0">{{trans('tickets.owned.title')}}</h1>

        <loader class="mx-auto" v-if="loading"></loader>
        <div class="row" v-else>
            <div v-for="ticket in tickets" :key="ticket.id" class="col-12">
                <ticket-sold :ticket="ticket"></ticket-sold>
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
      }
    },
    methods: {
      loadData() {
        if (this.tickets.length === 0) {
          this.$http.get(this.route('api.tickets.owned', ['selling']))
            .then(response => {
              this.tickets = response.data.data;
              this.loading=false;
              console.log(this.tickets);
            });
        } else {
          this.loading=false;
        }
      },
      formatedDate(date) {
        return new moment(date, 'YYYY-MM-DD').format('L');
      }
    },
    computed: {
    },
    mounted() {
      this.loadData();
    }
  }
</script>