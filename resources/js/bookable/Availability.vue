<template>
  <div>
    <h6 class="text-uppercase text-secondary font-weight-bold">
      Availability checking all goo
    </h6>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="from">From: </label>
        <input
          v-model="from"
          type="text"
          name="from"
          class="form-control form-control-sm"
          placeholder="Start date"
          v-on:keyup.enter="check"
        />
      </div>

      <div class="form-group col-md-6">
        <label for="to">To: </label>
        <input
          v-model="to"
          type="text"
          name="to"
          class="form-control form-control-sm"
          placeholder="End date"
        />
      </div>
    </div>
    <button @click="check" class="btn btn-secondary btn-block">Check</button>
    <button @click="counters" class="btn btn-primary btn-block">Duplicator</button>
    <p class="label">The button above has been clicked {{counter}} times</p>
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
export default {
  data() {
    return {
      from: null,
      to: null,
      counter:0,
    };
  },
  methods:{
      check(){
          alert('Click works');
      },
      counters(){
          this.counter= this.counter+1;
          if(this.counter>10){
              alert('This countes has reach 10');
              this.counter=0;
          }
      }

  }
};
</script>