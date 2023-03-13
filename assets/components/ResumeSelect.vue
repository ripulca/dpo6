<template>
    <div class="px-1 pt-2">
        <label class="form-label">{{ label }}</label>
        <select class="input-group" v-model="inputValue">
            <option v-for="(value, option) in options" :key="value" :value="value">{{ value }}</option>
        </select>
    </div>
</template>
  
<script>
export default {
    name: "ResumeSelect",
    props: {
        modelValue: {
            required: true,
        },
        label: {
            type: String,
            required: true
        },
        name: {
            type: String,
            required: true
        },
        options: {
            type: Object,
            required: true
        },
    },
    emits: ["updated"],
    computed: {
        inputValue: {
            get() {
                return this.modelValue;
            },
            set(newValue) {
                this.$emit('updated', this.name, newValue);
            }
        }
    },
}
</script>