<script setup>





</script>

<style scoped>

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  margin-left: 3rem;
  margin-right: 3rem;
}
h1 {
  color: rgb(8, 8, 155);
  font-family: 'Poppins', sans-serif;
  display: flex;
}
h5 {
  color: white;
  font-family: 'Poppins', sans-serif;
}
.search-wrapper {
  display: flex;
  align-items: center;
  width: 20%;
  max-width: 350px;
}

.search-wrapper input {
  flex: 1;
  padding: 10px;
  border: 1px solid #444;
  color: white;
  border-radius: 0 8px 8px 0;
  outline: none;
}

.search-wrapper button {
  padding: 9px 5px;
  border: 1px solid #444;
  border-radius: 8px 0 0 8px;
  cursor: pointer;
  transition: 0.2s;
}

.search-wrapper button:hover {
  background: #475569;
}
.cart {
  width: 6rem;
  height: 2rem;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 3px;
  border: 2px solid #444;
  background-color: rgb(8, 8, 155);
  cursor: pointer;
  
}

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap');
</style>


<template>
  <header>
    
    <h1> TechFusion </h1>

    <div class="search-wrapper"> 
      <button>🔍</button>
  <input type="text" placeholder="Buscar...">
 
</div>

<div class="cart"> <h5>Cart</h5> </div>

  </header>

</template>

<style scoped>

</style>
