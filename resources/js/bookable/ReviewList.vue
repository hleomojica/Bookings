<template>
  <div>
    <h6 class="test-uppercase text-secondary font-weight-bolder pt-4">
      Review List



    </h6>
    <div v-if="loading">Loading..</div>
    <div v-else>
      <div
        v-for="(review,index) in reviews"
        :key="index"
        class="border-bottom d-none d-md-block"
      >
        <div class="row pt-4">
          <div class="col-md-6">Henrry Mojica</div>
          <div class="col md-6 d-flex justify-content-end">
            <star-rating :value="review.rating"></star-rating>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">{{review.created_at | fromNow}}</div>
        </div>
        <div class="row pt-4 pb-4">
          <div class="col-md-12">{{review.content}}</div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";

export default {
  props: {
    bookableId: [String,Number],
  },
  data() {
    return {
      loading: false,
      reviews: null,
    };
  },
  created() {
    this.loading = true;
    axios
      .get(`/api/bookables/${this.bookableId}/reviews`)
      .then((response) => (this.reviews = response.data.data))
      .then(() => (this.loading = false));
  },
  // filters:{
  //   fromNow(val){
  //     return moment(val).fromNow();
  //   }
  // }
};
</script>
