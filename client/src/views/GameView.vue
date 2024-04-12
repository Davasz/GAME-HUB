<template>
    <TheHeader />
    <main>
        <section class="head-informations">
            <img v-if="showAnimation" class="loading-animation" src="../assets/img/animation/loading-animation.svg"
                alt="loading animation">
            <section class="header">
                <div class="head">
                    <div class="date"><span>{{ date }}</span></div>
                    <img v-if="showWin" src="../assets/img/icons/xbox-icon.svg" alt="Plataform icon">
                    <img v-if="showPs" src="../assets/img/icons/ps-icon.svg" alt="Plataform icon">
                    <img v-if="showXbox" src="../assets/img/icons/win-icon.svg" alt="Plataform icon">
                </div>

                <h1>{{ gameInformations.name }}</h1>


                <div class="game-img">
                    <img :src="gameInformations.background_image" alt="Game image">
                </div>

                <div class="adtional">
                    <div class="hours">
                        <img src="../assets/img/icons/clock-icon.svg" alt="clock icon">
                        <span>{{ gameInformations.playtime }} H</span>
                    </div>

                    <div class="rate">
                        <img src="../assets/img/icons/star-icon.svg" alt="star icon">
                        <span>{{ gameInformations.rating }}</span>
                    </div>
                </div>
            </section>

            <FavGame v-if="showAlertFav"></FavGame>
            <BuyGame v-if="showAlertBuy"></BuyGame>
            <ErrorAlert v-if="showErrorAlert" :text-value="errorText"></ErrorAlert>

            <section class="about-informations">
                <div class="informations">
                    <div class="info">
                        <h1>Developer</h1>
                        <p>{{ developers }}</p>
                    </div>
                    <div class="info-right">
                        <h1>Genre</h1>
                        <p>{{ genre }}</p>
                    </div>
                    <div class="info">
                        <h1>Esrb Rate</h1>
                        <p>{{ esrb }}</p>
                    </div>
                    <div class="info-right">
                        <h1>Plataforms</h1>
                        <ol>
                            <li v-for="(plataform, index) in plataformText" :key="index">{{ plataform }}</li>
                        </ol>
                    </div>
                    <div class="info">
                        <h1>Website</h1>
                        <a target="_blank" :href="site">{{ site }}</a>
                    </div>
                </div>
                <button @click="onBuy">BUY GAME</button>
                <button @click="onFav">FAV GAME</button>
            </section>
        </section>
        <div class="about">
            <h1>About</h1>
            <p>{{ gameInformations.description_raw }}</p>
        </div>

    </main>
</template>

<script setup>

// Import components
import TheHeader from '@/components/TheHeader.vue'
import FavGame from '@/components/alerts/FavGame.vue'
import BuyGame from '@/components/alerts/BuyGame.vue'
import ErrorAlert from '@/components/alerts/ErrorAlert.vue'

// Import store
import { useStore } from 'vuex'

// Import vue functions
import { ref } from 'vue'

// Import router
import { useRoute, useRouter } from 'vue-router'

// Date format lib
import { format } from 'date-fns';

// Store initialization
const store = useStore()

// Router initialization
const route = useRoute()
const router = useRouter()

// Variables
let showAnimation = ref(false)
let developers = ref('-')
let genre = ref('-')
let esrb = ref('-')
let site = ref('-')
let plataformText = []
let date = ref('-')
let showWin = ref()
let showPs = ref()
let showXbox = ref()
let showAlertFav = ref(false)
let showAlertBuy = ref(false)
let showErrorAlert = ref(false)
let errorText = ref('')

let gameInformations = ref({

})

// Methods

// Animation
const removeAnimation = () => {
    showAnimation.value = false
}

const apperAnimation = () => {
    showAnimation.value = true
}

const alterVariables = (variable, newValue) => {
    variable.value = newValue
}

// Convert (yyyy-mm-dd) -> (MMM-dd- yyyy)
const formatDate = (dateString) => {
    const formattedDate = format(new Date(dateString), 'MMM dd, yyyy');
    return formattedDate.toUpperCase();
};

const getGameInformations = async () => {
    apperAnimation()
    // Select game according to slug route param
    await store.dispatch('getSelectedGame', route.params.slug)

    removeAnimation()

    gameInformations.value = store.state.games.gameSelected[0]

    alterVariables(date, formatDate(gameInformations.value.released))

    // Apper plataforms (pc: 3, ps: 2, xbox: 1)
    let plataforms = gameInformations.value.parent_platforms
    for (let i = 0; i < plataforms.length; i++) {
        if (plataforms[i].platform.id == 3) {
            alterVariables(showWin, true)
        } else if (plataforms[i].platform.id == 2) {
            alterVariables(showPs, true)
        } else if (plataforms[i].platform.id == 1) {
            alterVariables(showXbox, true)
        }
    }

    alterVariables(developers, gameInformations.value.developers[0]?.name ?? '-')
    alterVariables(genre, gameInformations.value.genres[0]?.name ?? '-')
    alterVariables(esrb, gameInformations.value.esrb_rating?.name ?? '-')
    alterVariables(site, gameInformations.value?.website ?? '-')
    alterVariables(plataformText, '')

    gameInformations.value.platforms.forEach(game => {
        plataformText.push(game.platform.name)
    });
}

// Render game informations
getGameInformations()

const onFav = async () => {
    if (!localStorage.getItem('token')) {
        router.push('/login')
        return
    }
    try {
        await store.dispatch('favGame', {game_slug : route.params.slug})
        showAlertFav.value = true
        setTimeout(() => {
            showAlertFav.value = false
        }, 3000);
    } catch (error) {
        showErrorAlert.value = true
        errorText.value = 'You already fav this game'
        setTimeout(() => {
            showErrorAlert.value = false
        }, 3000)
    }
}

const onBuy = async () => {
    if (!localStorage.getItem('token')) {
        router.push('/login')
        return
    }
    try {
        await store.dispatch('buyGame', {game_slug : route.params.slug})
        showAlertBuy.value = true
        setTimeout(() => {
            showAlertBuy.value = false
        }, 3000);
    } catch (error) {
        showErrorAlert.value = true
        errorText.value = 'You already buy this game'
        setTimeout(() => {
            showErrorAlert.value = false
        }, 3000)
    }
}


</script>

<style scoped>
/* Mobile First */
main {
    display: flex;
    flex-direction: column;
    width: 100%;
    align-items: center;
    justify-content: center;
    margin-top: 2rem;
    color: #ffffff;
    font-family: 'Trueno';
    font-size: 13px;
}

.head-informations {
    width: 90%;
}

.header {
    width: 100%;
}

.head {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.head img {
    width: 1.3rem;
}

.date {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 6.5rem;
    height: 1.3rem;
    background-color: #D9D9D9;
    color: #01080D;
    border-radius: 0.25rem;
    margin-right: 1rem;
}

h1 {
    font-size: 3em;
    font-weight: 100;
    margin-bottom: 1rem;
    word-wrap: break-word;
}


.game-img img {
    width: 100%;
    height: 100%;
    border-radius: 1rem;
    object-fit: cover;
}

.adtional {
    display: flex;
    justify-content: end;
    margin-top: 0.4rem;
    align-items: center;
}

.rate,
.hours {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.2em;
}

.adtional span {
    margin-left: 0.2rem;
}

.adtional img {
    width: 20px;
    height: 20px;
}

.rate {
    color: #FFCA4B;
    margin-left: 1rem;
}

.about-informations {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    margin-top: 1rem;
}

.informations {
    margin-top: 3rem;
    display: flex;
    height: 50%;
    flex-wrap: wrap;
    align-items: center;
    font-family: 'Trueno';
    margin-bottom: 4rem;
}

.info {
    text-align: start;
    width: 65%;
    margin-bottom: 2rem;
}

.info-right {
    text-align: start;
    width: 35%;
    margin-bottom: 2rem;
}

.informations h1 {
    font-size: 1.1em;
    color: #B4B4B4;
    margin-bottom: 0;
    font-weight: 100;
}

.informations p,
a {
    color: #FFFFFF;
}

button {
    background-color: #ffffff;
    width: 90%;
    height: 3rem;
    margin-bottom: 1rem;
    font-size: 1.3em;
    transition: 0.4s;
}

button:hover {
    background-color: #e0e0e0;
}

.about {
    width: 90%;
    margin-top: 3rem;
    margin-bottom: 5rem;
}

.about h1 {
    font-size: 2em;
}

.about p {
    font-family: 'Inter';
}

@media (min-width: 780px) {
    .head-informations {
        display: flex;
        gap: 1.5rem;
    }

    .header {
        width: 60%;
    }

    .about-informations {
        width: 40%;
        margin-top: 3rem;
        flex-direction: column;
    }

    .game-img img {
        width: 100%;
        height: 100%;
        border-radius: 1rem;
        object-fit: cover;
    }

    .game-img {
        width: 100%;
        height: 30rem;
    }

    .about {
        font-size: 1.3em;
        margin-top: 1rem;
    }
}
</style>