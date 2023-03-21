<!-- меню -->
<template>
    <div>
        <router-link class="nav" :to="{ name: 'home' }">Главная</router-link>
        <router-link class="nav" :to="{ name: 'add' }">Новое резюме</router-link>
    </div>
    <ResumeTable/>
</template>
  
<script>
import ResumeTable from "./ResumeTable.vue"
export default {
    name: "ResumeHome",
    components: {
        ResumeTable
    },
}
</script>