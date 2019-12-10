<template>
    <div :class="getClass">
        <button class="btn btn-link btn-sm d-none d-sm-block" :disabled="page==data.firstPage" @click="first()">First</button>
        <button class="btn btn-link btn-sm" :disabled="page==data.firstPage" @click="prev()">Prev</button>
        <input :class="{'form-control form-control-sm':true,'invalid':errors.has('pagination')}"
               v-model="page"
               @change="emitInput"
               v-validate="validation"
                name="pagination"
        />
        <button class="btn btn-link btn-sm" :disabled="page==data.lastPage" @click="next()" >Next</button>
        <button class="btn btn-link btn-sm d-none d-sm-block" :disabled="page==data.lastPage" @click="last()">Last</button>
    </div>
</template>

<script>
    export default {
        props: {
            data: {required: true, type: Object},
            className: {required: false, type: String},
        },
        data() {
            return {
                page: this.data.page
            }
        },
        methods: {
            /**
             * Emit new page value
             */
            emitInput (e) {
                this.$validator.validate().then(result => {
                    if (!result) {
                        return
                    }
                });
                this.$emit('input', this.page);
                this.$emit('change', this.page)
            },
            first(){
                if (this.page==this.data.firstPage) return;
                this.page = this.data.firstPage;
                this.emitInput();
            },
            next(){
                if (this.page==this.data.lastPage) return;
                this.page++;
                this.emitInput();
            },
            prev(){
                if (this.page==this.data.firstPage) return;
                this.page--;
                this.emitInput();
            },
            last(){
                if (this.page==this.data.lastPage) return;
                this.page = this.data.lastPage;
                this.emitInput();
            }
        },
        computed: {
            getClass() {
                return this.className ? ('pagination ' + this.className) : 'pagination';
            },
            validation() {
                return 'max_value:' + this.data.lastPage + '|min_value:' + this.data.firstPage;
            }
        }

    }
</script>









