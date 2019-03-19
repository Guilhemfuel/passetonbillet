<template>

    <a @click.prevent="this.modalOpen = true">
        <span class="play-button">
            <i class="fa fa-play"></i>
        </span>
    </a>

    <modal :is-open="this.modalOpen"
           @close-modal="this.modalOpen = false"
           :title="trans('tickets.sell.public.video_title')"
           class="video-modal">

        <div id="video-container">
            <iframe src="https://www.youtube.com/embed/N0wy1LC8H0w?modestbranding=1&border=0&showinfo=0"
                    frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
            </iframe>
        </div>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                modalOpen: false,
                api: 'https://www.youtube.com/iframe_api',
                url: 'https://www.youtube.com/embed/N0wy1LC8H0w?autoplay=1&modestbranding=1&border=0&showinfo=0',
                allow: 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture',
                frameBorder: 0,
                allowFullscreen: true,
            }
        },
        mounted: function() {
            this.loadAPI();
        },
        computed: {
          loadAPI: function() {
              var tag = document.createElement('script');
              tag.src = this.api;


          },
          loadVideo: function () {
              let container = document.getElementById('video-container');

          }

        }
    }
</script>
