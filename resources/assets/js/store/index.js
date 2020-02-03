import Vue from 'vue';
import Vuex from 'vuex';

import userStorage  from './userStorage';

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        userStorage,
    }
});

export default store
