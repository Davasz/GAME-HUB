import { createStore } from 'vuex'
import axios from 'axios';

const API_KEY = "9bd59e06c3c54bebb78dd73797d56178"

export default createStore({
  state: {
    topGames: [],
    recomendedGames: [],
    games: {
      action: [],
      indie: [],
      arcade: [],
      shooter: [],
      casual: [],
      puzzle: [],
      search: []
    }
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
    },
    storeGames(state, data) {
      if (data.data.type === 'genres') {
        let local = data.data.genres
        data.response.forEach(element => {
          if (!state.games[local].some(game => game.id === element.id)) state.games[local].push(element)
        })
      } else {
        state.games.search = []
        data.response.forEach(element => {
          state.games.search.push(element)
        })
      }
    }
  },
  actions: {
    async storeTopGames({ commit }) {


      try {
        const response = await axios.get(`https://api.rawg.io/api/games?key=${API_KEY}&page_size=10`).then(e => e.data.results)
        commit('storeTopGames', response)
      } catch (error) {
        console.log(error)
      }
    },

    async storeRecomendedGames({ commit }) {

      try {
        const response = await axios.get(`https://api.rawg.io/api/games?key=${API_KEY}&page_size=10&page=2`).then(e => e.data.results)
        commit('storeRecomendedGames', response)
      } catch (error) {
        console.log(error)
      }
    },

    async storeGames({ commit }, data) {

      let query = ''

      if (data.type == 'genres') {
        query = `https://api.rawg.io/api/games?key=${API_KEY}&page_size=10&genres=${data.genres}`
      } else {
        console.log(data.search)
        query = `https://api.rawg.io/api/games?key=${API_KEY}&page_size=10&search=${data.search}`
      }

      try {
        const response = await axios.get(query).then(e => e.data.results)
        commit('storeGames', {
          response,
          data
        })
      } catch (error) {
        console.log(error)
      }
    }
  }
})
