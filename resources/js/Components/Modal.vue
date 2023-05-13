<template>
    <div class="modal-backdrop">
        <div class="modal">
            <div @click="close" class="close-modal">&times;</div>
            <slot></slot>
        </div><!--modal-->
    </div><!--modal-backdrop-->
</template>

<script>
export default {
    name:'Modal',
    data(){
        return{

        }
    },
    methods:{
        close(){
            this.$emit('close')
        }
    }
}
</script>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index:50;
  }

  .modal {
    background: #FFFFFF;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
    padding:30px;
    position:relative;
  }
  .close-modal{
      background-color:black;
      color:white;
      position:absolute;
      top:0;
      right:0;
      width:30px;
      height:30px;
      font-size:17pt;
      display:flex;
      align-items:center;
      justify-content: center;
      border-bottom-left-radius: 4px;
      cursor:pointer;
      transition:.5s;
  }
  .close-modal:hover{
      background-color:grey;
  }
  
</style>