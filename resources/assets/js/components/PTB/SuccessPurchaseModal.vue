<template>
    <modal :is-open="isOpen"
           @close-modal="isOpen = false"
           class="review-modal">
        <div>
            <div class="modal-body row">
                <div class="col-sm-12 col-md-12 text-center m-auto">
                    <h4 class="card-text text-center font-weight-bold">
                        {{trans('tickets.buy_modal.have_good_trip')}}
                    </h4>

                    <div class="col-12 d-flex justify-content-center">
                        <div class="paper-plane-success">
                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="col-12">
                        {{trans('tickets.buy_modal.send_email_to')}} {{ email }}
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <a class="btn btn-ptb btn-upper mt-3 w-100" :href="this.route('public.ticket.download', [this.ticketId])" target="_blank">
                            {{trans('tickets.component.download_ticket')}}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </modal>
</template>

<script>
  export default {
    props: {
      ticketId: {required: true},
      email: {required: true},
    },
    data() {
      return {
        isOpen: true,
      }
    },
    mounted() {
    },
    computed: {},
    watch: {},
    methods: {
      downloadTicket() {
        window.location.href = this.route('public.ticket.download', [this.ticketId]);
      }
    }
  }
</script>