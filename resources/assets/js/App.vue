<template>
    <div class="w-100">
        <!--Header-->
        <header>
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    <router-link :to="{ name: 'ProductListing' }" class="navbar-brand">Leslie's Pools</router-link>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <router-link :to="{ name: 'ProductListing' }" class="nav-link">
                                    Products
                                </router-link>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Analytics
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarAnalyticsDropdown">
                                    <router-link :to="{ name: 'TrackerTraffic' }" class="dropdown-item">Traffic</router-link>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <!--./Header-->
        <!--Main Section-->
       <main>
           <div class="mt-5 mb-5 container">
               <transition name="fade">
                   <router-view></router-view>
               </transition>
           </div>
       </main>
        <!--./Main Section-->
        <!--Footer-->
        <footer style="background: #efefef" class="w-100 p-2">
            <p slot="footer" class="mb-0 text-center">Designed and Developed by Lamar Nelson</p>
        </footer>
        <!--/.Footer-->
    </div>
</template>

<script>
    export default {
    }
</script>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-active {
        opacity: 0;
    }
</style>