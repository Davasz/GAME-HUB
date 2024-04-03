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

    <section>
      <div class="container">
        <div class="cards">
          <TopGamesCard v-for="(game, index) in store.state.topGames" :key="index" :imageUrl="game.background_image">

            <template v-slot:game-name>
              <p class="game-name">{{ game.name }}</p>
            </template>

            <template v-slot:game-rate>
              <span class="game-rate">{{ game.rating }}</span>
            </template>

          </TopGamesCard>
        </div>
      </div>
    </section>

    <section>
      <h1 class="tittle-medium">Recomended Games</h1>

      <GameCard v-for="(game, index) in store.state.recomendedGames" :key="index" :imageUrl="game.background_image">

        <template v-slot:card-game-name>
          <p class="card-game-name">{{ game.name }}</p>
        </template>
        <template v-slot:card-game-rate>
          <span class="card-game-rate">{{ game.rating }}</span>
        </template>

        <template v-slot:card-game-plataform-images>
          <img v-if="verifyPlataform(game.parent_platforms, 3)" src="../assets/img/icons/xbox-icon.svg" alt="Plataform icon">
          <img v-if="verifyPlataform(game.parent_platforms, 2)" src="../assets/img/icons/ps-icon.svg" alt="Plataform icon">
          <img v-if="verifyPlataform(game.parent_platforms, 1)" src="../assets/img/icons/win-icon.svg" alt="Plataform icon">
        </template>
      </GameCard>

    </section>

  </main>
</template>

<script>

import TheSearch from '../components/TheSearch.vue'
import TopGamesCard from '../components/TopGamesCard.vue'
import GameCard from '../components/GameCard.vue'


// Import store
import { useStore } from 'vuex'

export default {
  name: 'HomeView',
  components: {
    TheSearch,
    TopGamesCard,
    GameCard
  },

  setup() {
    // Store initialization
    const store = useStore()

    if (!store.state.topGames[0]) {
      store.dispatch('storeTopGames')
    }
    if (!store.state.recomendedGames[0]) {
      store.dispatch('storeRecomendedGames')
    }


    const verifyPlataform = (parentPlatforms, id) => {
    for(let i = 0; i < parentPlatforms.length; i++) {
        if(parentPlatforms[i].platform.id == id) {
            return true
        }
    }
    return false
}


    return {
      store,
      verifyPlataform
    }
  }
}
</script>

<style scoped>
main {
  display: flex;
  flex-direction: column;
  margin-left: 2rem;
  margin-top: 2rem;
  color: #ffffff;
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
  background: linear-gradient(108deg, rgba(128, 255, 133, 1) 0%, rgb(1, 145, 8) 100%);
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
  overflow-x: scroll;
  scrollbar-width: none;
  -ms-overflow-style: none;
}

.cards {
  display: inline-flex;
}
</style>