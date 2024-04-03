<template>
    <div class="card-game-conteiner">
        <div class="card-game-image">
            <img :src="imageUrl" alt="Game image">
        </div>
        <div class="card-game-informations">
            <div class="card-game-tittle">
                <slot name="card-game-name"></slot>
                <img src="../assets/img/icons/star-icon.svg" alt="icon start">
                <slot name="card-game-rate"></slot>
            </div>
            <div class="card-game-plataforms">
                <slot name="card-game-plataform-images"></slot>
            </div>
        </div>
        <img class="card-game-button" src="../assets/img/icons/button-icon.svg" alt="">
    </div>
</template>

<script>
export default {
    props: {
        imageUrl: {
            String
        }
    },

    setup() {
        return
    }
}
</script>

<style>
.card-game-conteiner {
    display: flex;
    align-items: center;
    width: 90%;
    height: 5rem;
    background-color: #0E161F;
    border-radius: 1.5rem;
    margin-bottom: 1rem;
}

.card-game-image {
    width: 3.6rem;
    height: 3.6rem;
    border-radius: 0.7rem;
    margin-left: 1rem;
    background-color: aliceblue;
}

.card-game-image img {
    width: 100%;
    height: 100%;
    border-radius: 0.7rem;
    object-fit: cover;
}

.card-game-informations {
    margin-left: 1rem;
    width: 60%;
}

.card-game-tittle {
    display: flex;
    align-items: center;
    color: #80FF85;
    font-size: 1em;
    margin-bottom: 0.6rem;
}

.card-game-name {
    max-width: 8rem;
    word-wrap: break-word;
    margin-right: 0.4rem;
}

.card-game-rate {
    color: #FFCA4B;
    margin-left: 0.2rem;
}

.card-game-plataforms img {
    margin-right: 0.4rem;
}
</style>