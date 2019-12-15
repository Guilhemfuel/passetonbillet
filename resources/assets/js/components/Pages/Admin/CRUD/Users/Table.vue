<template>
    <div>
        <smart-table :remote="true" :api="api" :structure="structure" :routes="routes">
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
                    index: this.route('api.admin.users.index')
                },
                routes: {
                    profile: this.route('home') + 'ptbadmin/users/id'
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
                            name: "First Name",
                            type: "string",
                            key: "first_name",
                            searchable: true,
                            sortable: true,
                        },
                        {
                            name: "Last Name",
                            type: "string",
                            key: "last_name",
                            searchable: true,
                            sortable: true,
                        },
                        {
                            name: "Email",
                            type: "string",
                            key: "email",
                            searchable: true,
                            sortable: true,
                            hiddenMobile: true,
                        },
                        {
                            name: "Status",
                            type: "string",
                            key: "status",
                            align: "center",
                            hiddenMobile: true,
                            classFunction: function(value) {
                                if (value=='Admin') return 'text-success';
                                if (value=='Unconfirmed') return 'text-primary';
                                if (value=='User') return '';
                                return 'text-danger';
                            }
                        },
                        {
                            name: "FB Connect",
                            type: "boolean",
                            key: "fb_connect",
                            align: "center",
                        },
                    ]
                },
                searchValue: '',
                copied: null
            }
        },
        methods: {
        },
        computed: {
        }
    }
</script>
