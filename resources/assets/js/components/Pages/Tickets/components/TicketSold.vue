<template>
    <transition enter-class="pre-animated"
                enter-active-class="animated fadeIn"
                leave-active-class="animated fadeOut">
        <div class="my-ticket row" v-if="!deletedTicket">

            <div v-if="!update" class="front">
                <div>
                    N°{{ ticket.id }}<br>
                    <span class="font-weight-bold">{{ formatedDate(ticket.created_at) }}</span>
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

                <div class="button-my-ticket-update" @click.prevent="update = true">
                    <button class="btn btn-ptb btn-upper text-uppercase w-100">
                        {{ trans('tickets.component.update') }}
                    </button>
                </div>

                <div class="button-my-ticket-share">
                    <button class="btn btn-ptb btn-upper text-uppercase w-100">
                        {{ trans('tickets.component.share_btn') }}
                    </button>
                </div>
            </div>

            <div v-else class="back">
                <div @click.prevent="update = false" class="back-to-front font-weight-bold">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i> Retour
                </div>

                <div class="col-2 input-group">
                    <span class="input-group-addon">{{ticket.currency_symbol}}</span>
                    <input type="text"
                           :class="'form-control'"
                           :aria-label="trans('tickets.component.price')"
                           :placeholder="trans('tickets.component.price')"
                           v-model="ticket.price"
                           name="price"
                           v-validate="'required|numeric|min_value:0|max_value:' + ticket.price">
                </div>

                <div class="button-my-ticket-update">
                    <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="updatePrice()">
                        {{ trans('tickets.component.update_price') }}
                    </button>
                </div>

                <div class="button-my-ticket-download">
                    <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="downloadTicket()">
                        {{ trans('tickets.component.download') }}
                    </button>
                </div>

                <div class="button-my-ticket-change">
                    <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="changeTicket()">
                        {{ trans('tickets.component.change_pdf') }}
                    </button>
                </div>

                <div class="button-my-ticket-delete">
                    <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="deleteTicket()">
                        {{ trans('tickets.component.delete_button') }}
                    </button>
                </div>
            </div>

            <modal :is-open="openModal"
                   @close-modal="closeModal()"
                   class="review-modal">

                <div v-if="!loaderPdf">
                    <pdf-viewer @returnData="getPdf"></pdf-viewer>
                </div>

                <div v-else>
                    <transition enter-class="pre-animated"
                                enter-active-class="animated fadeIn"
                                leave-active-class="animated fadeOut">
                        <div class="card">
                            <div class="card-body">
                                <div class="p-5">
                                    <loader :class-name="'mx-auto'"></loader>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
            </modal>

            <modal :is-open="openDeleteModal"
                   @close-modal="closeModal()"
                   class="review-modal">
                <div class="text-center">
                    <div class="font-weight-bold">
                        {{ trans('tickets.api.confirm_delete') }}
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <div class="button-my-ticket-delete mr-2">
                            <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="confirmDeleteTicket()">
                                {{ trans('tickets.component.yes') }}
                            </button>
                        </div>

                        <div class="button-my-ticket-change ml-2">
                            <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="openDeleteModal = false">
                                {{ trans('tickets.component.no') }}
                            </button>
                        </div>
                    </div>
                </div>
            </modal>
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
        update: false,
        openModal: false,
        openDeleteModal: false,
        deletedTicket: false,
        pdf: {
          file: null,
          page: null
        },
        loaderPdf: false,
      }
    },
    methods: {
      formatedDate(date) {
        return new moment(date, 'YYYY-MM-DD').format('L');
      },
      handleResponse(response) {
        if(response.body.message) { this.$message({message: response.body.message, type: response.body.status}) }
      },
      closeModal() {
        this.openModal = false;
        this.openDeleteModal = false;
      },
      updatePrice() {
        console.log(this.ticket.price)

        this.$http.post(this.route('api.ticket.change.price', [this.ticket.id]), {'price': this.ticket.price})
          .then(response => {
            this.handleResponse(response)
          }, response => {
            this.handleResponse(response)
          });
      },
      downloadTicket() {
        window.location.href = this.route('public.ticket.download', [this.ticket.id]);
      },
      changeTicket() {
        this.openModal = true;
      },
      deleteTicket() {
        this.openDeleteModal = true;
      },
      confirmDeleteTicket() {
        this.$http.delete(this.route('api.ticket.delete', [this.ticket.id]))
          .then(response => {
            this.handleResponse(response)
            this.deletedTicket = true;
          });
      },
      getPdf(file) {
        this.loaderPdf = true;
        this.pdf.page = file.page;
        this.base64(file.file).then(data => {
          this.pdf.file = data
          this.uploadPdf(this.pdf)
        })
      },
      base64 (file)  {
        return new Promise((resolve, reject) => {
          let reader = new FileReader();
          reader.onloadend = () => {
            resolve(reader.result)
          };
          reader.readAsDataURL(file);
        });
      },
      uploadPdf(pdf) {
        this.$http.post(this.route('api.ticket.update.pdf', [this.ticket.id]), JSON.stringify(pdf))
          .then(response => {
            this.handleResponse(response)
            this.openModal = false;
            this.loaderPdf = false;
          }, response => {
            this.handleResponse(response)
            this.openModal = false;
            this.loaderPdf = false;
          });
      },
    },
  }
</script>

<style>
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

    @media screen and (max-width: 768px) {

        .my-ticket {  flex-direction: column;  }
        .my-ticket button {  margin-top: 10px;  }
    }

    .my-ticket .price {  font-size: 25px;  }

    .button-my-ticket-update, .button-my-ticket-share, .button-my-ticket-download {  width: 200px;  }

    .button-my-ticket-update button {  background-color: #0b89e7;  }
    .button-my-ticket-change button {  background-color: #9b9b9b;  }
    .button-my-ticket-delete button {  background-color: #f8254a;  }

    .back-to-front {  cursor: pointer;  }
</style>