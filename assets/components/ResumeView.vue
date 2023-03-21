<!-- вывод резюме -->
<template>
    <h3>Мое офигенное резюме(наверное)</h3>
    <div class="py-lg-2">
        <img v-if="resume.photo" width="200" :src="resume.photo">
    </div>
    <div class="words">
        <h3 v-if="resume.FIO">{{ resume.FIO }}</h3>
        <h5 v-if="resume.age">Возраст: {{ resume.age }}</h5>

        <h3 v-if="resume.city || resume.BD || resume.about">О себе</h3>
        <div>
            <p v-if="resume.BD">Дата рождения: {{ resume.BD }}</p>
            <p v-if="resume.city">Город: {{ resume.city }}</p>
            <p v-if="resume.about">О себе: {{ resume.about }}</p>
        </div>

        <h3>Образование</h3>
        <div v-for="education in resume.educations" :key="education.id">
            <div v-if="education.level">
                <div>
                    <p>Уровень: {{ education.level }}</p>

                    <div v-if="education.level !== 'Среднее'">
                        <p v-if="education.institution">Учебное заведение: {{ education.institution }}</p>
                        <p v-if="education.faculty">Факультет: {{ education.faculty }}</p>
                        <p v-if="education.specialization">Специализация: {{ education.specialization }}</p>
                        <p v-if="education.gard_year">Год окончания: {{ education.gard_year }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <p v-if="resume.profession">Профессия: {{ resume.profession }}</p>
            <p v-if="resume.salary > 0">Желаемая заработная плата: {{ resume.salary }} ₽</p>

            <p v-if="resume.skills">Ключевые навыки: {{ resume.skills }}</p>
        </div>

        <h3 v-if="resume.phone || resume.email">Контакты</h3>
        <div>
            <p v-if="resume.phone">Телефон: {{ resume.phone }}</p>
            <p v-if="resume.email">Email: {{ resume.email }}</p>
        </div>
    </div>
</template>
  
<script>
export default {
    name: "ResumeView",
    props: {
        resume: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            educationTypes: ['Среднее',
                'Среднее специальное',
                'Неоконченное высшее',
                'Высшее',],
        }
    },
}
</script>
<style>
.words{
    word-break: break-all;
}
</style>