<template>
    <div>
        <!--Breadcrumb-->
        <b-row>
            <b-breadcrumb :items="items"/>
        </b-row>
        <!--./Breadcrumb-->

        <!--Header-->
        <b-row>
            <h1 class="pl-0 pt-4 pr-4 pb-4">Analytics - Traffic</h1>
        </b-row>
        <!--./Header-->

        <!-- TODO - Test for results-->
        <b-row>
            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <th>ID</th>
                    <th>IP Address</th>
                    <th>User</th>
                    <th>Last Activity</th>
                </tr>
                <tr v-for="traffic in trafficers">
                    <td><router-link :to="{ name: 'TrackerTrafficByID', params: { id: traffic.id}}">{{ traffic.id}} </router-link></td>
                    <td>{{ traffic.client_ip }}</td>
                    <td>{{ !traffic.user ? 'Guest' : traffic.user }}</td>
                    <td>{{ traffic.updated_at }}</td>
                </tr>
            </table>
        </b-row>

    </div>
</template>

<script>
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
                        href: '#',
                        active: true
                    }
                ],
                trafficers: [],
                pagination: [],
                errors: [],
                successfulCall: false,
                unsuccessfulCall: false
            }
        },
        created: function()
        {
            this.fetchTraffic();
        },

        methods: {
            fetchTraffic()
            {
                let uri = 'http://127.0.0.1:8000/api/tracker/visitors';
                this.axios.get(uri, {
                    data: {},
                    contentType: 'application/json; charset=utf-8'
                }).then((response) => {
                    this.trafficers = response.data;
                    this.successfulCall = true;
                }).catch((error) => {
                    this.errors = error.response.data;
                    this.unsuccessfulCall = true;
                })
            },
        }
    }
</script>

<style scoped>

</style>