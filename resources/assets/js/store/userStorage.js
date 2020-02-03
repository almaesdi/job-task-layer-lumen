import AuthService from 'services/authService.js'

export default {
	state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user : localStorage.getItem('user') || '',
    },
	getters : {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
        user: state => state.user,
    },
	actions: {
        login({ commit, dispatch }, { username, password }) {
            //Se inicia el request
            commit('auth_request')

            return new Promise((resolve, reject) => {
                AuthService.login(username, password)
                    .then(response  => {

                        if(response.success){
                            response = response.success
                            const token = response.data.token
                            const user = response.data.user
                            localStorage.setItem('token', token)
                            localStorage.setItem('user', user)
                            commit('auth_success', {'token':token,'user':user})
                            resolve(response)
                        }else{
                            commit('auth_error')
                            localStorage.removeItem('token')
                            localStorage.removeItem('user')
                            reject(response)
                        }
                    })
                    .catch(error => {
                        console.log('catch error: '.error);
                        commit('auth_error')
                        localStorage.removeItem('token')
                        localStorage.removeItem('user')
                        reject(error)
                    });
            })
        },
	    /*register({commit}, user){
	    	return new Promise((resolve, reject) => {
	            commit('auth_request')
	            axios({url: 'http://localhost:3000/register', data: user, method: 'POST' })
	            .then(resp => {
	                const token = resp.data.token
	                const user = resp.data.user
	                localStorage.setItem('token', token)
	                // Add the following line:
	                axios.defaults.headers.common['Authorization'] = token
	                commit('auth_success', token, user)
	                resolve(resp)
	            })
	            .catch(err => {
	                commit('auth_error', err)
	                localStorage.removeItem('token')
	                reject(err)
	            })
	        })
	    },*/
        logout({commit}){
              localStorage.removeItem('token')
              localStorage.removeItem('user')
              commit('logout')
	  	},
    },
	mutations: {
		auth_request(state){
	    	state.status = 'loading'
	  	},
	  	auth_success(state, { token, user }){
		    state.status = 'success'
		    state.token = token
            state.user = user
	  	},
	  	auth_error(state){
	    	state.status = 'error'
        },
	  	logout(state){
	    	state.status = ''
	    	state.token = ''
	  	},
	}
}
