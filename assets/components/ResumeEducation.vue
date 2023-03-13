<template>
  <div class="px-1 pt-2">
    <div>
      <ResumeSelect label="Образование" name="level" :options="educationTypes" @updated="educationChanged" :modelValue="modelValue.level"/>
      <div class="px-1 pt-2" v-show="modelValue.level && modelValue.level !== 'Среднее'">
        <ResumeInstituteInput name="institution" :vk-data="vkData" @updated="educationChanged" :modelValue="modelValue.institution"/>
        <ResumeInput type="text" label="Факультет" name="faculty" @updated="educationChanged" :modelValue="modelValue.faculty"/>
        <ResumeInput type="text" label="Специализация" name="specialization" @updated="educationChanged" :modelValue="modelValue.specialization"/>
        <ResumeInput type="number" label="Год окончания" name="gard_year" @updated="educationChanged" :modelValue="modelValue.graduationYear" error_message="нереалистичный год" />
      </div>
    </div>
  </div>
</template>
  
<script>
import ResumeSelect from "./ResumeSelect.vue";
import ResumeInput from "./ResumeInput.vue";
import ResumeInstituteInput from "./ResumeInstituteInput.vue";
export default {
  name: "ResumeEducation",
  components: { ResumeInstituteInput, ResumeInput, ResumeSelect },
  props: {
    // Данные об образовании
    modelValue: {
      type: Object,
      required: true
    },
    // Данные, полученные из ВК
    vkData: {
      type: Object
    },
  },
  emits: ['updated'],
  data() {
    return {
      educationTypes: ['Среднее',
        'Среднее специальное',
        'Неоконченное высшее',
        'Высшее',],
    }
  },
  methods: {
    educationChanged(field, value) {
      const education = structuredClone(this.modelValue);
      education[field] = value;
      this.$emit('updated', education);
    },
  }
}
</script>