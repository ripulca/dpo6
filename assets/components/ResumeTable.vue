<!-- таблица резюме по статусам -->
<template>
  <div >
    <div v-for="(resumes, status) in resumeByStatus" :key="status" class="narrow card-list d-flex flex-column p-3 pb-0 border rounded-3 mx-2">
      <p class="text-center border-bottom mb-3 pb-3">{{ status + ' (' + resumes.length + ')' }}</p>
      <draggable :list="resumeByStatus[status]" group="resumes" itemKey="id" :sort="false" @end="changeStatus" :component-data="{ status: status }">
        <template #item="{ element }">
          <div class=" card rounded-3 mb-3">
            <img width="50" v-show="element.photo" :src="element.photo"  class="card-img-top">
            <div class="card-body">
              <p class="card-title">Профессия: {{ element.profession }}</p>
              <p class="card-text">{{ element.FIO }}</p>
              <p class="card-text text-sm-start">Возраст:{{ element.age }}</p>

              <router-link :to="{ name: 'edit', params: { id: element.id } }">
                Изменить
              </router-link>
            </div>
          </div>
        </template>
      </draggable>
    </div>
  </div>
</template>
  
<script>
import draggable from "vuedraggable";
import { api } from "../api";
export default {
  name: "ResumeTable",
  components: {
    draggable, api
  },
  data() {
    return {
      // Для отрисовки списков
      statuses: [
        'Новый',
        'Назначено собеседование',
        'Принят',
        'Отказ'
      ],
      resumeByStatus: {},
    };
  },
  created() {
    this.ResumeByStatus()
  },
  methods: {
    ResumeByStatus: function (e) {
      for (const status of Object.values(this.statuses)) {
        this.resumeByStatus[status] = [];
      }
      api
        .getAll()
        .then((response) => {
          if (response.status === 200) {
            const resumes = response.data;
            for (const resume of resumes) {
              this.resumeByStatus[resume.status].push(resume);
            }
            console.log(this.resumeByStatus);
          } else {
            this.error = response.data.error;
            console.log(response);
          }
        });
    },
    changeStatus: function (e) {
      const newStatus = e.to.getAttribute('status');
      const resumeId = this.resumeByStatus[newStatus][e.newIndex].id;
      api
        .updateStatus(resumeId, newStatus)
        .catch(function (error) {
          // handle error
          console.log(error);
        })
    }
  }
}
</script>
<style>
.row_list{
  display: flex;
  flex-direction: row important!;
}
.narrow{
  width: 20%;
}
</style>