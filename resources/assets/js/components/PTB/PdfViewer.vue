<template>
    <div class="pdf-viewer">

        <div id="modal" v-if="showModal" @close="showModal = false">
            <transition name="modal">
                <div class="modal-mask" v-on:click="showModal = false">
                    <div class="modal-wrapper">
                        <canvas :ref="'modalcanvas'" id="modal-canvas" height="800" class="modal-container" v-on:click.stop></canvas>
                    </div>
                </div>
            </transition>
        </div>

        <transition enter-class="pre-animated"
                    enter-active-class="animated fadeIn"
                    leave-active-class="animated fadeOut">
            <div v-if="state=='loader'">
                <div class="card">
                    <div class="card-body">
                        <div class="p-5">
                            <loader :class-name="'mx-auto'"></loader>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <div v-if="state=='description'">
            <p class="text-center">
                {{trans('tickets.pdf.description_1')}}
            </p>
            <p class="text-center">
                {{trans('tickets.pdf.description_2')}}
            </p>
            <p class="text-center">
                {{trans('tickets.pdf.description_3')}}
            </p>

            <input type="file" ref="file" id="file-to-upload" accept="application/pdf" @change="processFile($event)" style="display: none;"/>

            <button type="submit" class="btn btn-ptb-blue btn-block" @click="$refs.file.click()">
                {{trans('tickets.pdf.select_file')}}
            </button>
        </div>

        <div v-if="state=='show_pdf'" v-for="page of pages" :key="page.id">
            <h5 class="text-center font-weight-bold">
                {{trans('tickets.pdf.choose_pdf')}}
            </h5>
            <div class="row">
                <div class="col-6">
                    <canvas :ref="'pdf-canvas-' + page.currentPage" :id="'pdf-canvas-' + page.currentPage" width="200"></canvas>
                </div>

                <div class="col-6">
                    <div class="text-center">Page : {{ page.currentPage }}</div>
                    <a class="zoom-button" v-on:click="zoomPdf(page.currentPage)">{{trans('tickets.pdf.zoom_pdf')}}</a>
                    <br>
                    <a class="choose-ticket" v-on:click="choosePdf(page.currentPage)">{{trans('tickets.pdf.choose_this_ticket')}}</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'PdfViewer',
    components: {

    },
    props: {

    },
    data () {
      return {
        state: 'description',
        file: false,
        pdf: false,
        pages: [],
        totalPages: 0,
        showModal: false
      }
    },
    methods: {
      processFile(event) {
        this.state = 'loader'
        this.file = event.target.files[0]
        this.showPdf(URL.createObjectURL(this.file))
      },
      showPdf(file) {
        pdfjsLib.getDocument(file).promise.then((pdf) => {
          this.pdf = pdf
          this.totalPages = this.pdf.numPages

          for (let i = 1; i <= this.totalPages; i++) {
            this.pages.push({'currentPage': i})
            this.showPage(i)
          }

          this.state = 'show_pdf'

        }).catch(function(error) {
          alert(error.message)
        })
      },
      showPage(currentPage) {
        this.pdf.getPage(currentPage).then((page) => {
          let canvas = this.$refs['pdf-canvas-' + currentPage][0]
          let scale_required = canvas.width / page.getViewport({ scale: 1, }).width
          let viewport = page.getViewport({ scale: scale_required})
          canvas.height = viewport.height

          let renderContext = {
            canvasContext: canvas.getContext('2d'),
            viewport: viewport
          }

          page.render(renderContext)
        })
      },
      zoomPdf(id) {
        this.showModal = true
        this.pdf.getPage(id).then((page) => {
          let canvas = this.$refs['modalcanvas']
          let scale_required = window.innerHeight / page.getViewport({ scale: 1, }).height
          let viewport = page.getViewport({ scale: scale_required})
          canvas.width = viewport.width

          let renderContext = {
            canvasContext: canvas.getContext('2d'),
            viewport: viewport
          }

          page.render(renderContext)
        })
      },
      choosePdf(page) {
        let pdf = {
          file: this.file,
          page: page
        };

        this.$emit('returnData', pdf)
      }
    },
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    body.modal-open {
        overflow: hidden;
        height: 100vh;
    }

    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
        text-align: center;
    }

    .modal-container {
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
    }

    /*
     * The following styles are auto-applied to elements with
     * transition="modal" when their visibility is toggled
     * by Vue.js.
     *
     * You can easily play with the modal transition by editing
     * these styles.
     */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }

    .zoom-button {
        background-color: #f6f6f7;
        width: 100%;
        color: #4a4a4a!important;
        display: inline-block;
        text-align: center;
        padding: 10px;
        border-radius: 10px;
        font-weight: bold;
        margin: 10px 0;
    }

    .zoom-button:hover {
        cursor: pointer;
        background-color: #d0d0d0;
    }

    .choose-ticket {
        border: 1px solid #f6f6f7;
        width: 100%;
        color: #4a4a4a!important;
        display: inline-block;
        text-align: center;
        padding: 10px;
        border-radius: 10px;
        font-weight: bold;
        margin: 10px 0;
    }

    .choose-ticket:hover {
        cursor: pointer;
        background-color: #0b89e7;
        border: none;
        color: white!important;
    }

</style>
