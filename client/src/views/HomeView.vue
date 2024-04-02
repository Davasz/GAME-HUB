<template>
  <main>
    <h1>Browse games</h1>
    <div class="categories">
      <div class="category">Action</div>
      <div class="category">Indie</div>
      <div class="category">RPG</div>
      <div class="category">Shooter</div>
      <div class="category">Casual</div>
      <div class="category">Puzzle</div>
    </div>

    <TheSearch />

    <h1 class="tittle-medium">Top games</h1>

    <div class="container">
      <div class="cards">
        <TopGamesCard />
        <TopGamesCard />
        <TopGamesCard />
        <TopGamesCard />
        <TopGamesCard />
        <TopGamesCard />
        <TopGamesCard />
      </div>
    </div>


  </main>
</template>

<script>

import TheSearch from '../components/TheSearch.vue'
import TopGamesCard from '../components/TopGamesCard.vue'


export default {
  name: 'HomeView',
  components: {
    TheSearch,
    TopGamesCard
  }
}
</script>

<style scoped>
main {
  display: flex;
  flex-direction: column;
  margin-left: 2rem;
  margin-top: 2rem;
  color: aliceblue;
  font-family: 'Trueno';
  font-size: 13px;
}

.categories {
  display: flex;
  margin-top: 1rem;
  overflow-x: scroll;
  scrollbar-width: none;
  -ms-overflow-style: none;
}

.category {
  display: inline-block;
  background: rgb(128, 255, 133);
  background: linear-gradient(108deg, rgba(128, 255, 133, 1) 0%, rgba(0, 156, 7, 1) 100%);
  height: 2rem;
  border-radius: 2rem;
  margin-right: 2rem;
  color: #01080D;
  padding: 0rem 0.7rem;
  line-height: 2rem;
}

.tittle-medium {
  margin-top: 2rem;
  margin-bottom: 2rem;
  font-size: 17px;
}

.container {
  overflow-x: auto; 
  white-space: nowrap; 
  scrollbar-width: none;
  -ms-overflow-style: none;
}

.cards {
  display: inline-flex; 

}

</style>