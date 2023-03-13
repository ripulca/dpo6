<template>
    <router-link class="nav" :to="{ name: 'home' }">Главная</router-link>
    <div class="container">
        <div class="apple">
            <!-- форма резюме -->
            <div id="resume" class="half_life px-2 py-lg-5">
                <ResumeSelect label="Статус" name="status" :options="statuses" @updated="setValue" :modelValue="resume.status" />

                <ResumeInput label="Ссылка на фото" name="photo" type="text" @updated="setValue" v-model="resume.photo" />

                <ResumeInput label="ФИО" name="FIO" type="text" @updated="setValue" regex="[А-ЯA-Zа-яa-z]{3,100}"
                    error_message="неверный формат имени, допускаются только русские и английские буквы"
                    v-model="resume.FIO" />

                <ResumeInput label="Дата рождения" name="BD" type="date" @updated="setValue" v-model="resume.BD"
                    error_message="Неправдоподобная дата рождения! Вернитесь в свой гроб или садик, либо прекратите паясничать." />
                <ResumeInputCity name="city" :vkData="vkData" @updated="setValue" :modelValue="resume.city" />
                <ResumeInput label="О себе" name="about" type="text" @updated="setValue" v-model="resume.about" />

                <ResumeInput label="Профессия" name="profession" type="text" @updated="setValue"
                    v-model="resume.profession" />
                <ResumeInput label="Желаемая зарплата" name="salary" type="number" @updated="setValue"
                    error_message="зарпоата ниже мрот" v-model="resume.salary" />
                <ResumeInput label="Ключевые навыки" name="skills" type="text" @updated="setValue"
                    v-model="resume.skills" />

                <ResumeEducationList :vkData="vkData" v-model="resume.educations" @updated="(value) => setValue('educations', value)" />

                <ResumeInput label="Телефон" name="phone" type="text" @updated="setValue" regex="^[0-9]{6,11}$"
                    error_message="неверный формат телефона, допускается 6-10 чисел, без служебных символов"
                    v-model="resume.phone" />
                <ResumeInput label="Email" name="email" type="text" @updated="setValue"
                    regex="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]+$"
                    error_message="неверный формат email, допускаются только английские буквы" v-model="resume.email" />
            </div>
            <!-- вывод резюме -->
            <div class="half_life px-4 pt-5 text-bg-dark">
                <ResumeView :resume="resume" />
            </div>
        </div>
        <div v-if="savingError.length != 0">
            <p>{{ savingError }}</p>
        </div>
        <button @click="saveResume">Сохранить</button>
    </div>
</template>
  
<script>
import ResumeInput from "./ResumeInput.vue";
import ResumeInputCity from "./ResumeInputCity.vue"
import ResumeEducationList from "./ResumeEducationList.vue";
import ResumeView from "./ResumeView.vue";
import ResumeSelect from "./ResumeSelect.vue";
import { api } from "../api";
export default {
    name: 'ResumeResult',
    components: { ResumeSelect, ResumeInput, ResumeInputCity, ResumeEducationList, ResumeView },
    created() {
        console.log(this.$route);
        if (this.$route.params.id) {
            const id = parseInt(this.$route.params.id);
            api.getById(id).then((response) => {
                if (response.status === 200) {
                    this.resume = response.data;
                    // this.vkData.selectedCity=this.resume.city;
                    // console.log(this.data)
                    // console.log(this.resume)
                } else {
                    console.log(response);
                }
            });
        }
    },
    data() {
        return {
            statuses: [
                'Новый',
                'Назначено собеседование',
                'Принят',
                'Отказ'
            ],
            // Данные для резюме
            resume: {
                status: '',
                profession: '',
                city: '',
                photo: '',
                FIO: '',
                phone: '',
                email: '',
                BD: '',
                age: '',
                educations: [],
                salary: '',
                skills: '',
                about: '',
            },
            vkData: {
                russiaId: undefined,
                cities: [],
                universities: [],
                selectedCity: undefined
            },
            savingError: [],
            default: '',
        };
    },
    methods: {
        setValue(field, value) {
            if (field == 'BD') {
                this.resume['age'] = new Date().getFullYear() - new Date(value).getFullYear();
            }
            this.resume[field] = value;
        },
        resetFormValue(field) {
            this.setValue(field, '');
        },
        saveResume() {
            let probabre_errors = document.getElementsByClassName('error_message');
            if(!this.resume.educations){
                return;
            }
            if (probabre_errors.length != 0) {
                return;
            }
            if (this.$route.name === "add") {
                api.add(this.resume).then((response) => {
                    if (response.status === 200) {
                        return;
                    } else {
                        this.savingError = response.data.error;
                        console.log(response);
                        return;
                    }
                });
            } else if (this.$route.name === "edit") {
                api.edit(parseInt(this.$route.params.id), this.resume).then((response) => {
                    if (response.status === 200) {
                        return;
                    } else {
                        this.savingError = response.data.error;
                        console.log(response);
                        return;
                    }
                });
            }

        },
    }
}
</script>
<style>
.apple {
    display: flex;
}

.half_life {
    width: 50%;
}</style>