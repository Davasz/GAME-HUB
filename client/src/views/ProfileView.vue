<script setup>

import TheHeader from '@/components/TheHeader.vue'
import GameCard from '@/components/GameCard.vue'
import ErrorAlert from '@/components/alerts/ErrorAlert.vue'
import TopGamesCard from '../components/TopGamesCard.vue'

import gsap from 'gsap'


// Import router
import { useRouter } from 'vue-router'

import { useStore } from 'vuex'
import { ref, reactive } from 'vue'


const router = useRouter()
const store = useStore()

let showErrorAlert = ref(false)
let errorText = ref('')
let showModelDelete = ref(false)

let name = ref()
const favGames = reactive({
    number: 0,
    to: 0
})
let profileMedal = ref()
const bougthGames = reactive({
    number: 0,
    to: 0
})
const level = reactive({
    number: 0,
    to: 0
})

const loadInformations = async () => {
    name.value = store.state.user.data.name.split(' ')[0]
    favGames.to = store.state.user.data.game_likes.length
    bougthGames.to = store.state.user.data.game_bougts.length
    level.to = (bougthGames.to / 3).toFixed(1)
    gsap.to(favGames, { duration: 2, number: favGames.to || 0 })
    gsap.to(bougthGames, { duration: 2, number: bougthGames.to || 0 })
    gsap.to(level, { duration: 2, number: level.to || 0 })
    if (level.to < 10) profileMedal.value = 'bronze'
    if (level.to >= 10 && level.to < 30) profileMedal.value = 'silver'
    if (level.to >= 30) profileMedal.value = 'gold'

    try {
        await store.dispatch('getLikedGamesInformations', store.state.user.data.game_likes)
        await store.dispatch('getBoughtGamesInformations', store.state.user.data.game_bougts)
        console.log(store.state.user.loadBougthGames)
    } catch (error) {
        showErrorAlert.value = true
        errorText.value = 'Error when searching for games'
        setTimeout(() => {
            showErrorAlert.value = false
        }, 3000);
    }

}

const loadData = async () => {
    try {
        if (!store.state.user.isLogin) {
            await store.dispatch('getUser')
            loadInformations()
            return
        }
        loadInformations()
    } catch (error) {
        router.push('/login')
    }
}

loadData()

// Apper plataforms (pc: 3, ps: 2, xbox: 1)
const verifyPlataform = (parentPlatforms, id) => {
    for (let i = 0; i < parentPlatforms.length; i++) {
        if (parentPlatforms[i].platform.id == id) {
            return true
        }
    }
    return false
}

const onDelete = () => {
    showModelDelete.value = true
}

const cancelDelete = () => {
    showModelDelete.value = false
}

const confirmDelete = async () => {
    try {
        await store.dispatch('deleteUser')
        router.push("/login")
    } catch (error) {
        showErrorAlert.value = true
        errorText.value = 'Error deleting user'
        setTimeout(() => {
            showErrorAlert.value = false
        }, 3000);
    }
}

</script>

<template>

    <TheHeader />

    <main>
        <ErrorAlert v-if="showErrorAlert" :text-value="errorText"></ErrorAlert>
        <div class="greeting">
            <p>Wellcome,</p>
            <h1>{{ name }}</h1>
        </div>

        <div class="card-status-container">
            <div class="cards">
                <div class="card-status">
                    <div class="head-card-status">
                        <img src="../assets/img/icons/heart-icon.svg" alt="heart icon">
                        <p>Fav Games</p>
                    </div>
                    <span>{{ favGames.number.toFixed(0) }}</span>
                </div>
                <div class="card-status">
                    <div class="head-card-status">
                        <img src="../assets/img/icons/pixel-star-icon.svg" alt="star icon">
                        <p>Profile Level</p>
                    </div>
                    <span :class="profileMedal">{{ profileMedal }}</span>
                </div>
                <div class="card-status">
                    <div class="head-card-status">
                        <img src="../assets/img/icons/shopping-cart-icon.svg" alt="shopping cart icon">
                        <p>Bougth games</p>
                    </div>
                    <span>{{ bougthGames.number.toFixed(0) }}</span>
                </div>
            </div>
        </div>

        <div class="level-content">
            <h1>LEVEL</h1>
            <div class="level">
                <img src="../assets/img/exa-form.svg" alt="geometric form">
                <span>{{ level.number.toFixed(1) }}</span>
            </div>
        </div>

        <section class="bougth-games">
            <h1 id="bougth">Bougth games</h1>
            <div class="container">
                <div class="cards">
                    <TopGamesCard v-for="(game, index) in store.state.user.loadBougthGames" :key="index"
                        :imageUrl="game.background_image" @redirectGame="redirectGame(game.slug)">

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

        <section class="liked-games">
            <h1 id="like">Liked Games</h1>

            <div class="small-cards-container">
                <div class="small-game-cards">

                    <GameCard v-for="(game, index) in store.state.user.loadLikedGames" :key="index"
                        :imageUrl="game.background_image" @redirectGame="redirectGame(game.slug)">

                        <template v-slot:card-game-name>
                            <p class="card-game-name">{{ game.name }}</p>
                        </template>

                        <template v-slot:card-game-rate>
                            <span class="card-game-rate">{{ game.rating }}</span>
                        </template>

                        <template v-slot:card-game-plataform-images>
                            <img v-if="verifyPlataform(game.parent_platforms, 3)"
                                src="../assets/img/icons/xbox-icon.svg" alt="Plataform icon">
                            <img v-if="verifyPlataform(game.parent_platforms, 2)" src="../assets/img/icons/ps-icon.svg"
                                alt="Plataform icon">
                            <img v-if="verifyPlataform(game.parent_platforms, 1)" src="../assets/img/icons/win-icon.svg"
                                alt="Plataform icon">
                        </template>

                    </GameCard>
                </div>
            </div>
        </section>

        <div v-if="showModelDelete" class="modalDelete">
            <h1>Are you sure you want to delete this user (this action is irreversible)?</h1>
            <div class="buttons-delete">
                <button class="delete" @click="confirmDelete">Yes</button>
                <button class="cancel" @click="cancelDelete">No</button>
            </div>
        </div>

        <div class="buttons">
            <button @click="onEdit" class="edit">Edit profile</button>
            <button @click="onDelete" class="delete">Delete Profile</button>
        </div>

    </main>

</template>


<style scoped>
main {
    display: flex;
    flex-direction: column;
    font-family: 'Trueno';
    color: #FFFFFF;
    margin-top: 2rem;
    margin-left: 5vw;
    font-weight: 200;
    padding-bottom: 5rem;
}

.greeting h1 {
    color: #80FF85;
    font-size: 3em;
    max-width: 100vw;
    word-wrap: break-word;
    font-weight: 200;
    margin-top: 0.2rem;
}

.card-status-container {
    margin-top: 1rem;
    overflow-x: scroll;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.cards {
    display: inline-flex;
}

.head-card-status {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 0.5rem;
    gap: 0.5rem;
}

.card-status {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #191F26;
    width: 9.4rem;
    height: 5.5rem;
    border-radius: 10px;
    margin-right: 1.5rem;
}

.card-status span {
    font-family: 'Apex MK3';
    font-size: 2em;
}

.gold {
    color: #FFCA4B;
}

.silver {
    color: #758DA9;
}

.bronze {
    color: #6E4747;
}

.level-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 90vw;
    margin-top: 3rem;
}

.level {
    margin-top: 1rem;
    position: relative;
}

.level span {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    font-size: 6em;
    font-family: 'Apex MK3';
    color: #80FF85;
}

.buttons {
    display: flex;
    width: 90vw;
    gap: 2rem;
    justify-content: center;
    margin-top: 3rem;
}

.buttons .edit {
    width: 7rem;
    font-size: 0.8em;
    background-color: #80FF85;
    height: 2.6rem;
    border-radius: 10px;
}

.buttons .delete {
    width: 7rem;
    font-size: 0.8em;
    background-color: #F24F2B;
    height: 2.6rem;
    border-radius: 10px;
}

#like {
    margin-top: 3rem;
    margin-bottom: 1rem;
    font-size: 1.5em;
}

.container {
    overflow-x: scroll;
    scrollbar-width: none;
}

.cards {
    display: inline-flex;
}

#bougth {
    margin-top: 3rem;
    margin-bottom: 1rem;
    font-size: 1.5em;
}

.modalDelete {
    position: fixed;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 90%;
    height: 10rem;
    background-color: #191F26;
    color: #ffffff;
    font-size: 0.6em;
    text-align: center;
    border-radius: 14px;
    gap: 2rem;
}

.modalDelete h1 {
    font-weight: 200;
}

.buttons-delete .cancel {
    width: 7rem;
    font-size: 2em;
    background-color: #80FF85;
    height: 2.6rem;
    border-radius: 10px;
}

.buttons-delete .delete {
    width: 7rem;
    font-size: 2em;
    background-color: #F24F2B;
    height: 2.6rem;
    border-radius: 10px;
    margin-right: 1rem
}

@media (min-width: 780px) {
    main {
        margin-top: 0rem;
        padding-bottom: 0rem;
    }

    .greeting {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 90vw;
        margin: 0;
    }

    .card-status-container {
        display: flex;
        justify-content: center;
        width: 90vw
    }

    .liked-games {
        display: flex;
        flex-direction: column;
        justify-content: center;
        width: 90vw;
    }

    .small-game-cards {
        display: inline-flex;
        justify-content: center;
        width: 90vw;
        flex-wrap: wrap;
    }

    #like {
        text-align: center;
    }
}
</style>