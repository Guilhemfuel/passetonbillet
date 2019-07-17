<template>
    <div class="container faq-component">

        <div class="row">
            <div class="col-12 col-sm-10 col-md-8 mx-auto">
                <div class="search p-4">
                    <input-text name="Search" :placeholder="trans('faq.search_placeholder')"
                                v-model="search"></input-text>
                </div>
            </div>
        </div>

        <div class="row container-over-bg p-0 pt-3 p-sm-3 p-md-5 pt-md-5  mt-3 ">
            <div class="col-12">

                <div class="questions">
                    <div class="question" v-for="question in filteredQuestions" v-if="filteredQuestions && filteredQuestions.length>0">
                        <h5 class="title" v-html=" question.title"></h5>
                        <div class="question-content text-justify" v-html="question.content"></div>
                    </div>

                    <p class="text-center" v-if="filteredQuestions && filteredQuestions.length == 0">
                        {{trans('faq.no_result')}}
                    </p>
                </div>

                <p class="text-center mt-3">
                    <a class="text-center" href="#" @click.prevent="openCrisp()">{{trans('faq.no_answer')}}</a>
                </p>

            </div>
        </div>

    </div>
</template>

<script>
    import Fuse from 'fuse.js'

    export default {
        props: {
            questions: {required: true}
        },
        data() {
            return {
                search: '',
            }
        },
        computed: {
            filteredQuestions() {
                if (this.search == '' || this.search == null || !this.questions) {
                    return this.questions;
                }

                var fuse = new Fuse(this.questions, {
                    shouldSort: true,
                    keys: [{
                        name: 'title',
                        weight: 0.7
                    }, {
                        name: 'tags',
                        weight: 0.7
                    }, {
                        name: 'content',
                        weight: 0.7
                    }]
                })

                return fuse.search(this.search);
            },
        },
        methods: {
            openCrisp(e) {
                window.$crisp.push(['do', 'chat:show']);
                window.$crisp.push(['do', 'chat:open']);
            },
        }
    }
</script>