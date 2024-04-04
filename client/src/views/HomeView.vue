<template>

  <main>
    <h1>Browse games</h1>

    <div class="categories">
      <div @click="onGenres('all')" class="category">All</div>
      <div @click="onGenres('action')" class="category">Action</div>
      <div @click="onGenres('indie')" class="category">Indie</div>
      <div @click="onGenres('arcade')" class="category">arcade</div>
      <div @click="onGenres('shooter')" class="category">Shooter</div>
      <div @click="onGenres('casual')" class="category">Casual</div>
      <div @click="onGenres('puzzle')" class="category">Puzzle</div>
    </div>

    <TheSearch @searched="searched($event)" @onSearch="onSearch($event)" />

    <img v-if="showAnimation" class="loading-animation" src="../assets/img/animation/loading-animation.svg"
      alt="loading animation">

    <section v-if="!isOnSearch">

      <h1 class="tittle-medium">Top games</h1>

      <div class="container">
        <div class="cards">
          <TopGamesCard v-for="(game, index) in store.state.topGames" :key="index" :imageUrl="game.background_image"
            @redirectGame="redirectGame(game.slug)">

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

    <section v-if="isOnSearchGender">

      <h1 class="tittle-medium">{{ gameTypeTittle }} Games</h1>

      <div class="small-cards-container">
        <div class="small-game-cards">

          <GameCard v-for="(game, index) in gameStateLocal" :key="index" :imageUrl="game.background_image"
            @redirectGame="redirectGame(game.slug)">

            <template v-slot:card-game-name>
              <p class="card-game-name">{{ game.name }}</p>
            </template>

            <template v-slot:card-game-rate>
              <span class="card-game-rate">{{ game.rating }}</span>
            </template>

            <template v-slot:card-game-plataform-images>
              <img v-if="verifyPlataform(game.parent_platforms, 3)" src="../assets/img/icons/xbox-icon.svg"
                alt="Plataform icon">
              <img v-if="verifyPlataform(game.parent_platforms, 2)" src="../assets/img/icons/ps-icon.svg"
                alt="Plataform icon">
              <img v-if="verifyPlataform(game.parent_platforms, 1)" src="../assets/img/icons/win-icon.svg"
                alt="Plataform icon">
            </template>

          </GameCard>

        </div>
      </div>

    </section>

  </main>

</template>

<script>

// Import components
import TheSearch from '../components/TheSearch.vue'
import TopGamesCard from '../components/TopGamesCard.vue'
import GameCard from '../components/GameCard.vue'


// Import store
import { useStore } from 'vuex'

// Import vue functions
import { ref } from 'vue'

// Import router
import { useRouter } from 'vue-router'

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

    // Router initialization
    const router = useRouter()

    // Variables
    let isOnSearch = ref(false)
    let showAnimation = ref(false)
    let isOnSearchGender = ref(true)
    let gameTypeTittle = ref('Recomended')
    let gameStateLocal = ref(store.state.recomendedGames)

    // Load initial page
    if (!store.state.topGames[0]) {
      store.dispatch('storeTopGames')
    }
    if (!store.state.recomendedGames[0]) {
      store.dispatch('storeRecomendedGames')
    }

    // Methods

    // Animation
    const removeAnimation = () => {
      showAnimation.value = false
    }

    const apperAnimation = () => {
      showAnimation.value = true
    }

    // Utils
    const activeOnSearch = () => {
      isOnSearch.value = true
    }
    const removeOnSearch = () => {
      isOnSearch.value = false
    }
    const activeOnSearchGender = () => {
      isOnSearchGender.value = true
    }
    const removeOnSearchGender = () => {
      isOnSearchGender.value = false
    }
    const setGameTypeTittle = (type) => {
      gameTypeTittle.value = type
    }
    const setGameStateLocal = (local) => {
      gameStateLocal.value = local
    }

    // Redirect event handler
    const redirectGame = (gameSlug) => {
      router.replace(`/game/${gameSlug}`)
    }

    // Apper plataforms (pc: 3, ps: 2, xbox: 1)
    const verifyPlataform = (parentPlatforms, id) => {
      for (let i = 0; i < parentPlatforms.length; i++) {
        if (parentPlatforms[i].platform.id == id) {
          return true
        }
      }
      return false
    }

    // On search state
    const onSearch = (eventData) => {
      if (eventData && !store.state.games.search) {
        removeOnSearchGender()
        activeOnSearch()
        apperAnimation()
        return
      }

      // If nothing is being searched, disable the search state
      if (!eventData) {
        removeOnSearch()
        activeOnSearchGender()
        removeAnimation()
        setGameStateLocal(store.state.recomendedGames)
        setGameTypeTittle('Recomended')
      }
    }

    // On genres state
    const onGenres = async (genres) => {
      if (genres == 'all') {
        removeOnSearch()
        setGameTypeTittle('Recomended')
        setGameStateLocal(store.state.recomendedGames)
        return
      }

      activeOnSearch()
      removeOnSearchGender()
      apperAnimation()

      // Select games according to genre
      await store.dispatch('storeGames', {
        type: 'genres',
        genres
      })

      removeAnimation()
      activeOnSearchGender()
      setGameStateLocal(store.state.games[genres])

      // Capitalizes the first letter and concatenates it with the rest of the word
      setGameTypeTittle(genres.charAt(0).toUpperCase() + genres.slice(1))
    }

    // Searched state
    const searched = async (search) => {
      activeOnSearch()
      removeOnSearchGender()
      apperAnimation()

      // Select games according to search
      await store.dispatch('storeGames', {
        type: 'search',
        search: search.search
      })

      removeAnimation()
      activeOnSearchGender()

      setGameStateLocal(store.state.games.search) 
      setGameTypeTittle('Result')
    }



    // Returning variables
    return {
      store,
      verifyPlataform,
      onSearch,
      isOnSearch,
      onGenres,
      gameTypeTittle,
      gameStateLocal,
      isOnSearchGender,
      showAnimation,
      searched,
      redirectGame
    }
  }
}
</script>

<style scoped>

/* Mobile First */
main {
  display: flex;
  flex-direction: column;
  margin-left: 5vw;
  margin-top: 2rem;
  color: #ffffff;
  font-family: 'Trueno';
  font-size: 13px;
  padding-bottom: 5rem;
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
  cursor: pointer;
}

.tittle-medium {
  margin-top: 2rem;
  margin-bottom: 2rem;
  font-size: 17px;
}

.container {
  overflow-x: scroll;
  scrollbar-width: none;
}

.cards {
  display: inline-flex;
}

.loading-animation {
  margin: auto;
  margin-top: 7rem;
}

@media (min-width: 780px) {

  .small-game-cards {
    display: inline-flex;
    justify-content: center;
    width: 90vw;
    flex-wrap: wrap;
  }

  .container {
    overflow-x: scroll;
    scrollbar-width: auto;
  }

}
</style>