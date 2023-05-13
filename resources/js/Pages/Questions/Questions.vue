<template>
    <Head title="Questions" />
    <Navbar />
  <main class="w-full flex justify-center pb-20">
    <div class="w-full max-w-4xl">
        <div class="w-full p-7 flex justify-center">
            <div class="p-5 w-[20%]">
                <h3 class="p-3 border-b-2">Subjects</h3>
                <ul class="mt-3">
                    <li>
                        <Link :href="currentPathName + questionSearchFilters.removeFilter('subject')" class="flex items-center hover:bg-gray-100 py-2 cursor-pointer rounded pl-2">
                            <Squares2X2Icon class="w-6" />
                            <span class="ml-2 text-[10pt]">All subjects</span>
                        </Link>
                    </li>
                    <li v-for="subject in subjects">
                        <Link :href="questionSearchFilters.applyFilter('subject', subject.slug)" class="flex items-center hover:bg-gray-100 py-2 cursor-pointer rounded pl-2">
                            <component :is="icons[subject.slug] || icons['default']" class="w-6" />
                            <span class="ml-2 text-[10pt]">{{ subject.name }}</span>
                        </Link>
                    </li>
                    
                </ul>
            </div>
            <div class="w-[70%]">
                <div class="pb-3">
                    <div class="flex justify-between">
                        <h1 class="text-2xl">Questions</h1>
                        <Link :href="$route('question.indexAsk')" class="bg-blue-500 hover:bg-blue-600 focus:outline-none text-white px-3 py-2 rounded-sm text-[8pt]">
                            Ask question
                        </Link>
                    </div>
                    <div class="flex justify-end mt-5">
                        <button @click="showFilters = !showFilters" class="flex items-center px-2 py-2 rounded-sm border border-blue-800 bg-blue-100">
                            <AdjustmentsHorizontalIcon class="w-4" />
                            <span class="text-blue-800 pl-2 text-[9pt]">Filter</span>
                        </button>
                    </div>
                    <Transition name="slideY-fade">
                        <div class="bg-gray-200 border border-gray-400 mt-3 p-4" v-if="showFilters">
                            <div class="flex" >
                                <div>
                                    <h3 class="font-bold">Filter by</h3>
                                    <div class="flex items-center">
                                        <input v-model="noAnswersCheckInput" :checked="questionsSearchOptions.noAnswers" class="form-check-input" type="checkbox" id="no-answers">
                                        <label class="pl-2 text-sm font-thin" for="no-answers">No answers</label>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button @click="handleApplyFilterButton" class="bg-blue-500 hover:bg-blue-600 focus:outline-none text-white px-3 py-2 rounded-sm text-[8pt]">Apply</button>
                            </div>
                        </div>
                    </Transition>
                    <div>
                        <div v-for="question in questions.data" :key="question.id" class="border-b py-3">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="pr-3">
                                        <UserLogo class="w-7 rounded-full"/>
                                    </div>
                                    <span class="text-[10pt] font-bold">{{ subjects.find(subject => subject.id == question.subject)?.name }}</span>
                                    <span class="text-[5pt] px-1">●</span>
                                    <span class="text-[10pt] text-gray-700">{{ dateFromNow(question.created_at) }}</span>
                                </div>
                            </div>
                            <Link :href="$route('question.show', question.id)" class="break-words text-blue-600">{{ question.title }}</Link>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center mt-3" v-if="questions.data.length">
                    <div class="flex items-center gap-1">
                        <div v-for="link in questions.links" >
                            <Link v-if="link.url" :href="link.url" v-html="link.label" :class="{'bg-blue-500':link.active, 'text-white':link.active}" class="px-[10px] py-[5px] border border-gray-400 hover:bg-slate-300 rounded"></Link>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <p class="text-3xl text-center">No results available</p>
                </div>
            </div>
        </div>
        
    </div>
  </main>
</template>

<script>
export default {
    name: "Questions",
}
</script>

<script setup>
import { 
AdjustmentsHorizontalIcon, 
Squares2X2Icon,
CalculatorIcon,
BookOpenIcon 
} from '@heroicons/vue/20/solid';
import Navbar from '../../Components/Navbar.vue'
import UserLogo from '../../Components/UserLogo.vue';
import { computed, ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import dateFromNow from '../../helpers/dateFromNow'
import questionSearchFilters from '../../helpers/questionSearchFilters';


const loadQuestionsSearchOptions = () => {
    const parsed = new URLSearchParams(location.search)
    const result = {
        noAnswers: !!(parsed.get('noAnswers') == '1')
    }
    return result
}

const questionsSearchOptions = loadQuestionsSearchOptions()
const subjects = computed(() =>  usePage().props.subjects)
const questions = computed(() => usePage().props.questions)
const showFilters = ref(true)
const noAnswersCheckInput = ref(questionsSearchOptions.noAnswers)
const currentPathName = location.pathname

const icons = ({
    'default' : BookOpenIcon,
    'matematica' : CalculatorIcon
})


const handleApplyFilterButton = () => {
    const parsedParams = new URLSearchParams(location.search)
    parsedParams.delete('noAnswers')
    if (noAnswersCheckInput.value){
        parsedParams.append('noAnswers','1')
    }
    router.visit(`?${parsedParams.toString()}`)
}

</script>

<style scoped>

</style>