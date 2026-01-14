<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/layouts/Authenticated.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'

defineOptions({ layout: Layout })

const page = usePage()
const user = computed(() => page.props.auth.user)

const quickLinks = [
  {
    title: 'Parcourir les Articles',
    description: 'Lire nos articles sur la santé mentale',
    icon: 'i-lucide-book-open',
    href: '/articles',
    color: 'text-green-500 dark:text-green-400',
  },
  {
    title: 'Exercice de Respiration',
    description: 'Pratiquer la respiration en pleine conscience',
    icon: 'i-lucide-wind',
    href: '/activities/breathing',
    color: 'text-blue-600 dark:text-blue-400',
  },
  {
    title: 'Suivi des Émotions',
    description: 'Suivez votre bien-être émotionnel',
    icon: 'i-lucide-heart-pulse',
    href: '/activities/emotions',
    color: 'text-purple-600 dark:text-purple-400',
    badge: 'Bientôt',
  },
]
</script>

<template>
  <Head title="Tableau de bord - CESIZen" />

  <div class="p-6 space-y-8 max-w-7xl mx-auto">
    <!-- Welcome Section -->
    <div>
      <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
        Bon retour, {{ user.name }} !
      </h1>
      <p class="text-gray-600 dark:text-gray-400">
        Gérez votre parcours de bien-être depuis ici
      </p>
    </div>

    <!-- Account Info Card -->
    <Card>
      <CardHeader>
        <CardTitle>Votre Compte</CardTitle>
        <CardDescription>Informations personnelles et détails du compte</CardDescription>
      </CardHeader>
      <CardContent class="grid md:grid-cols-3 gap-6">
        <div>
          <p class="text-sm text-muted-foreground mb-1">Nom</p>
          <p class="font-medium text-lg">{{ user.name }}</p>
        </div>
        <div>
          <p class="text-sm text-muted-foreground mb-1">E-mail</p>
          <p class="font-medium text-lg">{{ user.email }}</p>
        </div>
        <div>
          <p class="text-sm text-muted-foreground mb-1">Type de Compte</p>
          <p class="font-medium text-lg">Utilisateur Standard</p>
        </div>
      </CardContent>
    </Card>

    <!-- Quick Activities -->
    <div>
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
        Vos Activités
      </h2>
      <div class="grid gap-4 md:grid-cols-3">
        <Link
          v-for="link in quickLinks"
          :key="link.href"
          :href="link.href"
          class="group"
        >
          <Card class="hover:shadow-lg transition-shadow cursor-pointer h-full relative overflow-hidden">
            <CardHeader>
                <div class="flex items-start gap-4">
                  <div class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800">
                    <UIcon :name="link.icon" :class="['h-6 w-6', link.color]" />
                  </div>
                  <div class="flex-1">
                    <div class="flex items-center gap-2">
                      <CardTitle class="text-lg group-hover:text-green-500 dark:group-hover:text-green-400 transition-colors">
                        {{ link.title }}
                      </CardTitle>
                      <span v-if="link.badge" class="px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300 rounded-full">
                        {{ link.badge }}
                      </span>
                    </div>
                  <CardDescription class="mt-1">
                    {{ link.description }}
                  </CardDescription>
                </div>
              </div>
            </CardHeader>
          </Card>
        </Link>
      </div>
    </div>
  </div>
</template>
