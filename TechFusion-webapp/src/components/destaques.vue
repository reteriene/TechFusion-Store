<script setup>



</script>

<style scoped>

h2 {
    margin-left: 3rem;
}
section{
    display: flex;
    justify-content: space-evenly;
}


</style>

<template>

                <h2> Produtos mais vendidos.</h2>

<section>

    <div class="containerprodutos" v-for="value in source"></div>



</section>

    
</template>