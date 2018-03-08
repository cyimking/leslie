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
            <b-jumbotron v-if="products.length <= 0 && !productsSearch"  header="Uh Oh!" lead="Empty product feed..." ></b-jumbotron>
            <!--./Uh oh-->

            <!--Query Search-->
           <form method="get">
               <div class="form-group">
                   <label for="searchProducts" class="text-danger">
                       <strong>Important:</strong>
                       Click <code>[esc]</code> to search. Enter a blank value, click <code>[esc]</code> to reset.
                   </label>
                   <input
                           id="searchProducts"
                           name="q"
                           @keyup.esc="searchProducts"
                           type="text"
                           v-model="search_query"
                           class="form-control"
                           placeholder="Enter search terms such as product name, description, type, etc..."
                   />
               </div>
           </form>
            <!--./Query Search-->

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

            <!--Product Search Listing-->
            <b-card v-show="productsSearch" v-for="product in productsSearch" class="mb-3">
                <b-media>
                    <router-link :to="{ name: 'ProductDetail', params: { id: product.product_id}}">
                        <h3 class="mt-0 font-weight-bold">{{ product.name }} </h3>
                    </router-link>
                    <b-list-group flush>
                        <b-list-group-item class="text-capitalize">
                            <strong>Product ID:</strong> {{ product.product_id }}
                        </b-list-group-item>
                        <b-list-group-item class="text-capitalize">
                            <strong>Brand:</strong> {{ product.brand }}
                        </b-list-group-item>
                        <b-list-group-item class="text-capitalize">
                            <strong>Type:</strong> {{ product.type }}
                        </b-list-group-item>
                        <b-list-group-item class="text-capitalize">
                            <strong>Above Ground:</strong> {{ product.aboveground ? 'Above Ground' : 'Below Ground' }}
                        </b-list-group-item>
                    </b-list-group>
                    <b-card-body>
                        <p class="card-text">
                            <strong>Description:</strong> {{ product.description }}
                        </p>
                    </b-card-body>
                </b-media>
            </b-card>
            <!--./Product Search  Listing-->
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
               productsSearch: [],
               pagination: [],
               errors: [],
               search_query: '',
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
                   this.productsSearch = [];
               }).catch((error) => {
                   this.errors = error.response.data;
                   this.unsuccessfulCall = true;
               })
           },
            searchProducts()
            {
                // Reset if the input is empty. This does not fix any bugs. Only on the UI side. :-/
                if (this.search_query.length === 0) {
                   this.fetchProducts(1);
                } else {
                    let uri = 'http://127.0.0.1:8000/api/products/search/query?q=' + this.search_query;
                    this.axios.get(uri, {
                        data: {},
                        contentType: 'application/json; charset=utf-8'
                    }).then((response) => {
                        this.productsSearch = response.data;
                        this.products = [];
                        this.successfulCall = true;
                        this.pagination = [];
                    }).catch((error) => {
                        this.unsuccessfulCall = true;
                    })
                }
            }
        }
    }
</script>

<style>
    code {
        background: #efefef;
        padding: 0 .25rem;
    }
</style>