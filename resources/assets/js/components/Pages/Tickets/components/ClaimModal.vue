<template>
    <modal id="modal-claim"
            class="ticket-modal-share"
           :is-open="openModal"
           @close-modal="closeModal"
    >

        <div class="timeLeft" v-if="timeLeft">{{ timeLeft }} {{ trans('tickets.claim.hours_left') }}</div>

        <div v-if="state === 'start'" class="col-10 text-center mx-auto">
            <h1>
                {{ trans('tickets.claim.start') }}
            </h1>

            <p class="mt-2">
                {{ trans('tickets.claim.start_more') }}
            </p>

            <div class="button-my-ticket-update mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="state = 'faq'">
                    {{ trans('tickets.claim.i_have_question') }}
                </button>
            </div>

            <div class="button-my-ticket-delete mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="state = 'question-1'">
                    {{ trans('tickets.component.yes') }}
                </button>
            </div>
        </div>

        <div v-if="state === 'faq'" class="col-10 text-center mx-auto">
            <h1>{{ trans('tickets.claim.we_answers') }}</h1>

            <p class="mt-2">{{ trans('tickets.claim.read_our_faq') }}</p>

            <div class="button-my-ticket-update mt-2 mx-auto">
                <a :href="this.route('help.page')" class="btn btn-ptb btn-upper text-uppercase w-100">
                    {{ trans('tickets.claim.read_faq') }}
                </a>
            </div>
        </div>

        <div v-if="state === 'question-1'" class="col-10 text-center mx-auto">
            <h1>{{ trans('tickets.claim.question_1') }}</h1>

            <p class="mt-2">{{ trans('tickets.claim.question_1_more') }}</p>

            <div class="button-my-ticket-update mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(false)">
                    {{ trans('tickets.component.no') }}
                </button>
            </div>

            <div class="button-my-ticket-delete mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(true)">
                    {{ trans('tickets.component.yes') }}
                </button>
            </div>
        </div>

        <div v-if="state === 'question-2'" class="col-10 text-center mx-auto">
            <h1>{{ trans('tickets.claim.question_2') }}</h1>

            <p class="mt-2">{{ trans('tickets.claim.question_2_more') }}</p>

            <div class="button-my-ticket-delete mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(timeScan)">
                    {{ trans('tickets.component.validate') }}
                </button>
            </div>
        </div>

        <div v-if="state === 'question-3'" class="col-10 text-center mx-auto">
            <h1>{{ trans('tickets.claim.question_3') }}</h1>

            <p class="mt-2">{{ trans('tickets.claim.question_3_more') }}</p>

            <div class="button-my-ticket-update mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(false)">
                    {{ trans('tickets.component.no') }}
                </button>
            </div>

            <div class="button-my-ticket-delete mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(true)">
                    {{ trans('tickets.component.yes') }}
                </button>
            </div>
        </div>

        <div v-if="state === 'question-4'" class="col-10 text-center mx-auto">
            <h1>{{ trans('tickets.claim.question_4') }}</h1>

            <p class="mt-2">{{ trans('tickets.claim.question_4_more') }}</p>

            <div class="button-my-ticket-update mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(false)">
                    {{ trans('tickets.component.no') }}
                </button>
            </div>

            <div class="button-my-ticket-delete mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(true)">
                    {{ trans('tickets.component.yes') }}
                </button>
            </div>
        </div>

        <div v-if="state === 'question-5'" class="col-10 text-center mx-auto">
            <h1>{{ trans('tickets.claim.question_5') }}</h1>

            <p class="mt-2">
                <textarea id="moreInformation" name="moreInformation" :placeholder="trans('tickets.claim.more_info')" v-model="moreInformation"></textarea>
            </p>

            <div class="button-my-ticket-delete mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(moreInformation)">
                    {{ trans('tickets.component.submit') }}
                </button>
            </div>
        </div>

        <div v-if="state === 'end'" class="col-10 text-center mx-auto">
            <h1>{{ trans('tickets.claim.end') }}</h1>

            <p class="mt-2">{{ trans('tickets.claim.end_more') }}</p>

            <div><i class="fa fa-check" aria-hidden="true"></i></div>

            <div class="button-my-ticket-delete mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="submitClaim">
                    {{ trans('tickets.component.finish') }}
                </button>
            </div>
        </div>
    </modal>
</template>

<script>
  export default {
    props: {
      openModal: {required: true},
      ticket: {required: true},
    },
    data() {
      return {
        state: 'faq',
        currentQuestion: 1,
        timeLimit: 48,
        timeLeft: null,
        timeScan: null,
        moreInformation: null,
        answers: []
      }
    },
    methods: {
      closeModal() {
        this.resetComponent();
        this.$emit("close-modal", false);
      },
      resetComponent() {
        console.log('reset')
        this.state = 'faq';
        this.currentQuestion = 1;
        this.timeLeft = null;
        this.timeScan = null;
        this.moreInformation = null;
        this.answers = [];
      },
      formatedDate(date) {
        return new moment(date, 'YYYY-MM-DD').format('L');
      },
      answerQuestion(answer) {
        this.answers.push(answer)
        this.currentQuestion++;
        if (this.currentQuestion <= 5) {
          this.state = 'question-' + this.currentQuestion;
        } else {
          this.state = 'end';
        }
        console.log(this.answers);
      },
      calculTimeLeft() {
        let dateDeparture = this.ticket.train.departure_date + ' ' + this.ticket.train.departure_time;
        let dateNow = moment().format('YYYY-MM-DD HH:mm:ss');

        //If departure has started, we display the claim modal
        //If not we display only FAQ modal
        if(dateDeparture <= dateNow) {
          this.state = 'start';
          let diff = new moment(dateNow,"YYYY-MM-DD HH:mm:ss").diff(moment(dateDeparture,"YYYY-MM-DD HH:mm:ss"));
          let hoursSinceDeparture = Math.round(new moment.duration(diff).asHours());
          let minutesSinceDeparture = Math.round(new moment.duration(diff).asMinutes());

          //If train departure is less than 48 hours
          if (hoursSinceDeparture <= this.timeLimit) {
            this.timeLeft = this.timeLimit - hoursSinceDeparture;
          }
        }
      },
      submitClaim() {
        console.log('Submit !')
      },
    },
    computed: {
    },
    watch: {
      openModal: function () {
        if(this.openModal) {
          this.calculTimeLeft();
        }
      }
    }
  }
</script>

<style scoped>
    #modal-claim h1 {
        font-size: 15px;
        margin-bottom: 10px;
        text-align: center;
        color: black;
        font-weight: bold;
    }

    #modal-claim textarea {
        background-color: #eaeaea;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        width: 300px;
        height: 150px;
        color: #545454;
    }

    .timeLeft {
        background-color: #f8254a;
        font-weight: bold;
        font-size: 14px;
        color: white;
        text-align: center;
        border-radius: 10px;
        width: 80px;
        padding: 6px;
        line-height: 12px;
        margin: 0 0 10px 0;
    }

    .button-my-ticket-update, .button-my-ticket-delete {  width: 300px;  }

    .button-my-ticket-update button {  background-color: #0b89e7;  }
    .button-my-ticket-delete button {  background-color: #f8254a;  }
</style>