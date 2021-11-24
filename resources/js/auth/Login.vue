<template>
  <div class="d-flex w-50 m-auto align-items-center">
    <div class="card card-body">
      <form>
        <div class="form-group">
          <label for="email"> E-mal</label>
          <input
            type="text"
            name="email"
            placeholder="Enter your e-mal"
            class="form-control"
            v-model="email"
            :class="[{ 'is-invalid': errorFor('email') }]"
          />
          <validation-errors :errors="errorFor('email')"></validation-errors>
        </div>
        <div class="form-group">
          <label for="password"> Password</label>
          <input
            type="password"
            name="password"
            placeholder="Enter your Password"
            class="form-control"
            v-model="password"
            :class="[{ 'is-invalid': errorFor('password') }]"
          />
          <validation-errors :errors="errorFor('password')"></validation-errors>
        </div>
        <button
          type="submit"
          class="btn btn-primary btn-lg btn-block"
          :disabled="loading"
          @click.prevent="login"
        >
          Log-in
        </button>
        <hr />
        <span class="text-nowrap">
          <div>
            No acount yet ?
            <router-link :to="{ name: 'home' }">Register</router-link>
          </div>
          <div>
            Dont remember
            <router-link :to="{ name: 'home' }">Register</router-link>
          </div>
        </span>
      </form>
    </div>
  </div>
</template>
<script>
import ValidationErrors from "../shared/components/ValidationErrors.vue";
import validationErrors from "../shared/mixins/validationErrors";
import { logIn } from "../shared/utils/auth";
import { mapActions } from "vuex";

export default {
  components: { ValidationErrors },
  mixins: [validationErrors],
  data() {
    return {
      loading: false,
      email: null,
      password: null,
    };
  },
  methods: {
    ...mapActions(["loadUser"]),
    async login() {
      this.loading = true;
      this.errors = null;
      try {
        await axios.get("/sanctum/csrf-cookie");
        await axios.post("/login", {
          email: this.email,
          password: this.password,
        });
        logIn();
        this.loadUser();
        this.$router.push({ name: "home" });
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
      this.loading = false;
    },
  },
};
</script>