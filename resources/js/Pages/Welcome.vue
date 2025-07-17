<template>
  <Head title="Bienvenido" />

  <div
    class="min-h-screen bg-cover bg-center flex items-center justify-center"
    style="background-image: url('/images/fondo.jpg')"
  >
    <div class="bg-black bg-opacity-60 p-8 rounded-xl text-white text-center max-w-xl">
      <h1 class="text-4xl font-bold mb-4">¡Bienvenido al Sistema!</h1>
      <p class="text-lg mb-6">
        Este es tu portal para acceder a todas las funcionalidades del sistema. Por favor, inicia sesión para continuar.
      </p>

      <div v-if="$page.props.auth.user">
        <Link
          :href="route('visits.index')"
          class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded"
        >
          Ir al Panel
        </Link>
      </div>

      <div v-else>
        <Link
          :href="route('login')"
          class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
        >
          Iniciar Sesión
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
</script>
