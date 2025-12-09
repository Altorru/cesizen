<script setup lang="ts">
// Layout minimal pour les pages d'authentification avec un fond apaisant
</script>

<template>
  <Suspense>
    <UApp>
      <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950">
        <!-- Pattern subtil pour plus de douceur -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(16,185,129,0.05),transparent_50%)]" />
        <div class="relative">
          <slot />
        </div>
      </div>
    </UApp>
  </Suspense>
</template>
