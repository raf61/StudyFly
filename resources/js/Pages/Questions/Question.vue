<template>
    <Head>
        <title>  {{ question.title }}</title>

    </Head>
    <Navbar />
    <main class="w-full flex justify-center mt-10 pb-32">
        <div class="max-w-2xl w-full">
            <div class="p-5 rounded border-2 border-gray-300 w-full">
                <div class="flex items-center">
                    <UserLogo class="w-7 rounded-full" />
                    <div>
                        <div class="ml-2 flex flex-col">
                            <span class="w-full text-[9pt] font-bold">{{ question.username }}</span>
                            <div class="flex items-center">
                                <span class="text-gray-500 text-[8pt] mx-1">{{ dateFromNow(question.created_at)  }}</span>
                                <span class="text-[8pt] text-gray-400">|</span>
                                <span class="text-[8pt] text-gray-500 font-bold mx-1"> {{ subject.name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full mt-3">
                    <div class=" border-black border-b pb-3 mb-3">
                        <h1 class="font-medium text-xl break-word">{{ question.title }}</h1>
                        <div class="attachments flex mb-3" v-if="question.files.length">
                            <transition-group name="bounce">
                                <a :download="attachment.filename" :href="$uploaded(attachment.filepath)" class="table pr-2" v-for="(attachment, index) in question.files" :key="index">
                                    <div class="select-none flex items-center px-3 rounded py-1 bg-gray-200">
                                        <ArrowDownTrayIcon class="w-4"/>
                                        <span class="text-[9pt] pl-2">{{ attachment.filename }}</span>
                                    </div>
                                </a>
                            </transition-group>
                        </div>
                    </div>
                    <Markdown v-if="question.markdownMode" :content="question.body"/>
                    <div class="break-word mb-3" v-html="prepareNonMarkdownContent(question.body)" v-else>
                    </div>
                </div>
            </div>

            <div>
                <div class="pt-5 pb-2">
                    <div class="flex justify-between">
                        <span class="block text-xl">
                            {{ answers.length }}
                             Answer<template v-if="answers.length != 1">s</template>
                        </span>
                        
                    </div>
                </div>
                <div v-if="answers.length">
                    <div v-for="answer in answers" class="border-b-2 p-5">
                        <p v-html="prepareNonMarkdownContent(answer.body)" class="break-words"></p>
                        <div class=" pt-7">
                            <span class="text-gray-500 text-[8pt]">{{ dateFromNow(answer.created_at) }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <UserLogo class="w-6 rounded-full"  />
                            <span class="text-blue-500 text-[9pt]">{{ answer.username }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <form id="answerForm" action="" @submit.prevent="submitAnswer" v-if="postYourAnswerVisible">
                    <h3 class="mt-5 text-xl font-medium mb-4">Your answer</h3>
                        <div class="flex items-center py-2 border border-b-0 px-1">
                            <div class="p-1 rounded hover:bg-slate-500 transition cursor-pointer" @click="visibleMathInput = !visibleMathInput">
                                <CalculatorIcon class="w-5" />
                            </div>
                        </div>
                        <textarea placeholder="Answer Body" minlength="20" required v-model="answerForm.body" ref="bodyElement" maxlength="2750" type="text" class="form-control
                        block
                        w-full
                        px-3
                        py-1.5
                        text-[9pt]
                        font-normal
                        text-gray-700
                        bg-white bg-clip-padding
                        border border-solid border-gray-300
                        rounded-sm
                        min-h-[10rem]
                        transition
                        ease-in-out
                        m-0
                        mb-5
                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        ></textarea>
                        <Transition name="togglefade">
                            <MathInput ref="mathInputEl" @return="insertFormula" @close="visibleMathInput = false" v-if="visibleMathInput" class="p-5 rounded-lg border border-gray-400" />
                        </Transition>                    
                        
                        
                    </form>
                    <div class="flex gap-5">
                        <button type="submit" form="answerForm" @click="handlePostYourAnswerButton($event)"  class="mt-5 bg-blue-600 px-3 py-2 text-[10pt] rounded-sm shadow-lg hover:bg-blue-800 text-white">Post your answer</button>
                        <button @click="postYourAnswerVisible = false" v-if="postYourAnswerVisible" class="mt-5 bg-gray-500 px-3 py-2 text-[10pt] rounded-sm shadow-lg hover:bg-gray-700 text-white">Cancel</button>
                    </div>
                
            </div>


        </div>
    </main>

</template>

<script>
export default {
    name: "Question",
}
</script>

<script setup>
import Navbar from '../../Components/Navbar.vue'
import MathInput from '../../Components/MathInput.vue';
import Markdown from '../../Components/Markdown.vue'
import UserLogo from '../../Components/UserLogo.vue'
import { ref, computed, watch, nextTick } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import escapeHtml from '../../helpers/escapeHtml.js'
import dateFromNow from '../../helpers/dateFromNow.js'
import { ArrowDownTrayIcon, CalculatorIcon, PlusIcon, PaperClipIcon, XMarkIcon } from '@heroicons/vue/20/solid';
import { useToast } from 'vue-toastification';
import { showAuthModal } from '../../helpers/authModal';
import DomPurify from 'dompurify'

defineProps({
    subjects:Object,
    errors:Object,
    question:Object,
    auth:Object
})

const subjects = computed(() => usePage().props.subjects)
const question = computed(() => usePage().props.question)
const answers = computed(() => usePage().props.answers)
const auth = computed(() => usePage().props.auth)

let subject;

const answerForm = useForm({
    body: '',
})
const toast = useToast()
const visibleMathInput = ref(false)
const bodyElement = ref()
const postYourAnswerVisible = ref(answers?.value?.length || !auth?.value?.user ? false : true)



for (let x of subjects.value){
    if (x['id'] == question.value.subject){
        subject = x;
        break
    }
}

const prepareNonMarkdownContent = (body) => {
    const url = 'https://latex.codecogs.com/gif.latex?'
    let content = escapeHtml(body)
    const regex = new RegExp(/(^|[^\\])`.+?`/g)
    let toBeReplaced = (regex.exec(content))
    
    let mathExpression
    while (toBeReplaced){

        mathExpression = toBeReplaced[0].substring(toBeReplaced[0][0] == '`' ? 1 : 2, toBeReplaced[0].length - 1)
        content = content.replace(toBeReplaced[0], `<img src="${url + encodeURIComponent(mathExpression)}" />`)
        toBeReplaced = regex.exec(content)
    }


    content = content.replace(/\n/g,'<br />')
    content = content.replace(/  /g, ' &nbsp;')

    const imageRegex = new RegExp(/(?<alt>!\[[^\]]*\])\((?<filename>.*?)(?=\"|\))\)/g)

    toBeReplaced = imageRegex.exec(content)
    while (toBeReplaced){
        const {groups} = toBeReplaced
        const imageExpression = `<img alt="${(groups.alt)}" src='${(groups.filename)}' />`
        content = content.replace(toBeReplaced[0], imageExpression)

        toBeReplaced = imageRegex.exec(content)
    }
    
    return DomPurify.sanitize(content)
}

const submitAnswer = () => {
    answerForm.post(route('questionAnswer.store', question.value.id),{
        preserveScroll:true,
        onError(errors){
            for (let key in errors){
                toast.error(errors[key])
            }
        },
        onSuccess(){
            answerForm.reset()
            postYourAnswerVisible.value = false
        }
    })
}

const insertFormula = (formula) => {
    formula = '`' + formula + '`'
    const selectionStart = bodyElement.value.selectionStart
    const selectionEnd = bodyElement.value.selectionEnd
    let finalstr = answerForm.body.slice(0, selectionStart) + formula + answerForm.body.slice(selectionEnd)
    answerForm.body = finalstr
    visibleMathInput.value = false;
}


const handlePostYourAnswerButton = async function($event){
    if (!auth?.value?.user){
        showAuthModal()
        return
    }
    if (!postYourAnswerVisible.value){
        $event.preventDefault() // Do not try to submit the form when the input is not visible
        postYourAnswerVisible.value = true
        await nextTick()
        $event.target.scrollIntoView()
        bodyElement.value.focus()
        return
    }
}

watch(auth, async (newAuth) => {
    if (auth.value?.user){ //
        postYourAnswerVisible.value = true
        await nextTick()
        bodyElement?.value?.scrollIntoView()
        bodyElement?.value?.focus()
    }
})


</script>