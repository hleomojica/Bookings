<template>
  <div>
    <fatal-error v-if="error"></fatal-error>
    <success v-if="success">You've left a review thank you so much</success>
    <div class="row" v-else>
      <div :class="[{ 'col-md-4': twoColums }, { 'd-none': oneColum }]">
        <div class="card">
          <div class="card-body">
            <div v-if="loading">Loading ..</div>
            <div v-if="hasBooking">
              <p>
                Stayed at :
                <router-link
                  :to="{
                    name: 'bookable',
                    params: { id: booking.bookable.bookable_id },
                  }"
                >
                  {{ booking.bookable.tittle }}</router-link
                >
              </p>
              <p>From {{ booking.from }} To : {{ booking.to }}</p>
            </div>
          </div>
        </div>
      </div>
      <div :class="[{ 'col-md-8': twoColums }, { 'col-md-12': oneColum }]">
        <div>
          <div v-if="loading">Loading ..</div>
          <div v-else>
            <div v-if="alreadyReviewed">
              <h3>You've Already Reviewed</h3>
            </div>
            <div v-else>
              <div class="form-group">
                <label for="" class="text-muted">
                  Select the star rating ( 1 is worst best 5 )</label
                >
                <star-rating
                  class="fa-3x"
                  v-model="review.rating"
                ></star-rating>
              </div>
              <div class="form-group">
                <label for="content" class="text-muted"
                  >Described your expririence with
                </label>
                <textarea
                  name="content"
                  cols="30"
                  rows="10"
                  class="form-control"
                  v-model="review.content"
                  :class="[{ 'is-invalid': errorFor('content') }]"
                ></textarea>
                <validation-errors
                  :errors="errorFor('content')"
                ></validation-errors>
              </div>
              <button
                class="btn- btn-lg btn-primary btn-block"
                @click.prevent="submit"
                :disabled="sending"
              >
                Submit
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { is404, is422 } from "./../shared/utils/response";
import validationErrors from "./../shared/mixins/validationErrors";
export default {
  mixins: [validationErrors],
  data() {
    return {
      review: {
        id: null,
        rating: 5,
        content: null,
      },
      existingReview: null,
      loading: false,
      booking: null,
      error: false,
      sending: false,
      success:false,
    };
  },
  methods: {
    onRatingChanged(rating) {
      console.log(rating);
    },
  },
  async created() {
    this.review.id = this.$route.params.id;
    this.loading = true;
    //- 1. Check if the review already exisst
    try {
      this.existingReview = (
        await axios.get(`/api/reviews/${this.$route.params.id}`)
      ).data.data;
    } catch (err) {
      if (is404(err)) {
        try {
          this.booking = (
            await axios.get(`/api/booking-by-review/${this.review.id}`)
          ).data.data;
        } catch (err) {
          this.error = !is404(err);
        }
      } else {
        this.error = true;
      }
    }
    this.loading=false;

  },
  computed: {
    alreadyReviewed() {
      return this.hasReview || !this.booking;
    },
    hasReview() {
      return this.existingReview != null;
    },
    hasBooking() {
      return this.booking != null;
    },
    oneColum() {
      return !this.loading && this.alreadyReviewed;
    },
    twoColums() {
      return this.loading || !this.alreadyReviewed;
    },
  },
  methods: {
    submit() {
      this.sending = true;
      this.errors = null;
      this.success=false;
      axios
        .post(`/api/reviews`, this.review)
        .then(response => {
          this.success= 201=== response.status;
        })
        .catch((err) => {
          if (is422(err)) {
            const errors = err.response.data.errors;

            if (errors["content"] && _.size(errors) === 1) {
              this.errors = errors;
              return;
            }
          }
          this.error = true;
        })
        .then(() => (this.sending = false));
    },
  },
};
</script>
