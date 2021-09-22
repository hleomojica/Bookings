<template>
  <div>
    Rows is: {{ rows }}
    <div v-if="loading">Data is loading ...</div>
    <div v-else>
      <div class="row mb-4" v-for="row in rows" :key="'row' + row">
        <div
          class="col d-flex aling-items-strech"
          v-for="(bookable, colum) in bookablesInRow(row)"
          :key="'row' + colum + row"
        >
          <bookable-list-item
            v-bind="bookable"
          >
          </bookable-list-item>
        </div>
        <div
          class="col"
          v-for="p in placeHolderInrRow(row)"
          :key="'pl' + p + row"
        ></div>
      </div>
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
    const p = new Promise((resolve, reject) => {
      console.log(resolve);
      console.log(reject);
      setTimeout(() => resolve("Hello"), 3000);
    })
      .then((result) => console.log(`Succes ${result}`))
      .catch((result) => console.log(`Error ${result}`));
    console.log(p);

    const request = axios.get("/api/bookables").then((response) => {
      this.bookables = response.data,     
      this.loading = false;
    });
    console.log(request);
  },
};
</script>
