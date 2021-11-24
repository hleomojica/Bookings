<template>
  <div>
    <success v-if="success"> Congratulations on your purchase! </success>
    <div class="row">
      <div class="col-md-8" v-if="itemsInBasket">
        <div class="row">
          <div class="col-md-6 form-group">
            <label for="first_name">First Name</label>
            <input
              type="text"
              class="form-control"
              name="first_name"
              v-model="customer.first_name"
              :class="[{ 'is-invalid': this.errorFor('customer.first_name') }]"
            />
            <validation-errors
              :errors="errorFor('customer.first_name')"
            ></validation-errors>
          </div>

          <div class="col-md-6 form-group">
            <label for="last_name">last Name</label>
            <input
              type="text"
              class="form-control"
              name="last_name"
              v-model="customer.last_name"
              :class="[{ 'is-invalid': this.errorFor('customer.last_name') }]"
            />
            <validation-errors
              :errors="errorFor('customer.last_name')"
            ></validation-errors>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 form-group">
            <label for="email">Email</label>
            <input
              type="text"
              class="form-control"
              name="email"
              v-model="customer.email"
              :class="[{ 'is-invalid': this.errorFor('customer.email') }]"
            />
            <validation-errors
              :errors="errorFor('customer.email')"
            ></validation-errors>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 form-group">
            <label for="street">Street</label>
            <input
              type="text"
              class="form-control"
              name="street"
              v-model="customer.street"
              :class="[{ 'is-invalid': this.errorFor('customer.street') }]"
            />
            <validation-errors
              :errors="errorFor('customer.street')"
            ></validation-errors>
          </div>
          <div class="col-md-6 form-group">
            <label for="city"> City</label>
            <input
              type="text"
              class="form-control"
              name="city"
              v-model="customer.city"
              :class="[{ 'is-invalid': this.errorFor('customer.city') }]"
            />
            <validation-errors
              :errors="errorFor('customer.city')"
            ></validation-errors>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 form-group">
            <label for="country">Country</label>
            <input
              type="text"
              class="form-control"
              name="country"
              v-model="customer.country"
              :class="[{ 'is-invalid': this.errorFor('customer.country') }]"
            />
            <validation-errors
              :errors="errorFor('customer.country')"
            ></validation-errors>
          </div>
          <div class="col-md-4 form-group">
            <label for="state">State</label>
            <input
              type="text"
              class="form-control"
              name="state"
              v-model="customer.state"
              :class="[{ 'is-invalid': this.errorFor('customer.state') }]"
            />
            <validation-errors
              :errors="errorFor('customer.state')"
            ></validation-errors>
          </div>
          <div class="col-md-2 form-group">
            <label for="zip">Zip</label>
            <input
              type="text"
              class="form-control"
              name="zip"
              v-model="customer.zip"
              :class="[{ 'is-invalid': this.errorFor('customer.zip') }]"
            />
            <validation-errors
              :errors="errorFor('customer.zip')"
            ></validation-errors>
          </div>
        </div>
        <hr />

        <div class="row">
          <div class="col-md-12 form-group">
            <button
              type="submit"
              v-if="itemsInBasket"
              class="btn btn-outline-success btn-block"
              @click.prevent="book"
              :disabled="loading"
            >
              Checkout
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-8" v-else>
        <div class="jumbotron jumbotron-fluid text-center">
          Your cart is empty
        </div>
      </div>
      <div class="col-md-4">
        <div class="d-flex justify-content-between">
          <h6 class="text-uppercase text-decondary font-weight-bolder">
            Your cart
          </h6>
          <h6 class="badge badge-secondary text-uppercase">
            <span v-if="itemsInBasket"> Items: {{ itemsInBasket }}</span>
            <span v-else> Empty</span>
          </h6>
        </div>

        <transition-group name="fade" tag="div">
          <div v-for="item in basket" :key="item.bookable.id">
            <div class="pd-2 pb-2 border-top d-flex justify-content-between">
              <span>
                <router-link
                  :to="{ name: 'bookable', params: { id: item.bookable.id } }"
                >
                  {{ item.bookable.tittle }}</router-link
                >
              </span>
              <span class="font-weight-bold">$ {{ item.price.total }}</span>
            </div>
            <div class="pd-2 pb-2 d-flex justify-content-between">
              <span> From : {{ item.dates.from }} </span>
              <span> To {{ item.dates.to }}</span>
            </div>
            <div class="pt-2 pb-2 text-right">
              <button
                class="btn btn-sm btn-outline-secondary"
                @click="$store.dispatch('removeFromBasket', item.bookable.id)"
              >
                <i class="fas fa-trash-alt"></i>
              </button>
            </div>
          </div>
        </transition-group>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapState } from "vuex";
import validationErrors from "./../shared/mixins/validationErrors";
export default {
  mixins: [validationErrors],
  data() {
    return {
      loading: false,
      bookingAttemp:false,
      customer: {
        first_name: null,
        last_name: null,
        email: null,
        street: null,
        city: null,
        country: null,
        state: null,
        zip: null,
      },
    };
  },
  computed: {
    ...mapGetters(["itemsInBasket"]),
    ...mapState({
      basket: (state) => state.basket.items,
      success() {

        return !this.loading && 0 === this.itemsInBasket && this.bookingAttemp;
      },
    }),
  },
  methods: {
    async book() {
      this.loading = true;
      this.errors = null;
      this.bookingAttemp = false;
      try {
        await axios.post("/api/checkout", {
          customer: this.customer,
          bookings: this.basket.map((item) => ({
            bookable_id: item.bookable.id,
            from: item.dates.from,
            to: item.dates.to,
          })),
        });
        this.$store.dispatch("clearBasket");
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
      this.loading = false;
      this.bookingAttemp = true;
    },
  },
};
</script>
<style scoped>
h6.badge {
  font-size: 100%;
}
a {
  color: black;
}
</style>