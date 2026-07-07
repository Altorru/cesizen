<script setup lang="ts">
  import { Button } from '@/components/ui/button'
  import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
  import GuestLayout from '@/layouts/Guest.vue'
  import { Head, Link } from '@inertiajs/vue3'

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
      description: "Accédez à une mine d'articles et de ressources sur la santé mentale et la gestion du stress.",
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
      description: "Accédez à vos outils de bien-être à tout moment, n'importe où, sur n'importe quel appareil.",
    },
  ]
</script>

<template>
  <Head title="CESIZen - Votre Compagnon de Bien-Être Mental" />

  <!-- Hero Section -->
  <section class="container mx-auto px-6 py-20 md:py-28">
    <div class="mx-auto max-w-4xl text-center">
      <div class="mb-6 inline-block">
        <span class="rounded-full bg-green-100 px-4 py-2 text-sm font-medium text-green-600 dark:bg-green-900/30 dark:text-green-400">
          🌟 Votre Voyage vers le Bien-Être Commence Ici
        </span>
      </div>

      <h1 class="mb-6 text-5xl font-bold text-gray-900 md:text-6xl lg:text-7xl dark:text-white">
        Prenez le Contrôle de Votre
        <span class="bg-gradient-to-r from-green-500 to-yellow-400 bg-clip-text text-transparent dark:from-green-400 dark:to-yellow-300">
          Santé Mentale Test !!!
        </span>
      </h1>

      <p class="mx-auto mb-12 max-w-3xl text-xl text-gray-600 md:text-2xl dark:text-gray-300">
        CESIZen vous aide à gérer le stress, suivre vos émotions et améliorer votre bien-être mental avec des outils simples et scientifiquement
        validés.
      </p>

      <div v-if="user" class="flex flex-col items-center justify-center gap-4 sm:flex-row">
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

      <div v-else class="flex flex-col items-center justify-center gap-4 sm:flex-row">
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

      <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">Sans carte de crédit • Gratuit pour toujours • Respectueux de la vie privée</p>
    </div>
  </section>

  <!-- Stats Section -->
  <section
    class="border-y border-gray-200/50 bg-gradient-to-r from-green-50/50 to-yellow-50/50 py-16 dark:border-gray-800/50 dark:from-gray-900/50 dark:to-gray-800/50"
  >
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-2 gap-8 text-center md:grid-cols-4">
        <div class="group">
          <div
            class="mb-2 bg-gradient-to-r from-green-500 to-yellow-400 bg-clip-text text-5xl font-bold text-transparent transition-transform group-hover:scale-110 dark:from-green-400 dark:to-yellow-300"
          >
            100%
          </div>
          <div class="font-medium text-gray-600 dark:text-gray-400">Gratuit</div>
        </div>
        <div class="group">
          <div
            class="mb-2 bg-gradient-to-r from-green-500 to-yellow-400 bg-clip-text text-5xl font-bold text-transparent transition-transform group-hover:scale-110 dark:from-green-400 dark:to-yellow-300"
          >
            24/7
          </div>
          <div class="font-medium text-gray-600 dark:text-gray-400">Disponible</div>
        </div>
        <div class="group">
          <div class="mb-2 text-5xl transition-transform group-hover:scale-110">🔒</div>
          <div class="font-medium text-gray-600 dark:text-gray-400">Sécurisé</div>
        </div>
        <div class="group">
          <div class="mb-2 text-5xl transition-transform group-hover:scale-110">✨</div>
          <div class="font-medium text-gray-600 dark:text-gray-400">Scientifique</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="container mx-auto px-6 py-20">
    <div class="mb-16 text-center">
      <h2 class="mb-4 text-3xl font-bold text-gray-900 md:text-4xl dark:text-white">Tout ce dont Vous Avez Besoin pour Votre Bien-Être</h2>
      <p class="mx-auto max-w-2xl text-xl text-gray-600 dark:text-gray-300">
        Des outils puissants conçus pour vous aider à comprendre et améliorer votre santé mentale
      </p>
    </div>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      <Card
        v-for="(feature, index) in features"
        :key="index"
        class="group border-0 bg-white transition-all hover:scale-[1.02] hover:shadow-2xl hover:shadow-green-500/10 dark:bg-gray-900"
      >
        <CardHeader>
          <div class="mb-4 text-5xl transition-transform group-hover:scale-110">{{ feature.emoji }}</div>
          <CardTitle class="mb-2 text-xl transition-colors group-hover:text-green-500 dark:group-hover:text-green-400">{{ feature.title }}</CardTitle>
          <CardDescription class="text-base">
            {{ feature.description }}
          </CardDescription>
        </CardHeader>
      </Card>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="container mx-auto px-6 py-20">
    <Card class="border-0 bg-gradient-to-r from-green-500 to-yellow-400 shadow-2xl shadow-green-500/20 dark:from-green-600 dark:to-yellow-500">
      <CardContent class="px-6 py-16 text-center">
        <div class="mx-auto max-w-3xl">
          <div class="mb-6 inline-block">
            <div class="text-6xl">🌿</div>
          </div>
          <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl">Prêt à Commencer Votre Voyage vers le Bien-Être ?</h2>
          <p class="mb-8 text-xl text-green-50">
            Rejoignez CESIZen aujourd'hui et faites le premier pas vers une meilleure santé mentale et une gestion efficace du stress.
          </p>
          <div v-if="!user" class="flex flex-col items-center justify-center gap-4 sm:flex-row">
            <Link href="/register">
              <Button size="lg" variant="secondary" class="min-w-[200px] shadow-lg transition-all hover:shadow-xl">
                <UIcon name="i-lucide-sparkles" class="mr-2 h-5 w-5" />
                Créer un Compte Gratuit
              </Button>
            </Link>
            <Link href="/login">
              <Button
                size="lg"
                variant="outline"
                class="min-w-[200px] border-white/30 bg-white/10 text-white shadow-lg transition-all hover:bg-white/20 hover:shadow-xl"
              >
                Se Connecter
              </Button>
            </Link>
          </div>
          <div v-else>
            <Link href="/dashboard">
              <Button size="lg" variant="secondary" class="min-w-[200px] shadow-lg transition-all hover:shadow-xl">
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
