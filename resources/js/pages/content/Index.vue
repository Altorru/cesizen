<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import GuestLayout from '@/layouts/Guest.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'

defineOptions({ layout: GuestLayout })

interface ContentPage {
  id: string
  title: string
  slug: string
  content: string
  published_at: string
  creator: {
    name: string
  }
}

interface Props {
  pages: {
    data: ContentPage[]
    current_page: number
    last_page: number
    per_page: number
    total: number
  }
}

const props = defineProps<Props>()

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString('fr-FR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}

const getExcerpt = (content: string, length: number = 150) => {
  const text = content.replace(/[#*_\[\]]/g, '')
  return text.length > length ? text.substring(0, length) + '...' : text
}

</script>

<template>
  <Head title="Articles - CESIZen" />

  <div class="container mx-auto px-6 py-12">
    <!-- Header -->
    <div class="mb-12 text-center">
      <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
        Articles sur la santé mentale
      </h1>
      <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
        Découvrez notre collection d'articles sur la gestion du stress, le bien-être mental et l'autosoin.
      </p>
    </div>

    <!-- Empty State -->
    <div v-if="props.pages.data.length === 0" class="text-center py-20">
      <div class="text-6xl mb-6">📚</div>
      <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">
        Aucun article pour le moment
      </h3>
      <p class="text-lg text-gray-600 dark:text-gray-400">
        Nous travaillons à la création de contenu de qualité pour vous. Revenez bientôt !
      </p>
    </div>

    <!-- Articles Grid -->
    <div v-else class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
      <Link
        v-for="page in props.pages.data"
        :key="page.id"
        :href="`/articles/${page.slug}`"
        class="group"
      >
        <Card class="h-full hover:shadow-2xl hover:shadow-green-500/10 transition-all hover:scale-[1.02] border-0 shadow-lg bg-white dark:bg-gray-900">
          <CardHeader>
            <div class="flex items-start justify-between mb-3">
              <Badge variant="secondary" class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                <UIcon name="i-lucide-book-open" class="mr-1 h-3 w-3" />
                Article
              </Badge>
            </div>
            <CardTitle class="text-xl group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors line-clamp-2 mb-2">
              {{ page.title }}
            </CardTitle>
            <CardDescription class="text-sm flex items-center gap-1">
              <UIcon name="i-lucide-calendar" class="h-3 w-3" />
              {{ formatDate(page.published_at) }}
            </CardDescription>
          </CardHeader>
          <CardContent class="space-y-4">
            <p class="text-gray-600 dark:text-gray-400 line-clamp-3">
              {{ getExcerpt(page.content) }}
            </p>
            <div class="flex items-center text-sm text-green-600 dark:text-green-400 font-medium group-hover:underline">
              Lire l'article
              <UIcon name="i-lucide-arrow-right" class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform" />
            </div>
          </CardContent>
        </Card>
      </Link>
    </div>

    <!-- Pagination -->
    <div
      v-if="props.pages.last_page > 1"
      class="mt-12 flex items-center justify-center gap-3"
    >
      <Link
        v-if="props.pages.current_page > 1"
        :href="`/articles?page=${props.pages.current_page - 1}`"
      >
        <Button variant="outline">
          <UIcon name="i-lucide-chevron-left" class="mr-2 h-4 w-4" />
          Précédent
        </Button>
      </Link>
      
      <span class="px-4 py-2 text-gray-700 dark:text-gray-300 font-medium">
        Page {{ props.pages.current_page }} sur {{ props.pages.last_page }}
      </span>

      <Link
        v-if="props.pages.current_page < props.pages.last_page"
        :href="`/articles?page=${props.pages.current_page + 1}`"
      >
        <Button variant="outline">
          Suivant
          <UIcon name="i-lucide-chevron-right" class="ml-2 h-4 w-4" />
        </Button>
      </Link>
    </div>
  </div>
</template>

