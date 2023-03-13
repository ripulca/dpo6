<template>
  <div>
    <label>Учебное заведение</label>
    <div>
      <input type="text" v-model="inputValue">
      <ul v-show="vkData.universities.length > 0">
        <li v-for="university in vkData.universities" :key="university.id" @click="selectUniversity(university.id)">
          {{ university.title }}
        </li>
      </ul>
    </div>
  </div>
</template>
  
<script>
import { CONFIG } from "../config";
import jsonp from "jsonp";
export default {
  name: "ResumeInstituteInput",
  props: {
    modelValue: {
      type: String,
    },
    name: {
      type: String,
      required: true,
    },
    vkData: {
      type: Object,
      required: true
    },
  },
  emits: ['updated'],
  computed: {
    inputValue: {
      get() {
        return this.modelValue;
      },
      set(newValue) {
        if (this.vkData.selectedCity) {
          this.getUniversityList(newValue)
        }
        this.$emit('updated', this.name, newValue);
      }
    }
  },
  watch: {
    modelValue(newValue, oldValue) {
      this.$emit('updated', this.name, newValue);
    }
  },
  methods: {
    getUniversityList(query) {
      this.get('database.getUniversities', {
        country_id: this.vkData.russiaId,
        city_id: this.vkData.selectedCity.id,
        q: query,
        count: 10
      }, (function (err, data) {
        if (err) {
          console.error(err);
        } else if (data.error) {
          console.error(data.error)
        } else {
          this.vkData.universities = data.response.items;
        }
      }).bind(this));
    },
    selectUniversity(cityId) {
      let university = this.vkData.universities.find((city) => city.id === cityId);
      this.vkData.universities = [];
      this.$emit('university-selected', university);
      this.$emit('updated', this.name, university.title);
    },
    get(method, queryParams, fn) {
      queryParams.access_token = CONFIG.vk.token;
      queryParams.v = CONFIG.vk.version;
      queryParams.lang = 'ru';

      let uri = CONFIG.vk.uri + method + '?' + this.makeQueryString(queryParams);
      jsonp(uri, null, fn);
    },
    makeQueryString(queryParams) {
      return Array.from(Object.entries(queryParams))
        .map(value => value[0] + '=' + encodeURIComponent(value[1]))
        .join('&');
    }
  }
}
</script>