<template>
    <div>
        <app-navbar></app-navbar>

        <div class="container">
            <!--<router-view></router-view>-->
        </div>


    </div>
</template>

<script>

import header from './header/Navbar.vue'

export default {
    components : {
        'app-navbar' : header,
    }
}
</script>
