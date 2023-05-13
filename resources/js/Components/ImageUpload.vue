<template>
  <div>
      <div class="flex justify-center" id="imageUploadElement">
        
        <div class="max-w-2xl p-3">
          <div class="flex justify-center items-center pb-5">
            <img :src="imageUrl" v-show="imageUrlIsValid" @error="imageUrlIsValid = false" @load="imageUrlIsValid = true" class="max-w-[10rem]" />
          </div>
          <input ref="imageInput" @input="handleImageUploadButton($event)" accept=".jpg, .png, .jpeg, .gif|image/*" type="file" id="imageInput" class="hidden">
          <p class="text-center" v-if="!insertingLink">
            <label for="imageInput" class="text-blue-600 cursor-pointer">Browse</label> or <span @click="insertingLink = true; imageUrl = ''" class="text-blue-600 cursor-pointer">paste an image link</span>
            (max 2MB)
          </p>
          <div class="flex items-center" v-else>
            <input v-model="imageUrl" placeholder="https://abcdfgxyz.zhd/my.jpg" class="block
                          w-full
                          px-3
                          py-1.5
                          text-[11pt]
                          font-normal
                          text-gray-700
                          bg-white bg-clip-padding
                          border border-solid border-gray-300
                          rounded-sm
                          transition
                          ease-in-out
                          m-0
            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="text">
            <button @click="insertingLink = false; imageUrl = ''" type="button" class="px-3 text-red-600">Cancel</button>
          </div>

          
        


        </div>

      </div>
      <div class="flex justify-start border-t pt-3 mt-5 gap-2" v-if="!currentlyUploading">
            <button @click="handleClose" type="button" class="inline-block px-6 py-2.5 bg-gray-200 text-gray-700 font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-300 hover:shadow-lg focus:bg-gray-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out">Cancel</button>
            <button @click="handleReturn" type="button" :disabled="!imageUrl || !imageUrlIsValid" class="disabled:opacity-40 mr-5 inline-block px-6 py-2.5 bg-gray-800 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-900 hover:shadow-lg focus:bg-gray-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-900 active:shadow-lg transition duration-150 ease-in-out">Add</button>
      </div>
      <div class="justify-center flex" v-else>
        <Loader />
      </div>
    </div>
    
</template>

<script>
export default {

}
</script>
<script setup>
import {ref, onMounted} from 'vue'
import { useToast } from 'vue-toastification';
import Loader from './Loader.vue'
import { AxiosError } from 'axios';
onMounted(() => {
  document.getElementById('imageUploadElement').scrollIntoView()
})
const toast = useToast()
const emit = defineEmits(['close','return'])
const insertingLink = ref(false)
const imageUrl = ref("")
const imageUrlIsValid = ref(false)
const imageInput = ref()
const currentlyUploading = ref(false)
let imageFile

const handleClose = () => {
  emit('close')
}

const handleReturn = async () => {
  if (insertingLink.value){
    emit('return', imageUrl.value)
    imageUrl.value = ''
    insertingLink.value = false
    emit('close')
    return
  }
  try{
    currentlyUploading.value = true
    imageUrl.value = await uploadImage(imageFile)
    currentlyUploading.value = false
    emit('return', imageUrl.value)
    emit('close')
  }
  catch(E){
    currentlyUploading.value = false
    toast.error(E.message)
  }
}


const handleImageUploadButton = async (event) => {
    if (!event.target.files.length)
        return
    const [image] = event.target.files
    imageFile = image

    const src = URL.createObjectURL(imageFile)
    imageUrl.value = src
    imageInput.value.type = 'text'
    imageInput.value.type = 'file'
}

const uploadImage = async (image) => {
  try{
    const formData = new FormData()
      formData.append("image", image)  
      const {data:{url, ok}} = await axios.post("/upload/image", formData,{
          headers:{
              "Content-Type":"multipart/form-data"
          }
      })
      if (!ok)
          throw new Error("Error while uploading image")
      
      return url
  }
  catch (E){
    if (E instanceof AxiosError){
      if (E.response.status == 413){
        throw new Error("File too large!")
      }
    }
    throw new Error("An error ocurred while uploading the image")
  }

}

</script>
<style scoped>
.btn {
  padding:0 .5rem;
  max-width: 60px;
  border: 0;
  transition: all .3s ease-in-out;
  vertical-align:middle;
}
.btn img {
    width:100%;
    max-height:54px;
    cursor:pointer;
}

.buttons-container::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;

}

.buttons-container::-webkit-scrollbar
{
	width: 6px;
	background-color: #F5F5F5;
}

.buttons-container::-webkit-scrollbar-thumb
{
	background-color: #000000;


}


</style>