<!-- ввод с обработчиком ошибок -->
<template>
  <div class="px-1 pt-2">
    <label class="form-label">{{ label }}</label>
    <input class="input-group" :type="type" v-model="inputValue" />
    <div v-if="!valid && error_message">
      <span class="error_message">{{ error_message }}</span>
    </div>
  </div>
</template>
  
<script>
export default {
  name: "ResumeInput",
  props: {
    modelValue: {},
    error_message: {
      type: String,
      required: false,
    },
    name: {
      type: String,
      required: true,
    },
    label: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      required: true,
    },
    regex: {
      type: String,
      default: ""
    },
  },
  emits: ['updated',],
  watch: {
    modelValue(newValue, oldValue) {
      this.$emit('updated', this.name, newValue);
    }
  },
  computed: {
    inputValue: {
      get() {
        return this.modelValue;
      },
      set(newValue) {
        if (this.name == 'grad_year') {
          console.log(newValue);
        }
        this.$emit('updated', this.name, newValue);
      }
    },
    valid() {
      if (this.inputValue) {
        if (this.type == 'date') {
          let min = Date.parse('01.01.1970');
          let max = Date.parse('01.01.2010');
          let str=new Date(this.inputValue);
          str=str.toDateString();
          let birthDate=Date.parse(str);
          console.log(birthDate);
          if (birthDate > max || birthDate < min) {
            return false;
          }
          return true;
        }
        if (this.name == 'gard_year') {
          if (this.inputValue > 2023 || this.value < 1950) {
            return false;
          }
          return true;
        }
        else if (this.name == 'salary') {
          if (this.inputValue < 16242) {
            return false;
          }
          return true;
        }
        return new RegExp(this.regex).test(this.inputValue)
      }
      return true;
    },
  },
}
</script>