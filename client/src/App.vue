<template>
  <TheHeader/>
  
  <HomeView/>
</template>

<script>

// Import global css
import '@/assets/css/global.css'
import TheHeader from '@/components/TheHeader.vue'
import HomeView from '@/views/HomeView.vue'

export default {
  name: 'App',
  components: {
    TheHeader,
    HomeView
  },
}
</script>