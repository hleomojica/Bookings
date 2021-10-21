// --Imports Router
import VueRouter from 'vue-router';
import router from './routes';
import Index from './index.vue';
import moment from 'moment';
import StarRating from './shared/components/StarRating.vue';

require('./bootstrap');

window.Vue = require('vue');

// -- Import components
// -- There are more ways to call routers Globally.
/* Vue.component(
    'example-component',
     require('./components/ExampleComponent.vue').default
);

  */

Vue.component('star-rating',StarRating);

Vue.use(VueRouter); // -- renders views trhougt route.
Vue.filter("fromNow", value => moment(value).fromNow());

// -- Inicializated vue app on the ID app
const app = new Vue({
  el: '#app',
  router,
  components: {
    index: Index,
  },
});
