<template>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div v-if="!loading">
                    <div class="card-body">
                    <h2>{{bookable.tittle}}</h2>
                    <hr>
                    <article>{{bookable.description}}</article>
                    </div>
                </div>
                <div v-else>
                    loading...
                </div>                                
            </div>
        </div>    
        <div class="col-md-4">
            <p>availability & prices</p>        
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            bookable:null,
            loading: false
        };
    },
    created(){
       this.loading=true;     
        console.log(this.$route.path);
        axios.get(`/api/bookables/${this.$route.params.id}`).then(response => {this.bookable=response.data;this.loading = false;});
    }
}
</script>