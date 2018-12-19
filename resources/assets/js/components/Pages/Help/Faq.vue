<template>
    <div class="container faq-component">

        <div class="row">
            <div class="col-12 col-sm-10 col-md-8 mx-auto mt-3">
                <div class="search">
                    <input-text name="Search" :placeholder="trans('faq.search.placeholder')" v-model="search"></input-text>
                </div>
            </div>
        </div>

        <div class="row container-over-bg p-5 mt-3 ">
            <div class="col-12">

                <div class="questions">
                    <div class="question" v-for="question in filteredQuestions" v-if="filteredQuestions.length>0">
                        <h5 class="title" v-html=" question.title"></h5>
                        <p class="content text-justify" v-html="question.content"></p>
                    </div>

                    <p class="text-center" v-if="filteredQuestions.length == 0">
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
        props: {},
        data() {
            return {
                search: '',
                questions: this.trans('faq.questions')
            }
        },
        computed: {
            filteredQuestions() {
                if (this.search == '' || this.search == null) {
                    return this.questions;
                }

                var fuse = new Fuse(this.questions, {
                    shouldSort: true,
                    keys: [{
                        name: 'title',
                        weight: 0.7
                    },{
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