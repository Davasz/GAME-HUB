<template>

    <TheHeader />
    <div>
        {{ user }}
    </div>
</template>

<script>

import TheHeader from '@/components/TheHeader.vue'

// Import store
import { useStore } from 'vuex'

// Import vue functions
import { ref } from 'vue'

export default {
    components: {
        TheHeader
    },

    setup() {
        const store = useStore()

        let user = ref(' aaa')


        const loadData = async () => {
            if (!store.state.user.isLogin) {
                await store.dispatch('getUser')
                user.value = store.state.user.data
                return
            }
            user.value = store.state.user.data
        }
        loadData()
        return {
            store,
            user
        }

    }

}
</script>
<style>
div {
    color: white
}
</style>