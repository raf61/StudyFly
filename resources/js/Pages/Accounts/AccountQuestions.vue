<template>
    <h4 class="text-2xl mb-4 border-b border-b-black pb-2" v-if="questions.length">My questions</h4>
    <h4 class="text-2xl mb-4 border-b pb-2" v-else>No questions available</h4>
    <div class="pb-20">

        <div v-for="question in questions" :key="question.id" class="border-b py-3">
            <div class="flex items-center justify-between gap-5">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <span class="text-[10pt] font-bold">{{ subjects.find(subject => subject.id == question.subject)?.name }}</span>
                            <span class="text-[5pt] px-1">●</span>
                            <span class="text-[10pt] text-gray-700">{{ dateFromNow(question.created_at) }}</span>
                        </div>
                    </div>
                    <a target="_blank" :href="$route('question.show', question.id)" class="break-word text-blue-600 max-w-[10rem]">{{ question.title }}</a>
                </div>
                <button @click="deleteQuestion(question.id)" :href="$route('question.destroy', question.id)" class="bg-red-500 rounded text-white px-3 py-1">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    name:"AccountQuestions",
    layout: Account

}
</script>
<script setup>
import { usePage } from '@inertiajs/vue3';
import Account from './Account.vue'
import dateFromNow from '../../helpers/dateFromNow';
import { router } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'

const questions = usePage().props.questions
const subjects = usePage().props.subjects
const toast = useToast()

const deleteQuestion = (questionId) => {
    router.visit(route('question.destroy', questionId), {
        onSuccess(data){
            if (data.props.flash.info){
                toast.info(data.props.flash.info)
            }
        },
        preserveScroll:true
    })
}

</script>

<style scoped>

</style>