<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import GuestLayout from '@/layouts/Guest.vue'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'

defineOptions({ layout: GuestLayout })

const page = usePage()
const user = computed(() => page.props.auth?.user)
const isAdmin = computed(() => user.value?.role === 'admin')


const features = [
  {
    emoji: '🧘',
    title: 'Exercices de Respiration',
    description: 'Exercices de respiration guidés pour vous aider à vous détendre et réduire le stress grâce à des techniques éprouvées.',
  },
  {
    emoji: '📊',
    title: 'Suivi des Émotions',
    description: 'Suivez vos émotions et identifiez les tendances pour mieux comprendre votre état mental.',
  },
  {
    emoji: '📚',
    title: 'Contenu Éducatif',
    description: 'Accédez à une mine d\'articles et de ressources sur la santé mentale et la gestion du stress.',
  },
  {
    emoji: '🎯',
    title: 'Tableau de Bord Personnel',
    description: 'Suivez vos progrès et visualisez votre parcours vers un meilleur bien-être mental.',
  },
  {
    emoji: '🔒',
    title: 'Privé et Sécurisé',
    description: 'Vos données sont cryptées et protégées. Nous respectons votre vie privée et votre confidentialité.',
  },
  {
    emoji: '📱',
    title: 'Toujours Disponible',
    description: 'Accédez à vos outils de bien-être à tout moment, n\'importe où, sur n\'importe quel appareil.',
  },
]
</script>

<template>
  <Head title="CESIZen - Votre Compagnon de Bien-Être Mental" />

  <!-- Hero Section -->
  <section class="container mx-auto px-6 py-20 md:py-28">
    <div class="text-center max-w-4xl mx-auto">
      <div class="inline-block mb-6">
        <span class="px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full text-sm font-medium">
          🌟 Votre Voyage vers le Bien-Être Commence Ici
        </span>
      </div>
      
      <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 dark:text-white mb-6">
        Prenez le Contrôle de Votre
        <span class="bg-gradient-to-r from-green-500 to-yellow-400 dark:from-green-400 dark:to-yellow-300 bg-clip-text text-transparent">
          Santé Mentale
        </span>
      </h1>
      
      <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 mb-12 max-w-3xl mx-auto">
        CESIZen vous aide à gérer le stress, suivre vos émotions et améliorer votre bien-être mental 
        avec des outils simples et scientifiquement validés.
      </p>

      <div v-if="user" class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <Link :href="isAdmin ? '/admin' : '/dashboard'">
          <Button size="lg" class="min-w-[200px] bg-green-500 hover:bg-green-600">
            <UIcon :name="isAdmin ? 'i-lucide-shield' : 'i-lucide-layout-dashboard'" class="mr-2 h-5 w-5" />
            {{ isAdmin ? 'Panneau Admin' : 'Tableau de Bord' }}
          </Button>
        </Link>
        <Link href="/articles">
          <Button size="lg" variant="outline" class="min-w-[200px] border-green-500 text-green-600 hover:bg-green-50">
            <UIcon name="i-lucide-book-open" class="mr-2 h-5 w-5" />
            Lire les Articles
          </Button>
        </Link>
      </div>
      
      <div v-else class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <Link href="/register">
          <Button size="lg" class="min-w-[200px] bg-green-500 hover:bg-green-600">
            <UIcon name="i-lucide-sparkles" class="mr-2 h-5 w-5" />
            Commencer Gratuitement
          </Button>
        </Link>
        <Link href="/articles">
          <Button size="lg" variant="outline" class="min-w-[200px] border-green-500 text-green-600 hover:bg-green-50">
            <UIcon name="i-lucide-book-open" class="mr-2 h-5 w-5" />
            Parcourir les Articles
          </Button>
        </Link>
      </div>

      <p class="text-sm text-gray-500 dark:text-gray-400 mt-6">
        Sans carte de crédit • Gratuit pour toujours • Respectueux de la vie privée
      </p>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="bg-gradient-to-r from-green-50/50 to-yellow-50/50 dark:from-gray-900/50 dark:to-gray-800/50 py-16 border-y border-gray-200/50 dark:border-gray-800/50">
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        <div class="group">
          <div class="text-5xl font-bold bg-gradient-to-r from-green-500 to-yellow-400 dark:from-green-400 dark:to-yellow-300 bg-clip-text text-transparent mb-2 group-hover:scale-110 transition-transform">100%</div>
          <div class="text-gray-600 dark:text-gray-400 font-medium">Gratuit</div>
        </div>
        <div class="group">
          <div class="text-5xl font-bold bg-gradient-to-r from-green-500 to-yellow-400 dark:from-green-400 dark:to-yellow-300 bg-clip-text text-transparent mb-2 group-hover:scale-110 transition-transform">24/7</div>
          <div class="text-gray-600 dark:text-gray-400 font-medium">Disponible</div>
        </div>
        <div class="group">
          <div class="text-5xl mb-2 group-hover:scale-110 transition-transform">🔒</div>
          <div class="text-gray-600 dark:text-gray-400 font-medium">Sécurisé</div>
        </div>
        <div class="group">
          <div class="text-5xl mb-2 group-hover:scale-110 transition-transform">✨</div>
          <div class="text-gray-600 dark:text-gray-400 font-medium">Scientifique</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="container mx-auto px-6 py-20">
    <div class="text-center mb-16">
      <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
        Tout ce dont Vous Avez Besoin pour Votre Bien-Être
      </h2>
      <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
        Des outils puissants conçus pour vous aider à comprendre et améliorer votre santé mentale
      </p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
      <Card v-for="(feature, index) in features" :key="index" class="group hover:shadow-2xl hover:shadow-green-500/10 transition-all hover:scale-[1.02] border-0 bg-white dark:bg-gray-900">
        <CardHeader>
          <div class="text-5xl mb-4 group-hover:scale-110 transition-transform">{{ feature.emoji }}</div>
          <CardTitle class="text-xl mb-2 group-hover:text-green-500 dark:group-hover:text-green-400 transition-colors">{{ feature.title }}</CardTitle>
          <CardDescription class="text-base">
            {{ feature.description }}
          </CardDescription>
        </CardHeader>
      </Card>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="container mx-auto px-6 py-20">
    <Card class="bg-gradient-to-r from-green-500 to-yellow-400 dark:from-green-600 dark:to-yellow-500 border-0 shadow-2xl shadow-green-500/20">
      <CardContent class="py-16 px-6 text-center">
        <div class="max-w-3xl mx-auto">
          <div class="inline-block mb-6">
            <div class="text-6xl">🌿</div>
          </div>
          <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Prêt à Commencer Votre Voyage vers le Bien-Être ?
          </h2>
          <p class="text-xl text-green-50 mb-8">
            Rejoignez CESIZen aujourd'hui et faites le premier pas vers une meilleure santé mentale et une gestion efficace du stress.
          </p>
          <div v-if="!user" class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <Link href="/register">
              <Button size="lg" variant="secondary" class="min-w-[200px] shadow-lg hover:shadow-xl transition-all">
                <UIcon name="i-lucide-sparkles" class="mr-2 h-5 w-5" />
                Créer un Compte Gratuit
              </Button>
            </Link>
            <Link href="/login">
              <Button size="lg" variant="outline" class="min-w-[200px] bg-white/10 hover:bg-white/20 text-white border-white/30 shadow-lg hover:shadow-xl transition-all">
                Se Connecter
              </Button>
            </Link>
          </div>
          <div v-else>
            <Link href="/dashboard">
              <Button size="lg" variant="secondary" class="min-w-[200px] shadow-lg hover:shadow-xl transition-all">
                <UIcon name="i-lucide-arrow-right" class="mr-2 h-5 w-5" />
                Accéder au Tableau de Bord
              </Button>
            </Link>
          </div>
        </div>
      </CardContent>
    </Card>
  </section>
</template>

