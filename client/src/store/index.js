import { createStore } from 'vuex'
import axios from 'axios';

export default createStore({
  state: {
    topGames: [],
    recomendedGames: []
  },
  getters: {
  },
  mutations: {
    storeTopGames(state, data) {
      data.forEach(element => {
        state.topGames.push(element)
      });
    },
    storeRecomendedGames(state, data) {
      data.forEach(element => {
        state.recomendedGames.push(element)
      });
    }
  },
  actions: {
    async storeTopGames({ commit }) {
      const API_KEY = "9bd59e06c3c54bebb78dd73797d56178"

      try {
        const response = await axios.get(`https://api.rawg.io/api/games?key=${API_KEY}&page_size=10`).then(e => e.data.results)
        commit('storeTopGames', response)
      } catch (error) {
        console.log(error)
      }
    },

    async storeRecomendedGames({ commit }) {
      const API_KEY = "9bd59e06c3c54bebb78dd73797d56178"

      try {
        const response = await axios.get(`https://api.rawg.io/api/games?key=${API_KEY}&page_size=10&page=2`).then(e => e.data.results)
        commit('storeRecomendedGames', response)
      } catch (error) {
        console.log(error)
      }
    }
  }
})
