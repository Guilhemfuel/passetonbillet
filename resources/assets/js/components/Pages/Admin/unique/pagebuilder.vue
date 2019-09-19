<template>
    <div class="page-builder">
        <div class="editor-row">
            <div class="editor-canvas">
                <div id="gjs">
                    <p>This is a new page</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import 'grapesjs/dist/css/grapes.min.css';
    import grapesjs from 'grapesjs';
    import blocks from 'grapesjs-preset-webpage';

    export default {
        props: {
            cssFile: {required:false, type:String},
            jsFiles: {required:false, type:Array},
        },
        data() {
            return {
                editor: null
            }
        },
        computed: {},
        mounted() {
            this.editor = grapesjs.init({
                // Indicate where to init the editor. You can also pass an HTMLElement
                container: '#gjs',
                allowScripts: 1,
                // Get the content for the canvas directly from the element
                // As an alternative we could use: `components: '<h1>Hello World Component!</h1>'`,
                fromElement: true,
                // Size of the editor
                height: '100vh',
                width: 'auto',

                canvas: {
                    styles: (this.cssFile ? [this.cssFile] : []),
                    scripts: (this.jsFiles ? this.jsFiles : []),
                },

                plugins: ['gjs-preset-webpage'],
                pluginsOpts: {
                    'gjs-preset-webpage': {
                        // options
                    }
                },
                // Disable the storage manager for the moment
                storageManager: false,
            });

            this.editor.BlockManager.add('page-container', {
                label: 'PageContainer',
                category: 'Basic',
                attributes: {class: 'fa fa-file-o'},
                content: {
                    script: `const app = new Vue({
                el: '#app',
                name: 'PasseTonBillet'});`,
                    // Add some style just to make the component visible
                    content: `<div id="app"></div>`
                }
            });

            this.editor.BlockManager.add('reviews', {
                label: 'Reviews',
                content: '<reviews></reviews>',
                category: 'Basic',
            })



        },
        methods: {}
    }
</script>