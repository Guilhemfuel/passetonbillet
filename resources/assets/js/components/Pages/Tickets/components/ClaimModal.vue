<template>
    <modal id="modal-claim"
            class="ticket-modal-share"
           :is-open="openModal"
           @close-modal="closeModal"
    >
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

            <p class="mt-2"><textarea id="moreInformation" name="moreInformation" v-model="moreInformation" rows="5" cols="33"></textarea></p>

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
        state: 'start',
        currentQuestion: 1,
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
        this.state = 'start';
        this.currentQuestion = 1;
        this.timeScan = null;
        this.moreInformation = null;
        this.answers = [];
      },
      answerQuestion(answer) {
        console.log(answer)
        this.answers.push(answer)
        this.currentQuestion++;
        if (this.currentQuestion <= 5) {
          this.state = 'question-' + this.currentQuestion;
        } else {
          this.state = 'end';
        }
        console.log(this.answers);
      },
      submitClaim() {
        console.log('Submit !')
      },
    },
    computed: {
    },
    mounted() {

    }
  }
</script>

<style scoped>
    #modal-claim h1 {
        font-size: 20px;
        text-align: center;
        color: black;
    }

    .button-my-ticket-update, .button-my-ticket-delete {  width: 300px;  }

    .button-my-ticket-update button {  background-color: #0b89e7;  }
    .button-my-ticket-delete button {  background-color: #f8254a;  }
</style>