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
      search: [],
      gameSelected: []
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

    // This function stores games according to the genre and games searched
    storeGames(state, data) {
      if (data.data.type === 'genres') {
        let local = data.data.genres
        // Checks if the game already exists in the state, if not, adds it
        data.response.forEach(element => {
          if (!state.games[local].some(game => game.id === element.id)) state.games[local].push(element)
        })
      } else {
        // if data.type is not 'genres', clear the search state and add new games
        state.games.search = []
        data.response.forEach(element => {
          state.games.search.push(element)
        })
      }
    },

    // Clean game selected store and push new game
    storeSelectedGame(state, data) {
      state.games.gameSelected = []
      state.games.gameSelected.push(data)
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
        const response = await axios.get(`https://api.rawg.io/api/games?key=${API_KEY}&page_size=12&page=2`).then(e => e.data.results)
        commit('storeRecomendedGames', response)
      } catch (error) {
        console.log(error)
      }
    },

    async storeGames({ commit }, data) {
      let query = ''

      if (data.type == 'genres') {
        query = `https://api.rawg.io/api/games?key=${API_KEY}&page_size=12&genres=${data.genres}`
      } else {
        query = `https://api.rawg.io/api/games?key=${API_KEY}&page_size=12&search=${data.search}`
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
    },

    // Get game according to the slug
    async getSelectedGame({ commit }, data) {
      try {
        const response = await axios.get(`https://api.rawg.io/api/games/${data}?key=${API_KEY}&page_size=10`).then(e => e.data)
        commit('storeSelectedGame', response)
      } catch (error) {
        console.log(error)
      }
    }
  }
})
