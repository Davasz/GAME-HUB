<template>
    <header>
        <img @click="onHome" src="../assets/img/icons/house-icon.svg" alt="home icon">
        <img src="../assets/img/icons/user-icon.svg" alt="user icon">
    </header>
</template>

<script>

// Import router
import { useRouter } from 'vue-router'

export default {
    setup() {

        // Router initialization
        const router = useRouter()

        // Redirect to home page
        const onHome = () => {
            router.replace("/")
        }

        // Returning variables
        return {
            onHome
        }
    }
}

</script>

<style scoped>
/* Mobile First */
header {
    display: flex;
    width: 90vw;
    margin: auto;
    margin-top: 2rem;
    justify-content: space-between;
}
img {
    cursor: pointer;
}
</style>