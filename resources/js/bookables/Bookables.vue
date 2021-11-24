<template>
  <div style="paddin: 1.25rem">
    Elements: {{ count }}
    <div v-if="loading">Data is loading ...</div>
    <div v-else>

      <div class="row">
        <div
          class="col-sm-12 col-md-6 col-lg-4  d-flex aling-items-strech"
          v-for="(bookable, colum) in bookables"
          :key="'row' + colum "
        >
          <bookable-list-item v-bind="bookable" class="mb-2"> </bookable-list-item>
        </div>
      </div>

      <!-- <div class="row mb-4" v-for="row in rows" :key="'row' + row">
        <div
          class="col d-flex aling-items-strech"
          v-for="(bookable, colum) in bookablesInRow(row)"
          :key="'row' + colum + row"
        >
          <bookable-list-item v-bind="bookable"> </bookable-list-item>
        </div>
        <div
          class="col"
          v-for="p in placeHolderInrRow(row)"
          :key="'pl' + p + row"
        ></div>
      </div> -->


    </div>
  </div>
</template>



<script>
/** Import the component child in the component parent , insted of globally */
import BookableListItem from "./BookableListItem";

export default {
  components: {
    BookableListItem: BookableListItem,
  },
  data() {
    return {
      bookables: null,
      loading: false,
      colums: 3,
    };
  },
  computed: {
    rows() {
      return this.bookables == null
        ? 0
        : Math.ceil(this.bookables.length / this.colums);
    },
    count() {
      return this.bookables == null
        ? 0
        :this.bookables.length;
    },
  },
  methods: {
    bookablesInRow(row) {
      return this.bookables.slice((row - 1) * this.colums, row * this.colums);
    },
    placeHolderInrRow(row) {
      return this.colums - this.bookablesInRow(row).length;
    },
  },
  created() {
    this.loading = true;
    //-- Here que request de API the info
    const request = axios.get("/api/bookables").then((response) => {
      (this.bookables = response.data.data), (this.loading = false);
    });

    console.log(request);
  },
};
</script>
