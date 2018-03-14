<template>
    <div>
        <!--Breadcrumb-->
        <b-row>
            <b-breadcrumb :items="items"/>
        </b-row>
        <!--./Breadcrumb-->

        <!--Header-->
        <b-row>
            <h1 class="pl-0 pt-4 pr-4 pb-4">Details</h1>
        </b-row>
        <!--./Header-->

        <!--Product Details-->
        <b-row v-if="product" class="w-100">
            <b-list-group class="mt-3 mb-5">
                <b-list-group-item class="text-capitalize">Product ID: {{ product.product_id }}</b-list-group-item>
                <b-list-group-item class="text-capitalize">Name: {{ product.name }}</b-list-group-item>
                <b-list-group-item class="text-capitalize">Brand: {{ product.brand }}</b-list-group-item>
                <b-list-group-item class="text-capitalize">Type: {{ product.type }}</b-list-group-item>
                <b-list-group-item class="text-capitalize">Above Ground: {{ product.aboveground ? 'True' : 'False' }}</b-list-group-item>
                <b-list-group-item>{{ product.description }}</b-list-group-item>
            </b-list-group>
        </b-row>
        <!--./Product Details-->

        <!--Product Images-->
        <b-row v-if="product.images.length > 0">
            <h3 class="mt-3">Images</h3>
            <b-row class="mt-3">
                <b-col cols="3" v-for="image in product.images" class="mb-3">
                    <b-img thumbnail fluid :src="image.path" alt="Thumbnail"/>
                </b-col>
            </b-row>
        </b-row>
        <!--Product Images-->
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
                        text: 'Product',
                        to: { name: 'ProductListing' },
                    },
                    {
                        text: 'Product',
                        href: '#',
                        active: true
                    }
                ],
                product: {
                    images: {}
                },
                successfulCall: false,
                unsuccessfulCall: false
            }
        },

        created: function()
        {
            this.fetchProduct()
        },

        methods: {
            fetchProduct()
            {
                let uri = 'http://127.0.0.1:8000/api/products/' + this.$route.params.id;
                this.axios.get(uri, {
                    data: {},
                    contentType: 'application/json; charset=utf-8'
                }).then((response) => {
                    this.product = response.data;
                    this.items[2].text = this.product.name;
                    this.successfulCall = true;
                }).catch((error) => {
                    this.unsuccessfulCall = false;
                })
            }
        }
    }
</script>

<style>

</style>