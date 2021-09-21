<template>
  <div>

    Rows is: {{rows}}

    <div v-if="loading"> Data is loading ...</div>
    <div v-else>

      <div class="row" v-for="row in rows " :key="'row'+row"  >
        <div class="col" v-for="(bookable,colum) in bookablesInRow(row) " :key="'row'+colum+row">
          <bookable-list-item 
            :item-tittle="bookable.tittle"
            :item-content="bookable.content">
          </bookable-list-item>                   
        </div>  
        <div class="col" v-for="p in placeHolderInrRow(row)" :key="'pl'+p+row"></div>    
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
  data(){
    return{
      bookables:null,
      loading :false,
      colums :3
    };
  },
 computed:{
   rows(){
     return this.bookables == null?0: Math.ceil(this.bookables.length/this.colums);
   }
 },
 methods:{
   bookablesInRow(row){
     return this.bookables.slice((row-1)*this.colums , row * this.colums)
   },
    placeHolderInrRow(row){
     return this.colums -  this.bookablesInRow(row).length;
   }
 },
  created(){       
    this.loading=true;
    setTimeout(() => { 
      this.bookables=[
        {
          tittle:"cheap villa here bb",
          content:"A very cheap villa " ,
          price:200
        },
        {
          tittle:"cheap villa 2",
          content:"A very cheap villa 2" 
        },
        {
          tittle:"cheap villa 2",
          content:"A very cheap villa 2" 
        },
        {
          tittle:"cheap villa 2",
          content:"A very cheap villa 2" 
        },
        {
          tittle:"cheap villa 2",
          content:"A very cheap villa 2" 
        },
        {
          tittle:"cheap villa 2",
          content:"A very cheap villa 2" 
        },
        {
          tittle:"cheap villa 2",
          content:"A very cheap villa 2" 
        }
      ];
      this.loading=false;
              
    }, 2000);
  
  },
  // beforeMount(){
  //   console.log("Before mounted");
  // },
  // mounted(){
  //   console.log("Mounted");

  // },
  // beforeDestroy(){
  //   console.log("Before destroyed");
  // },
  // destroyed(){
  //   console.log("Destroyed");
  // }

};
</script>
