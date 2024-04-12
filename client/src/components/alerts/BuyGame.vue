<script setup>
import { onMounted } from 'vue';
import gsap from 'gsap';

onMounted(() => {
    const timeline = gsap.timeline();

    timeline.to(".box", { x: '115vw', duration: 1 })
        .to(".box", { x: 0, duration: 1, delay: 1.2 });
});
</script>

<template>
    <div class="box">
        <img src="../assets/img/icons/bougth-icon.svg" alt="">
        <h1>Game bougth with sucess, check your e-mail</h1>
    </div>
</template>

<style scoped>
div {
    position: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    left: -100vw;
    top: 40%;
    width: 70%;
    height: 10rem;
    background-color: #191F26;
    color: #FFFFFF;
    border-radius: 1rem;
}

img {
    width: 5rem;
    margin-left: 0.5rem;
    margin-right: 0.5rem;
}

@media (min-width: 780px) {
    div {
        left: -90vw;
        width: 50%;
    }
}
</style>