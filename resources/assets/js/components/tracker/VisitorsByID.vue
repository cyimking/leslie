<template>
    <div>
        <!--Breadcrumb-->
        <b-row>
            <b-breadcrumb :items="items"/>
        </b-row>
        <!--./Breadcrumb-->

        <!--Header-->
        <b-row>
            <h1 class="pl-0 pt-4 pr-4 pb-4">Analytics - Traffic by Session ID</h1>
        </b-row>
        <!--./Header-->

        <b-row>
            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <th>ID</th>
                    <th>Path</th>
                    <th>Method</th>
                    <th>Timestamp</th>
                </tr>
                <tr v-for="log in logs.data">
                    <td>{{ log.session_id }}</td>
                    <td>{{ log.path }}</td>
                    <td>{{ log.method }}</td>
                    <td>{{ log.created_at }}</td>
                </tr>
            </table>
        </b-row>

        <!--Pagination-->
        <pagination :data="logs" v-on:pagination-change-page="fetchLogs"></pagination>
        <!--./Pagination-->
    </div>
</template>

<script>
    // TODO - More error checking.
    export default {
        data() {
            return {
                items: [
                    {
                        text: 'Home',
                        to: { name: 'ProductListing' },
                    },
                    {
                        text: 'Traffic',
                        to: { name: 'TrackerTraffic' },
                    },
                    {
                        text: 'Session ID',
                        href: '#',
                        active: true
                    }
                ],
                logs: [],
                errors: [],
                successfulCall: false,
                unsuccessfulCall: false
            }
        },
        created: function()
        {
            this.fetchLogs(1);
        },

        methods: {
            fetchLogs(page)
            {
                // Set page number to 1 by default
                if(typeof page == 'undefinded') {
                    page = 1;
                }

                let uri = 'http://127.0.0.1:8000/api/tracker/visitors/' + this.$route.params.id + '?page=' + page;
                this.axios.get(uri, {
                    data: {},
                    contentType: 'application/json; charset=utf-8'
                }).then((response) => {
                    this.logs = response.data;
                    this.successfulCall = true;
                }).catch((error) => {
                    this.errors = error.response.data;
                    this.unsuccessfulCall = true;
                })
            },
        }
    }
</script>