<script setup>

// Import vue functions
import { onMounted, defineProps } from 'vue';

// Import gsap lib
import gsap from 'gsap';


// PROPS
const props = defineProps({
    textValue: String
})

// RENDER ANIMATION
onMounted(() => {
    const timeline = gsap.timeline();

    timeline.to(".box", { x: '115vw', duration: 1 })
        .to(".box", { x: 0, duration: 1, delay: 1.2 });
});
</script>

<template>
    <div class="box">
        <img src="../../assets/img/icons/error-icon.svg" alt="">
        <h1>{{props.textValue}}</h1>
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
    color: #ff0000;
    border-radius: 1rem;
    z-index: 9999;
    font-size: 0.5em;
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
        font-size: 1em;
    }
}
</style>