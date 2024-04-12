<template>
    <main>
        <ErrorAlert v-if="showErrorAlert" :text-value="errorText"></ErrorAlert>
        <div class="main">
            <input v-model="checkbox" type="checkbox" id="chk" aria-hidden="true">
            <div class="login">
                <form @submit.prevent="handleSubmit('login')" class="form">
                    <label for="chk" aria-hidden="true">Log in</label>
                    <input v-model="email" class="input" type="email" name="email" placeholder="Email" required>
                    <input v-model="password" class="input" type="password" name="password" placeholder="Password"
                        required>
                    <span v-if="password && password.length <= 6" style="color: red;">A senha deve ter no mínimo 6
                        caracteres</span>
                    <button>Login</button>
                </form>
            </div>

            <div class="register">
                <form @submit.prevent="handleSubmit('register')" class="form register-form">
                    <label class="register-label" for="chk" aria-hidden="true">Register</label>
                    <input v-model="name" class="input" type="text" name="txt" placeholder="Name" required>
                    <input v-model="email" class="input" type="email" name="email" placeholder="Email" required>
                    <input v-model="password" class="input" type="password" name="pswd" placeholder="Password" min="8"
                        required>
                    <span v-if="password && password.length <= 6" style="color: red;">A senha deve ter no mínimo 6
                        caracteres</span>
                    <button>Register</button>
                </form>
            </div>
        </div>
    </main>
</template>

<script setup>
import ErrorAlert from '@/components/alerts/ErrorAlert.vue'

// Import router
import { useRouter } from 'vue-router'

// Import store
import { useStore } from 'vuex'

// Import vue functions
import { ref } from 'vue'

const router = useRouter()
const store = useStore()

let checkbox = ref()
let showErrorAlert = ref(false)
let errorText = ref('')

let name = ref()
let email = ref()
let password = ref()

const handleSubmit = async (type) => {
    if (type == 'login') {
        try {
            await store.dispatch('login', {
                email: email.value,
                password: password.value
            })
        } catch (error) {
            showErrorAlert.value = true
            errorText.value = error.response.data.message
            setTimeout(() => {
                showErrorAlert.value = false
            }, 3000)
            return
        }
        router.push('/user')
    } else {
        try {
            await store.dispatch('register', {
                name: name.value,
                email: email.value,
                password: password.value
            })
            checkbox.value = false
        } catch (error) {
            showErrorAlert.value = true
            errorText.value = error.response.data.message
            setTimeout(() => {
                showErrorAlert.value = false
            }, 3000)
            return
        }

    }
}

</script>

<style scoped>
main {
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Trueno';
    overflow: hidden;
    position: absolute;
    height: 100vh;
    width: 100vw;
}

.main {
    min-width: 24rem;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    height: 100%;
    border-radius: 12px;
    box-shadow: 7px 7px 10px 3px #24004628;
}

.form {
    display: flex;
    flex-direction: column;
    gap: 14px;
    padding: 24px;
}

#chk {
    display: none;
}

.login {
    position: relative;
    width: 100%;
    height: 55%;
    margin-top: 4rem;
    margin-bottom: 7.5rem;
}

.login label {
    margin: 25% 0 5%;
}

label {
    color: #fff;
    font-size: 2rem;
    justify-content: center;
    display: flex;
    font-weight: bold;
    cursor: pointer;
    transition: .5s ease-in-out;
}

.input {
    width: 100%;
    height: 40px;
    background: #e0dede;
    padding: 10px;
    border: none;
    outline: none;
    border-radius: 4px;
}

.register-label {
    margin-bottom: 2rem;
}

.register-form {
    height: 50rem;
}

form {
    display: flex;
    align-items: center;
}

.register {
    background: #eee;
    height: 90rem;
    border-radius: 110% / 10%;
    transform: translateY(5%);
    transition: .8s ease-in-out;
}

.register label {
    color: #0E161F;
    transform: scale(.6);
}

#chk:checked~.register {
    transform: translateY(-49%);
}

#chk:checked~.register label {
    transform: scale(1);
    margin: 10% 0 5%;
}

#chk:checked~.login label {
    transform: scale(.6);
    margin: 5% 0 5%;
}

.form button {
    width: 85%;
    height: 40px;
    margin: 12px auto 10%;
    color: #fff;
    background: #0fa914;
    font-size: 1rem;
    font-weight: bold;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: .2s ease-in;
}

.form button:hover {
    background-color: #15d61b;
}
</style>