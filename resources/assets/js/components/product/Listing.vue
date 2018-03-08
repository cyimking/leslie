<template>
    <div>
        <!--Breadcrumb-->
        <b-breadcrumb :items="items"/>
        <!--./Breadcrumb-->

        <!--Header-->
        <b-row>
            <h1 class="p-4">Product Directory</h1>
        </b-row>
        <!--./Header-->

        <!--Errors-->
        <b-row v-show="unsuccessfulCall" class="mt-5">
            <div class="alert alert-danger alert-dismissible fade show" style="width: 100%" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <b>Please correct the following error(s):</b>
                <ul>
                    <li v-for="error in errors">
                        {{ error }}
                    </li>
                </ul>
            </div>
        </b-row>
        <!--./Errors-->

        <!--Products-->
        <div v-show="successfulCall"  class="w-100">
            <!--Uh oh-->
            <b-jumbotron v-if="products.length <= 0"  header="Uh Oh!" lead="Empty product feed..." ></b-jumbotron>
            <!--./Uh oh-->
            <!--Product Listing-->
            <b-card v-show="products" v-for="product in products" class="mb-3">
                <b-media>
                    <b-img-lazy :src="product.images[0].path" slot="aside" width="150" alt="Placeholder" />
                    <router-link :to="{ name: 'ProductDetail', params: { id: product.product_id}}">
                        <h3 class="mt-0 font-weight-bold">{{ product.name }} </h3>
                    </router-link>
                    <p>{{ product.description }}</p>
                </b-media>
            </b-card>
            <!--./Product Listing-->
        </div>
        <!--./Products-->

         <!--Pagination-->
        <pagination :data="pagination" v-on:pagination-change-page="fetchProducts"></pagination>
        <!--./Pagination-->
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
                       active: true
                   }
               ],
               products: [],
               pagination: [],
               errors: [],
               successfulCall: false,
               unsuccessfulCall: false
           }
       },

        created: function()
        {
            this.fetchProducts(1);
        },

        methods: {
           fetchProducts(page)
           {
               // Set page number to 1 by default
               if(typeof page == 'undefinded') {
                   page = 1;
               }

               let uri = 'http://127.0.0.1:8000/api/products?page=' + page;
               this.axios.get(uri, {
                   data: {},
                   contentType: 'application/json; charset=utf-8'
               }).then((response) => {
                   this.products = response.data.data;
                   this.pagination = response.data;
                   this.successfulCall = true;
               }).catch((error) => {
                   this.errors = error.response.data;
                   this.unsuccessfulCall = true;
               })
           }
        }
    }
</script>