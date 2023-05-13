<template>
  <AuthModal @loginSuccess="hideAuthModal()" v-if="getAuthModalStatus()" @close="hideAuthModal()" />
  <slot></slot>
</template>

<script>
export default {
    name:'App'
}
</script>

<script setup>

import { hideAuthModal, getAuthModalStatus } from '../helpers/authModal';
import AuthModal from "../Components/AuthModal.vue";




</script>

<style>

</style>