<template>
    <div @click="redirectGame" class="card-container">
        <div class="card-image">
            <img :src="imageUrl" alt="Game image">
        </div>
        <div class="card-bottom">
            <div class="card-informations">
                <slot name="game-name"></slot>
                <img src="../assets/img/icons/star-icon.svg" alt="icon start">
                <slot name="game-rate"></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        imageUrl: {
            String
        }
    },

    setup(props, { emit }) {

        // Emits an event to the father when the button is clicked
        const redirectGame = () => {
            emit('redirectGame')
        }

        // Returning variables
        return {
            redirectGame
        }
    }
}
</script>

<style>
/* Mobile First */
.card-container {
    background-color: #0E161F;
    width: 17rem;
    height: 13rem;
    border-radius: 1.5rem;
    overflow: hidden;
    margin-right: 1rem;
    cursor: pointer;
}

.card-image {
    background-color: aliceblue;
    width: 100%;
    height: 70%;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-bottom {
    display: flex;
    align-items: center;
    height: 30%;
    width: 100%;
}

.card-informations {
    display: flex;
    align-items: center;
    font-size: 15px;
    color: #80FF85;
    width: 75%;
    margin-left: 1.5rem;
}

.card-informations .game-name {
    margin-right: 1rem;
    max-width: 8rem;
    word-wrap: break-word;
}

.card-informations img {
    width: 1rem;
    height: 1rem;
}

.card-informations .game-rate {
    color: #FFCA4B;
    margin-left: 0.4rem;
}

.card-informations .card-button {
    width: 2rem;
    height: 2rem;
    margin-left: 1rem;
}

.card-button {
    cursor: pointer;
}

@media (min-width: 780px) {

    .card-container {
        background-color: #0E161F;
        width: 20rem;
        height: 15rem;
        border-radius: 1.5rem;
        overflow: hidden;
        margin-right: 1rem;
        cursor: pointer;
    }

}
</style>