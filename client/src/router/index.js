import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'home',
  
    component: () => import('../views/HomeView.vue')
  },
  {
    path: '/game/:slug',
    name: 'game',
  
    component: () => import('../views/GameView.vue')
  },
  {
    path: '/login',
    name: 'login',
  
    component: () => import('../views/LoginView.vue')
  },
  {
    path: '/user',
    name: 'user',
  
    component: () => import('../views/ProfileView.vue')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
