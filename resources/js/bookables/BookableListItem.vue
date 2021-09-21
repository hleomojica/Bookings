<template>
    <div class="card"> 
        <div class="card-body">            
             <h5 class="cart-title">{{itemTittle}}</h5>           
             <p class="card-text">{{itemContent}}</p>
        </div>
    </div>
</template>

<script>
export default {
    props:{ itemTittle: String, itemContent:String,price:Number},
    mounted(){
      console.log("Here IN THE ITEM"+this.price);
      //this.price=200; whe shouldn't modify props in child components
    }
}
</script>