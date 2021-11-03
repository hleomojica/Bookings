<template>
<div class="row">
  <div :class=" [{'col-md-4': loading || !alreadyReviewed},{'d-none':!loading && alreadyReviewed}]"> 
    <div class="card">
      <div class="card-body">
        <div v-if="loading">Loading ..</div>
        <div v-else> 
          <p>
           Stayed at : <router-link :to ="{name:'bookable',params:{id:booking.bookable_id}}" > {{booking.bookable.tittle}}</router-link>
          </p>
          <p>
            From {{booking.from}}  To : {{booking.to}}
          </p>
        </div>
      </div>
    </div>
  </div>
  <div :class="[{'col-md-8': loading || !alreadyReviewed},{'col-md-12':!loading && alreadyReviewed}]" >  
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
          <star-rating class="fa-3x" v-model="review.rating"></star-rating>
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
          ></textarea>
        </div>
        <button class="btn- btn-lg btn-primary btn-block">Submit</button>
      </div>
    </div>
    </div>
  </div>
  
</div>
  
</template>
<script>
export default {
  data() {
    return {
      review: {
        rating: 5,
        content: null,
      },
      existingReview: null,
      loading: false,
      booking: null,
    };
  },
  methods: {
    onRatingChanged(rating) {
      console.log(rating);
    },
  },
  created() {
    this.loading = true;
    //- 1. Check if the review already exisst
    axios
      .get(`/api/reviews/${this.$route.params.id}`)
      .then((response) => {this.existingReview = response.data.data})
      .catch((err) => {
        if (
          err.response &&
          err.response.status &&
          404 === err.response.status
        ) {
          // Fetching a booking by review key
          return axios.get(`/api/booking-by-review/${this.$route.params.id}`).then(response=>{
            this.booking = response.data.data;
          });
        }
      })
      .then((response) => {
        this.loading = false;
      });

    // store the review
  },
  computed: {
    alreadyReviewed() {
      return this.hasReview || !this.booking;
      },
    hasReview(){
      return this.existingReview != null;
    },
    hasBooking(){
      return this.booking != null;
    }
  },
};
</script>