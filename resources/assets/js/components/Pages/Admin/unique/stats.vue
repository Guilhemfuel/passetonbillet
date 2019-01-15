<template>

    <div class="container-fluid stats mt-5">
        <div class="row">
            <div class="col-12 col-lg-6 mt-4">
                <h4 class="text-center">User Registration</h4>
                <div class="chart">
                    <line-chart :dataset="userRegistrationData" v-if="isMounted"></line-chart>
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-4">
                <h4 class="text-center">Research Count</h4>
                <div class="chart">
                    <line-chart :dataset="dailyResearchCount" v-if="isMounted"></line-chart>
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-4">
                <h4 class="text-center">Tickets Sold</h4>
                <div class="chart">
                    <line-chart :dataset="dailyTicketSoldCount" v-if="isMounted"></line-chart>
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-4 ">
                <h4 class="text-center">Tickets Added</h4>
                <div class="chart">
                    <line-chart :dataset="dailyTicketCount" v-if="isMounted"></line-chart>
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-4">
                <h4 class="text-center">Current Tickets Segmentation</h4>
                <div class="chart">
                    <doughnut-chart :dataset="ticketsSegmentation" v-if="isMounted"></doughnut-chart>
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-4">
                <h4 class="text-center">Offers Sent</h4>
                <div class="chart">
                    <line-chart :dataset="dailyOfferCount" v-if="isMounted"></line-chart>
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-4">
                <h4 class="text-center">Pdf Downloaded</h4>
                <div class="chart">
                    <line-chart :dataset="dailyPdfDownloadCount" v-if="isMounted"></line-chart>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
    export default {
        props: {
            datasets: {type: Object, required: true}
        },
        data() {
            return {
                userRegistrationData: null,
                dailyTicketCount: null,
                dailyTicketSoldCount: null,
                dailyOfferCount: null,
                dailyResearchCount: null,
                dailyPdfDownloadCount: null,
                ticketsSegmentation: null,

                isMounted: false,
            }
        },
        computed: {},
        mounted() {
            this.userRegistrationData = {
                labels: Object.keys(this.datasets['dailyUserCount']),
                datasets: [
                    {
                        label: 'User Registration',
                        backgroundColor: 'rgba(253,144,4,0.8)',
                        data: Object.values(this.datasets['dailyUserCount'])
                    }
                ]
            };
            this.dailyTicketSoldCount = {
                labels: Object.keys(this.datasets['dailyTicketSoldCount']),
                datasets: [
                    {
                        label: 'Tickets Sold',
                        backgroundColor: 'rgba(253,144,4,0.8)',
                        data: Object.values(this.datasets['dailyTicketSoldCount'])
                    }
                ]
            };
            this.dailyTicketCount = {
                labels: Object.keys(this.datasets['dailyTicketCount']),
                datasets: [
                    {
                        label: 'Tickets Added',
                        backgroundColor: 'rgba(253,144,4,0.8)',
                        data: Object.values(this.datasets['dailyTicketCount'])
                    }
                ]
            };
            this.dailyOfferCount = {
                labels: Object.keys(this.datasets['dailyOfferCount']),
                datasets: [
                    {
                        label: 'Offers',
                        backgroundColor: 'rgba(253,144,4,0.8)',
                        data: Object.values(this.datasets['dailyOfferCount'])
                    }
                ]
            };
            this.dailyResearchCount = {
                labels: Object.keys(this.datasets['dailyResearchCount']),
                datasets: [
                    {
                        label: 'Research Done',
                        backgroundColor: 'rgba(253,144,4,0.8)',
                        data: Object.values(this.datasets['dailyResearchCount'])
                    }
                ]
            };
            this.dailyPdfDownloadCount = {
                labels: Object.keys(this.datasets['dailyPdfDownloadCount']),
                datasets: [
                    {
                        label: 'Tickets Added',
                        backgroundColor: 'rgba(253,144,4,0.8)',
                        data: Object.values(this.datasets['dailyPdfDownloadCount'])
                    }
                ]
            };
            this.ticketsSegmentation = {
                labels: Object.keys(this.datasets['ticketSegmentation']),
                datasets: [
                    {
                        backgroundColor: ['#9def80','#7CD3DF','#BB2D3E'],
                        data: Object.values(this.datasets['ticketSegmentation'])
                    }
                ]
            };

            this.isMounted = true;
        },
        methods: {}
    }
</script>