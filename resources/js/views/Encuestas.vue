<!--
Ultima Actualización: 19/01/2020

Tipo de componente: Vista

Ruta:/preguntas-frecuentes-y-encuestas

Descripción:
	Lee las Preguntas Frecuentes de la base de datos y las muestra de 10 en 10, y las encuestas

 -->

<template>
  <div>
    <titulo :msg="page.title" />
    <div class="mt-5 ql-editor" v-html="page.content"></div>
    <div v-if="surveys.length > 0" class="mt-5">
      <b-button
        v-for="survey in surveys"
        :key="survey.id + survey.title"
        :href="`/como-participar/encuestas/${survey.id}`"
        block
        variant="info"
        class="text-uppercase ml-4 btn font-weight-bold btn-lg my-3"
      >{{survey.title}}</b-button>
    </div>
    <div v-else class="mt-5">No hay encuestas disponibles</div>
  </div>
</template>

<script>
import titulo from "../components/Titulo.vue";
import axios from "axios";

export default {
  
  components: {
    titulo
  },
  props: ['surveys', 'page'],
  data() {
    return {
    };
  }
};
</script>
