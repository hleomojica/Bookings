<template>
  <div>
    <b-navbar
      class="navbar navbar-expand-lg bg-white border-bottom navbar-light"
    >
      <router-link class="navbar-brand mr-auto" :to="{ name: 'home' }"
        >Home</router-link
      >

      <b-navbar-nav class="ml-auto">
        <b-nav-item>
          <router-link class="btn nav-link" :to="{ name: 'basket' }"
            ><i class="fas fa-shopping-basket"></i>
            Basket
            <span v-if="itemsInBasket" class="badge badge-secondary">
              {{ itemsInBasket }}
            </span>
          </router-link>
        </b-nav-item>

        <b-nav-item v-if="!isLoggedIn">
          <router-link :to="{ name: 'register' }" class="nav-link"
            >Register</router-link
          >
        </b-nav-item>

        <b-nav-item v-if="!isLoggedIn">
          <router-link :to="{ name: 'login' }" class="nav-link"
            >Sign In</router-link
          >
        </b-nav-item>

        <b-nav-item v-if="isLoggedIn">
          <a class="nav-link" href="#" @click.prevent="clickLogout">Logout</a>
        </b-nav-item>
      </b-navbar-nav>
    </b-navbar>
    <div class="container mt-4 mb-4 pr-4 pl-4">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
import { mapState, mapGetters, mapActions } from "vuex";

export default {
  computed: {
    ...mapState({
      lastSearchComputed: "lastSearch",
      isLoggedIn: "isLoggedIn",
    }),
    ...mapGetters({
      itemsInBasket: "itemsInBasket",
    }),
  },
  methods: {
    ...mapActions(["logout"]),
    async clickLogout() {
      try {
        await axios.post("/logout");
        this.logout();
      } catch (error) {
        this.logout();
      }
    },
  },
};
</script>

