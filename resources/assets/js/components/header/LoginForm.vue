<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">

        <div class="modal-header">

            <slot name="header">
                <h3>Sign In</h3>
                <button type="button" class="close" @click="$emit('close')" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </slot>
        </div>

        <div class="modal-body">
            <slot name="body">
                <form @submit.prevent="login">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input type="text" class="form-control" name="username" placeholder="Username" required="required" v-model="username">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							<input type="password" class="form-control" name="password" placeholder="Password" required="required" v-model="password">
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block btn-lg">Sign In</button>
					</div>
					<!--<p class="hint-text"><a href="#">Forgot Password?</a></p>-->
				</form>
            </slot>
        </div>

        <div class="modal-footer">
            <slot name="footer">
              <button class="btn btn-danger" @click="$emit('close')">
                Cerrar
              </button>
            </slot>
        </div>

        <!--<div class="modal-footer">
            <slot name="footer">
              default footer
              <button class="modal-default-button" @click="$emit('close')">
                OK
              </button>
            </slot>
        </div>-->

        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
    data (){
        return {
            username:'',
            password: '',
            hasErrors: null,
        }
    },
    methods: {
        login(){
            console.log('Enviado login');
            this.$store.dispatch('login',{username: this.username,password:this.password})
                .then(response  => {
                    this.$emit('close')
                })
                .catch(error => {
                    console.log(error)
                })
        }
    },
}
</script>

<style scoped>

.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}

.modal-container {
    width: 400px;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    transition: all .3s ease;
    font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
    margin-top: 0;
    color: #42b983;
}

.modal-body {
    margin: 20px 0;
}

.modal-default-button {
    float: right;
}

	.form-control {
		min-height: 38px;
		padding-left: 5px;
		box-shadow: none !important;
		border-width: 0 0 1px 0;
		border-radius: 0;
	}
	.form-control:focus {
		border-color: #ccc;
	}
	.input-group-addon {
		max-width: 42px;
		text-align: center;
		background: none;
		border-width: 0 0 1px 0;
		padding-left: 5px;
		border-radius: 0;
	}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>
