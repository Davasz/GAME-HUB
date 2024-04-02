<template>
    <div class="card-container">
        <div class="card-image">
            <img src="https://media.rawg.io/media/games/20a/20aa03a10cda45239fe22d035c0ebe64.jpg" alt="">
        </div>
        <div class="card-bottom">
            <div class="card-informations">
                <p>Grand Thef Auto 5</p>
                <img src="../assets/img/icons/star-icon.svg" alt="icon start">
                <span>4.5</span>
            </div>
            <img class="card-button" src="../assets/img/icons/button-icon.svg" alt="">
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.card-container {
    background-color: #0E161F;
    width: 17rem;
    height: 13rem;
    border-radius: 1.5rem;
    overflow: hidden;
    margin-right: 1rem;
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

.card-informations p {
    margin-right: 1rem;
    max-width: 8rem;
    word-wrap: break-word
}

.card-informations img {
    width: 1rem;
    height: 1rem;
}

.card-informations span {
    color: #FFCA4B;
    margin-left: 0.4rem;
}

.card-informations .card-button {
    width: 2rem;
    height: 2rem;
    margin-left: 1rem;
}
</style>