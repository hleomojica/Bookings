<template>
  <div class="row">
    <div class="col-md-8 pb-4">
      <div class="card">
        <div v-if="!loading">
          <div class="card-body">
            <h2>{{ bookable.tittle }}</h2>
            <hr />
            <article>{{ bookable.description }}</article>
          </div>
        </div>
        <div v-else>loading...</div>
      </div>
      <review-list :bookable-id="this.$route.params.id"></review-list>
    </div>

    <div class="col-md-4 pb-4">
      <availability
        class="mb-4"
        :bookable-id="this.$route.params.id"
        @availability="checkPrice($event)"
      ></availability>

      <transition name="fade">
        <price-breakdown
          v-if="price"
          :price="price"
          class="mb-4"
        ></price-breakdown>
      </transition>

      <transition name="fade">
        <button
          class="btn btn-outline-secondary btn-block"
          v-if="price"
          @click="addToBasket"
          :disabled="inBasketAlready"
        >
          Book now
        </button>
      </transition>
      <transition name="fade">
        <button
          class="btn btn-outline-danger btn-block"
          v-if="inBasketAlready"
          @click="removeFromBasket"
        >
         Remove From basket
        </button>
      </transition>

      <div v-if="inBasketAlready" class="mt-4 text-muted warning">
        Seems like you've added this object to basket already , if you want to
        change dates, remove from the basket first
      </div>
    </div>
  </div>
</template>
<script>
import Availability from "./Availability.vue";
import ReviewList from "./ReviewList.vue";
import PriceBreakdown from "./PriceBreakdown.vue";
import { mapState } from "vuex";

export default {
  components: {
    Availability,
    ReviewList,
    PriceBreakdown,
  },
  data() {
    return {
      bookable: null,
      loading: false,
      price: null,
    };
  },
  computed: mapState({
    lastSearch: "lastSearch",
    inBasketAlready(state) {
      if (null === this.bookable) {
        return false;
      }
      return state.basket.items.reduce(
        (result, item) => result || item.bookable.id === this.bookable.id,
        false
      );
    },
  }),
  created() {
    this.loading = true;
    // console.log(this.$route.path)
    axios.get(`/api/bookables/${this.$route.params.id}`).then((response) => {
      this.bookable = response.data.data;
      this.loading = false;
    });
  },
  methods: {
    async checkPrice(hasAvailability) {
      if (!hasAvailability) {
        this.price = null;
        return;
      }
      try {
        let res = await axios.get(
          `/api/bookables/${this.bookable.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`
        );
        this.price = res.data.data;
        console.log(this.price);
      } catch (err) {
        this.price = null;
      }
    },
    addToBasket() {
      this.$store.commit("addToBasket", {
        bookable: this.bookable,
        price: this.price,
        dates: this.lastSearch,
      });
    },
    removeFromBasket(){
      this.$store.commit("removeFromBasket", this.bookable.id)
    }
  },
};
</script>
