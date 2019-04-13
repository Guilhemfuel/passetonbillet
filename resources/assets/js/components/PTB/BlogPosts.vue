<template>
    <div class="section-blog-posts">
        <div class="container-fluid text-center">
            <h2 class="text-uppercase text-center text-warning font-weight-bold">
                {{ trans('welcome.blog.title') }}
            </h2>
            <div class="row px-5">

                <template v-if="loading">
                    <div v-for="n in 3" :key="n" class="px-2 col-12 col-sm-6 col-md-4">
                        <div class="card card-blog-post">
                            <a href="https://blog.passetonbillet.fr/" class="post-link">

                                <div class="loading card-body">

                                </div>
                                <div class="card-footer">

                                </div>
                            </a>
                        </div>
                    </div>
                </template>

                <template v-else>
                    <div v-for="post in posts" :key="post.id" class="px-2 col-12 col-sm-6 col-md-4">
                        <a :href="post.link" class="post-link">
                            <div class="card card-blog-post">
                                <div class="card-body">
                                    <img alt="PasseTonBillet Blog logo" :src="logo">


                                    <p v-html="post.title.rendered" class="title">

                                    </p>
                                </div>
                                <div class="card-footer">
                                    <p class="date">
                                        {{ trans('welcome.blog.post.footer' )}} {{ new Date(post.date).toDateString() }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </template>
            </div>

            <a id='btn-more-blog-posts' href="https://blog.passetonbillet.fr" class="btn btn-ptb-orange text-uppercase">
                {{ trans('welcome.blog.more') }}
            </a>
        </div>
    </div>
</template>

<script>

    import axios from 'axios'

    export default {

        data() {
            return {
                logo: '../../img/ptb-blog-logo.png',
                posts: null,
                error: false,
                loading: true,
            }

        },

        computed: { },

        mounted() {


                axios.get('https://blog.passetonbillet.fr/wp-json/wp/v2/posts' )

                .then( response => this.posts = response.data )

                .catch( error => { this.error = true; console.error(error) } )

                .finally( () => { this.loading = false; console.log(this.$root) } )
        }

    }
</script>