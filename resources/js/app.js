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

window.Vue = require("vue");
Vue.use(VueRouter); // -- renders views trhougt route.
Vue.use(Vuex);

Vue.component("star-rating", StarRating);
Vue.component("fatal-error", FatalError);
Vue.component("success", Success);
Vue.component("validation-errors", ValidationErrors);
Vue.filter("fromNow", value => moment(value).fromNow());

const store = new Vuex.Store(storeDefinition);

// -- Inicializated vue app on the ID app
const app = new Vue({
    el: "#app",
    router,
    store,
    components: {
        index: Index
    },
    beforeCreate(){
      this.$store.dispatch("loadStoredState");
    }
});

// -- Import components
// -- There are more ways to call routers Globally.
/* Vue.component(
    'example-component',
     require('./components/ExampleComponent.vue').default
);

  */
