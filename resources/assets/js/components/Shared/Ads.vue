<template>
    <div class="ads">
        <div :id="'41941-'+format" :class="[type,{'responsive':responsive}]">
        </div>
    </div>

</template>

<script>


    export default {
        created() {
            // Set format of ad
            let formats = {
                'megabanner': 1,
                'pave_bas': 19,
                'megaskyscrapper': 20,
            };

            if (!this.type in formats) {
                console.error('Type ' + this.type + ' is not defined for Moneytizer.');
                return;
            }

            this.format = formats[this.type];
        },
        mounted() {
            // Load scripts
            this.$nextTick(() => {
                let script1 = document.createElement('script');
                script1.setAttribute('src', "//ads.themoneytizer.com/s/gen.js?type=" + this.format);
                document.getElementById('41941-' + this.format).appendChild(script1)

                let script2 = document.createElement('script');
                script2.setAttribute('src', "//ads.themoneytizer.com/s/requestform.js?siteId=41941&formatId=" + this.format);
                document.getElementById('41941-' + this.format).appendChild(script2)
            })
        },
        props: {
            type: {type: String, required: true},
            responsive: {type: Boolean, default: true},
            id: {type: String, default: '1'}
        },
        date() {
            return {
                format: null
            }
        },
        methods: {},
    }

</script>