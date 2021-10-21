<template>
  <div class="d-flex">
    <i
      class="fas fa-star"
      v-for="star in fullStars"
      :key="'full' + star"
      @click="$emit('input',star)"
    ></i>
    <i class="fas fa-star-half-alt" v-if="halfStar"></i>
    <i class="far fa-star" 
    v-for="star in emptyStart" 
    :key="'empty' + star" @click="$emit('input',fullStars+star)"></i>
  </div>
</template>
<script>
export default {
  props: {
    value: Number,
  },
  data() {
    return {
      empties: 0,
      half: false,
    };
  },
  computed: {
    halfStar() {
      return this.half;
    },
    fullStars() {  
      return Math.floor(this.value);
    },
    emptyStart() { 
          
      return 5- Math.floor(this.value)- (this.empties);
    },
  },
  created() {  
  if (this.value - Math.floor(this.value) > 0) {
      this.half = true;
      this.empties=1;
    }
  },
};
</script>
<style scoped>
i {
  color: gold;
  border-color: black;
}
</style>