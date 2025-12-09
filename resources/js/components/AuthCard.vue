<script setup lang="ts">
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Link } from '@inertiajs/vue3'

interface Props {
  title: string
  description?: string
}

defineProps<Props>()
</script>

<template>
  <div class="flex min-h-screen items-center justify-center p-4">
    <div class="w-full max-w-md space-y-8">
      <!-- Logo avec animation douce -->
      <Link href="/" class="flex flex-col items-center gap-3 group">
        <div class="relative">
          <!-- Cercle de fond avec animation -->
          <div class="absolute inset-0 bg-gradient-to-br from-green-400/20 to-blue-400/20 rounded-full blur-xl group-hover:blur-2xl transition-all duration-300"></div>
          
          <!-- Icône cœur -->
          <div class="relative bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-lg group-hover:shadow-xl transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 dark:text-green-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
            </svg>
          </div>
        </div>
        
        <span class="text-3xl font-bold bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400 bg-clip-text text-transparent group-hover:scale-105 transition-transform duration-300">
          CESIZen
        </span>
        <p class="text-sm text-muted-foreground">Your mental wellness companion</p>
      </Link>

      <!-- Auth Card avec ombres douces -->
      <Card class="border-0 shadow-2xl shadow-green-500/10 dark:shadow-green-500/5">
        <CardHeader class="space-y-2 text-center pb-6">
          <CardTitle class="text-2xl font-bold tracking-tight">{{ title }}</CardTitle>
          <CardDescription v-if="description" class="text-base">{{ description }}</CardDescription>
        </CardHeader>
        <CardContent class="pt-0">
          <slot />
        </CardContent>
      </Card>

      <!-- Footer apaisant -->
      <p class="text-center text-xs text-muted-foreground">
        Protected by privacy. Secured with care.
      </p>
    </div>
  </div>
</template>
