<template>
    <div class="section-blog-posts">
        <div class="container-fluid text-center pt-4">
            <h2 class="text-uppercase text-center text-warning font-weight-bold">
                {{ trans('welcome.blog.title') }}
            </h2>
            <div class="row px-5 mb-4 mt-4">

                <template v-if="loading">
                    <div v-for="n in 3" :key="n" class="px-2 col-12 col-sm-6 col-md-4 mt-3">
                        <a href="#" class="post-link">
                            <div class="card card-blog-post">
                                <div class="card-body">
                                    <div class="image-container">
                                        <img class="logo-blog" alt="PasseTonBillet Blog logo" >
                                    </div>
                                    <div class="card-footer px-2">
                                        <p class="post-title"></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </template>

                <template v-else>
                    <div v-for="post in posts.slice(0, 3)" :key="post.id" class="px-2 col-12 col-sm-6 col-md-4 mt-3">
                        <a :href="post.link" class="post-link">
                            <div class="card card-blog-post">
                                <div class="card-body">
                                    <div class="image-container" :style="getPostStyle(post)">
                                        <img class="logo-blog" alt="PasseTonBillet Blog logo" :src="logoUrl">
                                    </div>
                                    <div class="card-footer px-2">
                                        <p v-html="post.title.rendered" class="post-title"></p>
                                    </div>
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

    export default {

        data() {
            return {
                logoUrl: '../../img/ptb-blog-logo.png',
                posts: null,
                error: false,
                loading: true,
                blogUrl: 'https://blog.passetonbillet.fr/wp-json/wp/v2/posts?_embed',
            }

        },

        computed: { },

        methods: {
            getPostImage(post){
                if ('_embedded' in post && 'wp:featuredmedia' in post._embedded && post._embedded['wp:featuredmedia'].length > 0 ){
                    return post._embedded['wp:featuredmedia'][0]['source_url'];
                }
                return null;
            },
            getPostStyle(post) {
                let postImage = this.getPostImage(post);

                if (postImage) {
                    return 'background-image: url("'+postImage+'")'
                }
                else{
                    return null;
                }
            }
        },

        created() {

            this.$http.get(this.blogUrl).then(response => {
                this.posts = response.data;

            }, response => {
                this.posts = [];
                this.error = true;
            }).then(() => {
                this.loading = false;
            });

        }

    }
</script>