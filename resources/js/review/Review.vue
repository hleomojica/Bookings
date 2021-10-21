<template>
  <div>
    <div v-if=loading>Loading ..</div>
    <div v-else>
      <div v-if=alreadyReviewed> 
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
</template>
<script>
export default {
  data() {
    return {
      review: {
        rating: 5,
        content: null,
      },
      existingReview:null,
      loading : false,
    };
  },
  methods: {
    onRatingChanged(rating) {
      console.log(rating);
    },
  },
  created(){
    this.loading=true;
    //- 1. Check if the review already exisst
    axios.get(`/api/reviews/${this.$route.params.id}`).then(response => (this.existingReview = response.data.data))
    .catch(err=>{

    }).then(()=>{this.loading=false});
    //-- Fetch booking by review

    // store the review

  },
  computed:{
    alreadyReviewed(){
      return this.existingReview != null;
    }
  }
};
</script>