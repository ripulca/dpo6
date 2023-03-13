<template>
  <router-view />
</template>

<script>

export default {
  name: 'App',
  components: {
  },
  data() {
    return {
      resumes: [],
      status: ['Новый', 'Назначено собеседование', 'Принят', 'Отказ'],
    }
  },
}
</script>
<style>
*{
  font-family: 'Montserrat', sans-serif;
}
</style>