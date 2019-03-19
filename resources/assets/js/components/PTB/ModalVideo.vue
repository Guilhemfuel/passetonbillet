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

            <iframe v-if="this.modalOpen"
                    src="https://www.youtube.com/embed/N0wy1LC8H0w?modestbranding=1&border=0&showinfo=0"
                    frameborder="0"
                    frameBorder="0"
                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                    border="0"
                    hspace="0"
                    vspace="0"
                    marginheight="0"
                    marginwidth="0"
                    scrolling="no"
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
            }
        }
    }
</script>
