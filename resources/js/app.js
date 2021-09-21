
require('./bootstrap');
// --Imports Router
import router from "./routes";
import VueRouter from "vue-router"; 
import Index from "./index";

window.Vue = require('vue'); 

//-- Import components
//-- There are more ways to call routers Globally.
/* Vue.component(
    'example-component',
     require('./components/ExampleComponent.vue').default
); 

Vue.component(
    'example-2',
     require('./components/Example2.vue').default
);  */

Vue.use(VueRouter); // -- renders views trhougt route.

//-- Inicializated vue app on the ID app
const app = new Vue({
    el: '#app',
    router,
    components: {
        "index" :Index
    }
});
