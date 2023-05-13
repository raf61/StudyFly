<template>
    <Head title="Ask Question" />
    <Navbar />
    <main class="pt-5 flex justify-center h-full pb-28">
        <div class="w-full max-w-2xl">
            <h1 class="text-2xl mt-6 mb-5">Ask a public question</h1>

            <form enctype="multipart/form-data" @submit.prevent="submit" action="">
            <div class="p-3 pb-4 border rounded-sm shadow-md">
                    <div class="mb-9">
                        <h3 class="">Title</h3>
                        <span class="text-[9pt] font-thin">Be specific and imagine you`re asking a question to another person</span>
                        <div>
                            <span v-if="errors.title" class="text-red-500 text-sm">{{ errors.title }}</span>
                        </div>
                        <input v-model="form.title" required maxlength="70" minlength="10" type="text" placeholder="e.g. How many stars are there in Solar System ?" class="form-control
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
                        transition
                        ease-in-out
                        m-0
                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        >
                    </div>
                    <div class="mb-3">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="">Body</h3>
                                <span class="text-[9pt] font-thin">Include all the information someone would need to answer your question</span>
                                <div>
                                    <span v-if="errors.body" class="text-red-500 text-[8pt]">{{ errors.body }}</span>
                                </div>
                            </div>
                            <div class="">
                                <label
                                for="toogle"
                                class="flex items-center justify-center cursor-pointer"
                                >
                                <div class="relative">
                                    <input @click="changeBodyMode($event)" id="toogle" type="checkbox" :checked="form.markdownMode" class="sr-only" />
                                    <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
                                    <div class="dot absolute w-6 h-6 bg-red-500 rounded-full shadow -left-1 -top-1 transition"></div>
                                </div>
                            </label>
                            <abbr class="no-underline cursor-pointer" title="Markdown is a lightweight markup language that you can use to add formatting elements to plaintext documents.">
                                <span class="text-[8pt]">Markdown mode</span>
                            </abbr>

                            </div>
                        </div>
                        <textarea required ref="bodyElement" maxlength="4096" v-model="form.body" type="text" class="form-control
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
                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        ></textarea>
                    </div>
                   

                    <div class="attachments flex">
                        <transition-group name="bounce">
                            <div class="table pr-2" v-for="(attachment, index) in form.attachments" :key="index">
                                    <div class="select-none flex items-center px-3 rounded py-1 bg-gray-200" :class="{'bg-red-500':invalidFiles[attachment.name]}">
                                        <span class="text-[9pt]">{{ attachment.name }}</span>
                                        <XMarkIcon @click="removeAttachment(index)" class="w-5 cursor-pointer"/>
                                    </div> 
                            </div>
                        </transition-group>
                    </div>

                    

                    <Transition name="togglefade">
                        <MathInput ref="mathInputEl" @return="insertFormula" @close="visibleMathInput = false" v-if="visibleMathInput" class="p-5 rounded-lg border border-gray-400" />
                    </Transition>
                    <Transition name="togglefade">
                        <ImageUpload @return="insertUploadedImage" ref="imageUploadEl" @close="visibleImageUpload = false" v-if="visibleImageUpload" class="p-5 rounded-lg border border-gray-400" />
                    </Transition>

                    <div class="my-3 flex items-center">
                        <div class="table p-1 rounded-lg hover:bg-gray-500 hover:text-white transition duration-300">
                            <label for="attachment" class="cursor-pointer">
                                <abbr title="Attach files to your question (limit 3)">
                                    <PaperClipIcon class="w-5" />
                                </abbr>
                            </label>
                            <input multiple ref="attachmentsInput" @input="handleFileAdd($event)" accept=".jpg, .png, .jpeg, .txt, .pptx, .docx, .pdf, .xlsx, .xls, .gif, .doc|image/*" type="file" id="attachment" class="hidden">
                        </div>
                        <div class="table ml-3 p-1 rounded-lg hover:bg-gray-500 hover:text-white transition duration-300" @click="visibleImageUpload = true">
                                <abbr title="Insert an image" class="cursor-pointer">
                                    <PhotoIcon class="w-5" />
                                </abbr>
                        </div>
                        <div class="table ml-3 p-1 rounded-lg hover:bg-gray-500 hover:text-white transition duration-300" @click="handleEquationButton">
                            <abbr title="Equation" class="cursor-pointer">
                                <CalculatorIcon class="w-5" />
                            </abbr>
                        </div>
                    </div>
                    <div class="my-10">
                        <Markdown v-if="form.markdownMode" :content="form.body" />
                    </div>

                    <div class="">
                        <h3>Subject</h3>
                        <span class="text-[9pt] font-thin">Select the subject your question is about</span>
                        <div>
                            <span v-if="errors.subject" class="text-red-500 text-[9pt]">{{ errors.subject }}</span>
                        </div>
                        <div>
                            <span class="relative w-auto">
                                <select v-model="form.subject" name="subject" class="appearance-none pl-5 p-2 text-sm min-w-[14rem] outline-none rounded-full drop-shadow-md focus:ring-0 cursor-pointer" aria-label="Default select example" required>
                                        <option v-for="(subject, index) in subjects" :value="subject.id">
                                            {{ subject.name }}
                                        </option>
                                </select>
                                <ChevronDownIcon class="w-5 absolute icon-select"/>
                            </span>
                        </div>
                    </div>
                </div>
                <button :disabled="form.processing" class="mt-3 bg-blue-600 px-3 py-2 text-[10pt] rounded-sm shadow-lg hover:bg-blue-800 text-white">Post your question</button>
            </form>
        </div>
    </main>
</template>

<script>
export default {
    name: "Ask",
    components: { ImageUpload }
}
</script>

<script setup>
import Markdown from '../../Components/Markdown.vue';
import Navbar from '../../Components/Navbar.vue';
import ImageUpload from '../../Components/ImageUpload.vue'
import MathInput from '../../Components/MathInput.vue';
import { ChevronDownIcon, PaperClipIcon, XMarkIcon, CalculatorIcon, PhotoIcon } from '@heroicons/vue/20/solid';
import { useToast } from 'vue-toastification';
import { useForm, usePage } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

const attachmentsInput = ref()
const {errors} = defineProps({
    errors:Object
})
const visibleMathInput = ref(false)
const visibleImageUpload = ref(false)
const toast = useToast()
const subjects = usePage().props.subjects
const invalidFiles = reactive({})
const bodyElement = ref()
const mathInputEl = ref()

const form = useForm({
    title:'',
    body:'',
    attachments:[],
    subject:subjects[0]['id'],
    markdownMode:false
})

const handleEquationButton = () => {
    visibleMathInput.value = !visibleMathInput.value
}



const handleFileAdd = (event) => {
    if (form.attachments.length >= 3 || event.target.files.length +form.attachments.length > 3 ){
        toast.error('You can`t upload more than 3 files.')
        return
    }
    const dt = new DataTransfer()
    const { files:attachments } = event.target
    
    for (let i = 0; i < attachments.length; i++) {
        const file = attachments[i]
        dt.items.add(file)
    }

    for (let i = 0; i < form.attachments.length; i++) {
        const file = form.attachments[i]
        dt.items.add(file)
    }
    
    form.attachments = dt.files 
    attachmentsInput.value.type = ''
    attachmentsInput.value.type = 'file'
}

const removeAttachment = (index) => {
    const dt = new DataTransfer()
    const { attachments } = form
    
    for (let i = 0; i < attachments.length; i++) {
        const file = attachments[i]
        if (index !== i)
            dt.items.add(file) 
        else
            Reflect.deleteProperty(invalidFiles, file.name)
    }
  form.attachments = dt.files 
}

const changeBodyMode = () => {
    form.markdownMode = !form.markdownMode
}

const insertFormula = (formula) => {
    formula = '`' + formula + '`'
    const selectionStart = bodyElement.value.selectionStart
    const selectionEnd = bodyElement.value.selectionEnd
    let finalstr = form.body.slice(0, selectionStart) + formula + form.body.slice(selectionEnd)
    form.body = finalstr
    visibleMathInput.value = false;
}

const insertUploadedImage = async (imageUrl) => {

    const descriptionPlaceholder = 'enter image description here'
    const imageExpression = `![${descriptionPlaceholder}](${imageUrl})`
    const selectionStart = bodyElement.value.selectionStart
    const selectionEnd = bodyElement.value.selectionEnd
    let finalstr = form.body.slice(0, selectionStart) + imageExpression + form.body.slice(selectionEnd)
    form.body = finalstr
    bodyElement.value.focus()
    setTimeout(function(){
        bodyElement.value.setSelectionRange(selectionStart+2, selectionStart + descriptionPlaceholder.length + 2)
    }, 0)
}

const submit = () => {
    form.post(route('question.store'), {
        onError(errors){
            for (let i=0;i<form.attachments.length;i++){
                if (errors['attachments.'+i]){
                    invalidFiles[form.attachments[i].name] = true
                    let newmessage = errors['attachments.'+i].replace('attachments.'+i, `"${form.attachments[i].name}" file`)
                    toast.error(newmessage, {
                        timeout:4000,
                    })
                }
            }
        }
    });
}

</script>

<style scoped>
.icon-select{
    bottom:0;
    right:1rem;
}
input:checked ~ .dot {
  transform: translateX(100%);
  background-color: #48bb78;
}

</style>