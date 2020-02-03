<template>
    <div>
        <div v-if="!isLoggedIn">
            <button class="btn btn-outline-success my-2 my-sm-0" id="show-modal" @click="showModal = true">
                <span class="fa fa-sign-in"></span> Login
            </button>
        </div>
        <div v-else>
            Bienvenid@ {{user}}

            <button class="btn btn-outline-danger my-2 my-sm-0" @click="logout">
                <span class="fa fa-sign-out"></span> Logout
            </button>
        </div>

        <!--Ventana Modal, debe estar fuera de las condiciones o desaparece-->
        <app-login-form v-if="showModal" @close="showModal = false">
            <!-- you can use custom content here to overwrite default content -->
            <!--<h3 slot="header">custom header</h3>-->
        </app-login-form>

    </div>
</template>

<script>
import login from './loginForm.vue'

export default {
    data (){
        return {
            showModal: false,
            isLogged: false,
        }
    },
    components: {
        'app-login-form' : login,
    },
    computed : {
        isLoggedIn : function(){
            return this.$store.getters.isLoggedIn
        },
        user : function(){
            return this.$store.getters.user
        }
    },
    methods: {
        logout(){
            this.$store.dispatch('logout')
        }
    }
}
</script>

<style>

</style>
