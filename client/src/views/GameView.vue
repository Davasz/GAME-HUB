<template>
    <main>
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

        <section class="about">
            <h1>About</h1>
            <p>{{ gameInformations.description_raw }}</p>

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
                    <p>{{ plataformText }}</p>
                </div>
                <div class="info">
                    <h1>Website</h1>
                    <a :href="site">{{ site }}</a>
                </div>
            </div>
        </section>
    </main>
</template>

<script>

// Import store
import { useStore } from 'vuex'

// Import vue functions
import { ref } from 'vue'

// Import router
import { useRoute } from 'vue-router'

// Date format lib
import { format } from 'date-fns';

export default {
    setup() {
        // Store initialization
        const store = useStore()

        // Router initialization
        const route = useRoute()

        // Variables
        let developers = ref('-')
        let genre = ref('-')
        let esrb = ref('-')
        let site = ref('-')
        let plataformText = ref('-')
        let date = ref('-')
        let showWin = ref()
        let showPs = ref()
        let showXbox = ref()

        let gameInformations = ref({

        })

        // Methods

        const alterVariables = (variable, newValue) => {
            variable.value = newValue
        }

        // Convert (yyyy-mm-dd) -> (MMM-dd- yyyy)
        const formatDate = (dateString) => {
            const formattedDate = format(new Date(dateString), 'MMM dd, yyyy');
            return formattedDate.toUpperCase();
        };

        const getGameInformations = async () => {
            // Select game according to slug route param
            await store.dispatch('getSelectedGame', route.params.slug)

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
                plataformText.value += game.platform.name + " "
            });
        }

        // Render game informations
        getGameInformations()

        // Returning variables
        return {
            route,
            store,
            getGameInformations,
            gameInformations,
            developers,
            genre,
            esrb,
            site,
            plataformText,
            date,
            showWin,
            showPs,
            showXbox
        }
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
    margin-top: 2rem;
    color: #ffffff;
    font-family: 'Trueno';
    font-size: 13px;
}

.header {
    width: 90%;
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

.about {
    display: flex;
    flex-direction: column;
    width: 90%;
    margin-top: 2rem;
    margin-bottom: 10rem;
}

.about h1 {
    font-size: 2em;
}

.about p {
    font-family: 'Inter';
}

.informations {
    margin-top: 3rem;
    display: flex;
    height: 5rem;
    flex-wrap: wrap;
    align-items: center;
    font-family: 'Trueno';
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

@media (min-width: 780px) {
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
}
</style>