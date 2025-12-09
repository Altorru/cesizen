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
          <div class="absolute inset-0 bg-gradient-to-br from-green-400/20 to-yellow-300/20 rounded-full blur-xl group-hover:blur-2xl transition-all duration-300"></div>
          
          <!-- Logo image ou icône -->
          <div class="relative bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-lg group-hover:shadow-xl transition-all duration-300">
            <img src="/images/logo.png" alt="CESIZen Logo" class="h-10 w-10 object-contain" />
          </div>
        </div>
        
        <span class="text-3xl font-bold bg-gradient-to-r from-green-500 to-yellow-400 dark:from-green-400 dark:to-yellow-300 bg-clip-text text-transparent group-hover:scale-105 transition-transform duration-300">
          CESIZen
        </span>
        <p class="text-sm text-muted-foreground">Votre compagnon de bien-être mental</p>
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
        Protégé par la confidentialité. Sécurisé avec soin.
      </p>
    </div>
  </div>
</template>
