<template>
    <div>
        <smart-table :remote="true" :api="api" :structure="structure" :routes="routes">
            <template name="actions" v-slot:actions="data">
                <button class="btn btn-sm btn-info" @click.prevent="share(data.item.id)">
                    <i class="fa fa-clipboard" aria-hidden="true"></i>
                </button>
                <input type="hidden" :value="data.item.share_link" :id="'share-'+data.item.id" >
            </template>
        </smart-table>
    </div>
</template>

<script>


    export default {
        props: {
        },
        data() {
            return {
                api: {
                    index: this.route('api.admin.tickets.index')
                },
                routes: {
                    profile: this.route('home') + 'ptbadmin/tickets/id'
                },
                structure: {
                    actions: [
                        {
                            'name': '',
                            'route': 'profile',
                            'btn_class': 'btn-success',
                            'icon': 'fa fa-eye'
                        }
                    ],
                    columns: [
                        {
                            name: "Seller",
                            type: "string",
                            key: "seller_name",
                        },
                        {
                            name: "Booking Name",
                            type: "string",
                            key: "buyer_name",
                            searchable: true,
                            sortable: true,
                            hiddenMobile: true,
                        },
                        {
                            name: "Date",
                            type: "string",
                            key: "departure_date",
                            align: "center",
                        },
                        {
                            name: "From",
                            type: "string",
                            key: "departure_city",
                            align: "center",
                            hiddenMobile: true,
                        },
                        {
                            name: "To",
                            type: "string",
                            key: "arrival_city",
                            align: "center",
                            hiddenMobile: true,
                        },
                        {
                            name: "Price",
                            type: "string",
                            key: "price",
                            align: "center",
                            sortable: false,
                        },
                        {
                            name: "Provider",
                            type: "string",
                            key: "provider",
                            align: "center",
                            sortable: true,
                        },
                        {
                            name: "Code",
                            type: "string",
                            key: "provider_code",
                            align: "center",
                            hiddenMobile: true,
                            searchable: true,
                            sortable: false,
                        },
                        {
                            name: "Status",
                            type: "string",
                            key: "status",
                            align: "center",
                            classFunction: function(value) {
                                if (value=='sold') return 'text-success';
                                if (value=='passed') return 'text-primary';
                                return null;
                            }
                        },
                    ]
                },
                searchValue: '',
                copied: null
            }
        },
        methods: {
            share(id) {
                const copyToClipboard = str => {
                    const el = document.createElement('textarea');  // Create a <textarea> element
                    el.value = str;                                 // Set its value to the string that you want copied
                    el.setAttribute('readonly', '');                // Make it readonly to be tamper-proof
                    el.style.position = 'absolute';
                    el.style.left = '-9999px';                      // Move outside the screen to make it invisible
                    document.body.appendChild(el);                  // Append the <textarea> element to the HTML document
                    const selected =
                        document.getSelection().rangeCount > 0        // Check if there is any content selected previously
                            ? document.getSelection().getRangeAt(0)     // Store selection if found
                            : false;                                    // Mark as false to know no selection existed before
                    el.select();                                    // Select the <textarea> content
                    document.execCommand('copy');                   // Copy - only works as a result of a user action (e.g. click events)
                    document.body.removeChild(el);                  // Remove the <textarea> element
                    if (selected) {                                 // If a selection existed before copying
                        document.getSelection().removeAllRanges();    // Unselect everything on the HTML document
                        document.getSelection().addRange(selected);   // Restore the original selection
                    }
                };

                this.copied = id;

                copyToClipboard(document.getElementById('share-'+id).value);
            },
        },
        computed: {
        }
    }
</script>
