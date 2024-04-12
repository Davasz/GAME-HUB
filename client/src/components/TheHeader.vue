<template>
    <header>
        <img @click="onHome" src="../assets/img/icons/house-icon.svg" alt="home icon">
        <div class="profile">
            <img @click="toggleDropdown" src="../assets/img/icons/user-icon.svg" alt="user icon">
            <div v-if="showDropdow" class="dropdown">
                <button @click="redirect(1)">{{ bt1Text }}</button>
                <button @click="redirect(2)" v-if="bt2Text">{{ bt2Text }}</button>
                <button @click="redirect(3)" v-if="bt3Text">{{ bt3Text }}</button>
            </div>
        </div>
    </header>
</template>

<script>

import { ref } from 'vue'

// Import router
import { useRouter } from 'vue-router'

// Import store
import { useStore } from 'vuex'

export default {
    setup() {

        let bt1Text = ref()
        let bt2Text = ref()
        let bt3Text = ref()
        let showDropdow = ref(false)

        // Router initialization
        const router = useRouter()

        const store = useStore()


        const loadData = async () => {
            try {
                if (!localStorage.getItem('token')) {
                    bt1Text.value = 'Login'
                    return
                }
                await store.dispatch('getUser')
                bt1Text.value = 'Profile'
                bt2Text.value = 'Likes'
                bt3Text.value = 'Logout'
            } catch (error) {
                router.push('/login')
            }
        }

        loadData()

        const toggleDropdown = () => {
            showDropdow.value = !showDropdow.value
        }

        const redirect = (button) => {
            if (button == 1) {
                if (bt1Text.value === 'Login') {
                    router.push('/login')
                    return
                }
                router.push('/user')
                return
            }
            if (button == 2) {
                router.push('/user/#likes')
                return
            }
            localStorage.removeItem('token')
            location.reload()
            router.push('/')
        }

        // Redirect to home page
        const onHome = () => {
            router.push("/")
        }

        // Returning variables
        return {
            onHome,
            bt1Text,
            bt2Text,
            bt3Text,
            toggleDropdown,
            showDropdow,
            redirect
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
    color: black;
}

img {
    cursor: pointer;
}

.dropdown {
    display: flex;
    flex-direction: column;
    position: absolute;
    width: 5rem;
    max-height: 10rem;
    background-color: #ffffff;
    right: 5%;
    border-radius: 0.3rem;
}

button {
    margin-top: 1rem;
    background-color: #ffffff;
    font-family: "Trueno";
    margin-bottom: 1rem;
}
</style>