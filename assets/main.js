import './styles/app.css';

// start the Stimulus application
import './bootstrap';
import { createApp } from 'vue'
import App from './App.vue'
import {createRouter, createWebHistory} from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';

import ResumeHome from './components/ResumeHome'
import ResumeResult from "./components/ResumeResult"

const router = createRouter({
    history: createWebHistory(),
    routes:[
      { path: '/', component: ResumeHome, name: 'home' },
      { path: '/add', component: ResumeResult, name: 'add' },
      { path: '/edit/:id', component: ResumeResult, name: 'edit'},
    ],    
    linkActiveClass: 'my-active-link'
  });
createApp(App).use(router, VueAxios, axios).mount('#app');
