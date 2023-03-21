<!-- формирование списка образований -->
<template>
  <div class="px-1 pt-2">
    <label class="form-label">Образования</label>
    <div v-for="(education, index) in educations" :key="education.id">
      <hr>
      <button @click="removeEducation(education.id)">Удалить</button>
      <ResumeEducation :modelValue="education" :vkData="vkData" @updated="(value) => educationChanged(index, value)" />
    </div>
    <hr>
    <button class="input-group" @click="addEducation">Добавить</button>
  </div>
</template>
  
<script>
import ResumeEducation from "./ResumeEducation.vue";
const EDUCATION_TEMPLATE = { index: 0, level: '', institution: '', faculty: '', specialization: '', gard_year: 0 }
export default {
  name: "ResumeEducationList",
  components: { ResumeEducation },
  emits: ['updated'],
  props: {
    modelValue: {
      type: Object,
      required: true
    },
    vkData: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      educations: []
    }
  },
  watch: {
    modelValue(newValue, oldValue) {
      if (!newValue) {
        this.educations = [];
      }
      this.educations = structuredClone(newValue);
      let index = 0;
      for (const education of this.educations) {
        education.index = index++;
      }
    }
  },
  methods: {
    addEducation(e) {
      let newEducation = structuredClone(EDUCATION_TEMPLATE);
      if (this.educations.length > 0) {
        newEducation.index = this.educations[this.educations.length - 1].index + 1;
      }
      this.educations.push(newEducation);
      this.$emit('updated', this.educations);
    },
    removeEducation(educationId) {
      let removingIndex = this.educations.findIndex((education) =>
          education.index === educationId);
      this.educations.splice(removingIndex, 1)
      this.$emit('updated', this.educations);
    },
    educationChanged(index, education) {
      this.educations[index] = education;
      this.$emit('updated', this.educations);
    },
  },
}
</script>