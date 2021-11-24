require("./bootstrap");
// --Imports Router
import VueRouter from "vue-router";
import Vuex from "vuex";
import router from "./routes";
import Index from "./index.vue";
import moment from "moment";
import StarRating from "./shared/components/StarRating.vue";
import FatalError from "./shared/components/FatalError.vue";
import Success from "./shared/components/Success.vue";
import ValidationErrors from "./shared/components/ValidationErrors.vue";
import storeDefinition from "./store";


import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'


import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

window.Vue = require("vue");
// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin

Vue.use(VueRouter); // -- renders views trhougt route.
Vue.use(Vuex);
Vue.component("star-rating", StarRating);
Vue.component("fatal-error", FatalError);
Vue.component("success", Success);
Vue.component("validation-errors", ValidationErrors);
Vue.filter("fromNow", value => moment(value).fromNow());


const store = new Vuex.Store(storeDefinition);
// -- Interceptor for each call from axios
window.axios.interceptors.response.use(
  response => {
    return response;
  },
  error =>{
    if(401 === error.response.status){
      store.dispatch("logout");
    }
    return Promise.reject(error);
  }
);

// -- Inicializated vue app on the ID app
const app = new Vue({
    el: "#app",
    router,
    store,
    components: {
        index: Index
    },

    async beforeCreate() {
        this.$store.dispatch("loadStoredState");
        this.$store.dispatch("loadUser");
    }
});
