import axios from 'axios'

const AuthService = {
    login,
    //register
}

function login(username, password) {

    const formData = new FormData();

    formData.set('username', username);
    formData.set('password', password);

    return axios.post("/login", formData)
        .then(
            resp => {
                if(resp.data){
                    return resp.data
                }
                return null;
            })
        .catch(error => {
            //if (error.response.status == 422){
                return error.response.data;
            //}
        });
}

export default AuthService
