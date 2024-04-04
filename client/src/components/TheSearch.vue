<template>
    <input v-model="inputValue" type="text" placeholder="Enter the game" @keydown.enter="onSearch">
</template>

<script>

// Import store
import { useStore } from 'vuex'

// Import vue functions
import { ref } from 'vue'
import { watch } from 'vue'

export default {

    setup(props, { emit }) {

        // Store initialization
        const store = useStore()

        // Reactive input value
        let inputValue = ref('')

        // Listening for input
        watch(inputValue, (newValue) => {
            // While has a new value, emit the search state to the father
            if (newValue) return emit('onSearch', true)
            emit('onSearch', false)
        })

        // Emits an event to the father when the enter key is clicked
        const onSearch = () => {
            emit('searched', {
                search : inputValue.value
            })
        }

        // Returning variables
        return {
            inputValue,
            onSearch,
            store
        }
    }
}
</script>

<style scoped>
/* Mobile First */
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