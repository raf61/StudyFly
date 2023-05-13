<template>
      <div class="flex justify-center" id="mathInputElement">
        <div class="max-w-2xl">

          <div class="w-full flex justify-center mb-4">
                <img id="rs" ref="img"/>
          </div>
        <input @input="updateFormula" class="block
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
                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="text" id="inp" ref="inp">
        <div id="ins" ref="ins"></div>

        <div class="w-full overflow-x-auto whitespace-nowrap buttons-container p-5 mb-3">
            <div  class="btn inline-block select-none" v-for="(x,index) in stx">
                <img @click="onClickStx($event)" :src="url + x" />
            </div>
        </div>
        <div class="w-full overflow-x-auto whitespace-nowrap buttons-container p-5 mb-3">
            <div class="btn inline-block select-none" v-for="(x,index) in sym" >
                <img @click="onClickSym($event)" :x-sym="x" :src="url + x" />
            </div>
        </div>

        <div class="flex justify-end mt-10">
          <button @click="handleReturn" type="button" class="mr-5 inline-block px-6 py-2.5 bg-gray-800 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-900 hover:shadow-lg focus:bg-gray-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-900 active:shadow-lg transition duration-150 ease-in-out">Insert</button>
          <button @click="handleClose" type="button" class="inline-block px-6 py-2.5 bg-gray-200 text-gray-700 font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-300 hover:shadow-lg focus:bg-gray-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out">Cancel</button>
        </div>


        </div>

    </div>
</template>

<script>
export default {

}
</script>
<script setup>
import {ref, onMounted} from 'vue'
onMounted(() => {
  document.getElementById('mathInputElement').scrollIntoView()
})
const emit = defineEmits(['return','close'])
let ins = ref()
let inp = ref()
const img = ref()
const url = 'https://latex.codecogs.com/gif.latex?';
const handleReturn = () => {
  if (!inp.value.value){
    return
  }
  emit('return', inp.value.value.trim())
  inp.value.value = ''
}
const handleClose = () => {
  emit('close')
}
let stx = [
  'x^{a}', 
  'x_a', 
  '\\frac{a}{b}', 
  '\\sqrt{a}',
  '\\sqrt[b]{a}',
  '\\int_a^b', 
  '\\bigcap_a^b',
  '\\bigcup_a^b',
  '\\sum_a^b',
  '\\prod_a^b',
  '\\coprod_a^b',
  '\\lim_{x\\to a}',
  '\\left(x\\right)', 
  '\\left[x\\right]', 
  '\\left\\{x\\right\\}',
  '\\left|x\\right|', 
  '\\lfloor x\\rfloor', 
  '\\lceil x\\rceil', 
  '\\langle x\\rangle', 
  '\\begin{matrix}a&b\\\\c&d\\end{matrix}', 
  '\\left\\{\\begin{matrix}a\\\\b\\end{matrix}\\right.', 
  '\\left[\\begin{matrix}a\\\\b\\end{matrix}\\right.', 
  '\\xleftarrow[b]{a}',
  '\\xrightarrow[b]{a}', 
  '\\overleftarrow{a}',
  '\\overrightarrow{a}',
  '\\overline{a}',
  '\\mathbb{R}', 
];
/*
var stxWithPos = [
  'x^{a}', 0,
  'x_a', 0,
  '\\frac{a}{b}', 6,
  '\\sqrt{a}', 6,
  '\\sqrt[b]{a}', 6,
  '\\int_a^b', 5,
  '\\bigcap_a^b', 8,
  '\\bigcup_a^b', 8,
  '\\sum_a^b', 5,
  '\\prod_a^b', 6,
  '\\coprod_a^b', 8,
  '\\lim_{x\\to a}', 6,
  '\\left(x\\right)', 6,
  '\\left[x\\right]', 6,
  '\\left\\{x\\right\\}', 6,
  '\\left|x\\right|', 6,
  '\\lfloor x\\rfloor', 8,
  '\\lceil x\\rceil', 7,
  '\\langle x\\rangle', 8,
  '\\begin{matrix}a&b\\\\c&d\\end{matrix}', 14,
  '\\left\\{\\begin{matrix}a\\\\b\\end{matrix}\\right.', 21,
  '\\left[\\begin{matrix}a\\\\b\\end{matrix}\\right.', 20,
  '\\xleftarrow[b]{a}', 12,
  '\\xrightarrow[b]{a}', 13,
  '\\overleftarrow{a}', 12,
  '\\overrightarrow{a}', 13,
  '\\overline{a}', 10,
  '\\mathbb{R}', 8,
];
*/
var sym = [
  '\\pm ', '\\mp ', '\\times ', '\\div ', '\\setminus ', '\\leqslant ', '\\geqslant ', '\\ll ', '\\gg ',
  '\\in ', '\\ni ', '\\notin ', '\\forall ', '\\exists ', '\\varnothing ', '\\varepsilon ', '\\epsilon ', '\\pi ', '\\alpha ', '\\beta ', '\\Gamma ', '\\Delta ',
  '\\leftarrow', '\\rightarrow', '\\Leftarrow', '\\Rightarrow', '\\mapsto',
  '\\leftrightarrow ', '\\Leftrightarrow ', '\\leftrightharpoons ', '\\rightleftharpoons '
];

let onClickStx = function(event){
    const str = decodeURIComponent(event.target.src.split("?")[1]);
    let selectionStart = (inp.value.value.slice(0, inp.value.selectionStart) + str).length;
    inp.value.value = inp.value.value.slice(0, inp.value.selectionStart) + str + inp.value.value.slice(inp.value.selectionEnd);
    inp.value.focus()
    inp.value.setSelectionRange(selectionStart, selectionStart)
    updateFormula()
}
let onClickSym = function(event){
    const str = event.target.getAttribute('x-sym')
    let selectionStart = (inp.value.value.slice(0, inp.value.selectionStart) + str).length;
    inp.value.value = inp.value.value.slice(0, inp.value.selectionStart) + str + inp.value.value.slice(inp.value.selectionEnd);
    inp.value.focus()
    inp.value.setSelectionRange(selectionStart, selectionStart)
    updateFormula()
}

function updateFormula(){
    img.value.src = url + inp.value.value
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