<template>
    <div class="card w-100"> 
        <div class="card-body">  
            <router-link :to="{name : 'bookable', params:{id}}">
                <h5 class="cart-title">{{tittle}}</h5>                 
                </router-link> 
                <p class="card-text">{{description}}</p>
        </div>
    </div>
</template>

<script>
export default {
    props:{ tittle: String, description:String,id:Number},
    mounted(){
      //console.log("Here IN THE ITEM"+this.price);
      //this.price=200; whe shouldn't modify props in child components
    }
}
</script>