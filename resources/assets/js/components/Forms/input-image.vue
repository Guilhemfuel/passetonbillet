<template>
    <div :class="getClass">
        <label v-if="label" :for="name">
            {{label}}
        </label>
        <input type="hidden" :value="image64" :name="name"/>
        <div class="row">
            <div class="pl-3">
                <croppa v-model="myCroppa"
                        :zoom-speed="6"
                        :width="width"
                        :height="height"
                        @file-choose="hasFile=true"
                        @image-remove="hasFile=false"
                        v-if="srcLoaded"
                        :initial-image="defaultValue"
                        canvas-color="white"
                ></croppa>
                <div class="btns" v-if="hasFile">
                    <button class="btn btn-sm btn-tikehau-light" @click.prevent="myCroppa.rotate()"><i
                            class="fas fa-redo"></i></button>
                    <button class="btn btn-sm btn-tikehau-light" @click.prevent="myCroppa.zoomIn()"><i
                            class="fas fa-search-plus"></i></button>
                    <button class="btn btn-sm btn-tikehau-light" @click.prevent="myCroppa.zoomOut()"><i
                            class="fas fa-search-minus"></i></button>
                </div>
            </div>
            <div class="col">
                <P class="text-gray"  v-if="hasFile">
                You can scroll on the picture to zoom, or use the mouse to drag the picture around.
                </P>
            </div>
        </div>

        <!--<input :type="type"-->
        <!--:class="{'form-control':true,'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}"-->
        <!--:id="name"-->
        <!--:name="name"-->
        <!--:placeholder="placeholder"-->
        <!--v-validate="validation"-->
        <!--v-model="inputValue"-->
        <!--&gt;-->
        <small v-if="errors.has(name)" :id="name+'Error'" class="form-text text-danger">
            {{ errors.first(name) }}
        </small>
    </div>
</template>

<script>
    export default {
        inject: ['$validator'],
        props: {
            label: {required: false, type: String},
            name: {required: true, type: String},
            height: {required: false, default: 200},
            width: {required: false, default: 200},
            defaultValue: {required: false, type: String, default: ''},
            className: {required: false, type: String},
            oldValue: {required: false, type: Boolean, default: true},
        },
        computed: {
            getClass() {
                return this.className ? ('form-group ' + this.className) : 'form-group';
            },
            pulse() {
                return this.$parent.pulse;
            },
            defaultVal() {
                if (this.defaultValue != null && this.defaultValue != undefined) {
                    return this.defaultValue;
                }
                if (this.oldValue && this.$root.oldInput[this.name]) {
                    return this.$root.oldInput[this.name];
                }
                return null;
            }
        },
        data() {
            return {
                hasFile: false ,
                image64: null,
                myCroppa: {},
                srcLoaded: false
            }
        },
        mounted() {
            // Every 4 seconds recalculate image
            setInterval(function () {
                this.loadImage();
            }.bind(this), 4000);

            if (this.defaultValue=='' || this.defaultValue==null) {
                this.srcLoaded = true;
            } else {
                let img = new Image();
                img.onload = e => {
                    this.srcLoaded = true;
                    this.hasFile = true;
                };
                img.src = this.defaultVal;
            }

        },
        methods: {
            loadImage(){
                if (this.hasFile) {
                    this.image64 = this.myCroppa.generateDataUrl('image/jpeg', 0.8)
                };
            }
        }
    }
</script>
