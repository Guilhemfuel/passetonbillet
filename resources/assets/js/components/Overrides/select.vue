
<script>
    import ElSelect from 'element-ui/lib/select';

//    Simple override to deactivate read-only input on mobile

    export default {
        extends: ElSelect,

        computed: {

            readonly() {
                console.log('mobile',this.$mobile);

                if (this.$mobile) {
                    return false;
                }

                const isIE = !this.$isServer && !isNaN(Number(document.documentMode));
                return !this.filterable || this.multiple || !isIE && !this.visible;
            },

        }
    };
</script>
