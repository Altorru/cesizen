<script setup lang="ts">
// Layout minimal pour les pages d'authentification (register, login, forgot-password)
</script>

<template>
  <Suspense>
    <UApp>
      <div class="min-h-screen bg-gradient-to-br from-green-50 via-blue-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <slot />
      </div>
    </UApp>
  </Suspense>
</template>
