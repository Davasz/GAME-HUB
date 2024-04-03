<template>
    <input v-model="inputValue" type="text" placeholder="Enter the game" @keydown.enter="onSearch">
</template>

<script>

import { useStore } from 'vuex'

// Import vue functions
import { ref } from 'vue'
import { watch } from 'vue'

export default {

    setup(props, { emit }) {

        // Store initialization
        const store = useStore()

        let inputValue = ref('')

        watch(inputValue, (newValue) => {
            if (newValue) return emit('onSearch', true)
            emit('onSearch', false)
        })

        const onSearch = () => {
            emit('searched', {
                search : inputValue.value
            })
        }

        return {
            inputValue,
            onSearch,
            store
        }
    }
}
</script>

<style scoped>
input {
    font-family: 'Trueno';
    width: 85vw;
    height: 2.2rem;
    background-color: #01080D;
    color: #758DA9;
    font-size: 1em;
    border: 1px #ffffff solid;
    outline: none;
    border-radius: 46px;
    padding: 1.2rem;
    box-sizing: border-box;
    margin-top: 2rem;
}
</style>