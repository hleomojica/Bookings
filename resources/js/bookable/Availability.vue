<template>
  <div>
    <h6 class="text-uppercase text-secondary font-weight-bold">
      Check Availavility
    </h6>
    <transition name="fade">
      <p v-if="hasAvailability" class="text-success">Available!</p>
      <p v-if="noAvailability" class="text-danger">No Available</p>
    </transition>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="from">From: </label>
        <input
          v-model="from"
          type="text"
          name="from"
          class="form-control form-control-sm"
          placeholder="Start date"
          @keyup.enter="check"
          :class="[{ 'is-invalid': this.errorFor('from') }]"
        />
        <validation-errors :errors="errorFor('from')"></validation-errors>
      </div>

      <div class="form-group col-md-6">
        <label for="to">To: </label>
        <input
          v-model="to"
          type="text"
          name="to"
          class="form-control form-control-sm"
          placeholder="End date"
          :class="[{ 'is-invalid': this.errorFor('to') }]"
        />
        <validation-errors :errors="errorFor('to')"></validation-errors>
      </div>
    </div>
    <button
      @click="check"
      :disabled="loading"
      class="btn btn-secondary btn-block"
    >
    
    <span v-if="!loading"></span>
    <i v-else class="fas fa-spinner fa-spin"></i>
      Check
    </button>
  </div>
</template>

<style scoped>
label {
  font-size: 0.7rem;
  text-transform: uppercase;
  color: gray;
  font-weight: bolder;
}
</style>

<script>
import { is422 } from "./../shared/utils/response";
import validationErrors from "./../shared/mixins/validationErrors";
export default {
  props: {
    bookableId: [String, Number],
  },
  mixins: [validationErrors],
  data() {
    return {
      from: this.$store.state.lastSearch.from,
      to: this.$store.state.lastSearch.to,
      counter: 0,
      loading: false,
      errors: null,
      status: null,
    };
  },
  methods: {
    async check() {
      this.loading = true;
      this.errors = null;

      this.$store.dispatch("setLastSearch", {
        from: this.from,
        to: this.to,
      });

      try {
        this.status  = (await axios.get(
          `/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`
        )).status;
        // console.log(this.status);
        this.$emit("availability", this.hasAvailability);
      } catch (err) {
        if (is422(err)) {
          this.errors = err.response.data.errors;
        }
        this.status = err.response.status;
        this.$emit("availability",this.hasAvailability);
      }
      this.loading = false;
    },
  },
  computed: {
    hasErrors() {
      return this.status === 422 && this.errors !== null;
    },
    hasAvailability() {
      return this.status === 200;
    },
    noAvailability() {
      return this.status === 404;
    },
  },
};
</script>
