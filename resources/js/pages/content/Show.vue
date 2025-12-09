<script setup lang="ts">
import GuestLayout from '@/layouts/Guest.vue'
import { Card, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Link } from '@inertiajs/vue3'

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
  page: ContentPage
}

const props = defineProps<Props>()

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString('fr-FR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}

// Simple markdown-like parsing
const parseContent = (content: string) => {
  return content
    .replace(/^# (.+)$/gm, '<h1 class="text-3xl font-bold mt-6 mb-4">$1</h1>')
    .replace(/^## (.+)$/gm, '<h2 class="text-2xl font-bold mt-5 mb-3">$1</h2>')
    .replace(/^### (.+)$/gm, '<h3 class="text-xl font-bold mt-4 mb-2">$1</h3>')
    .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
    .replace(/\*(.+?)\*/g, '<em>$1</em>')
    .replace(/^- (.+)$/gm, '<li class="ml-6 list-disc">$1</li>')
    .replace(/\n\n/g, '</p><p class="mb-4">')
}

const formattedContent = computed(() => {
  return '<p class="mb-4">' + parseContent(props.page.content) + '</p>'
})

</script>

<template>
  <Head :title="`${props.page.title} - CESIZen`" />

  <article class="container mx-auto px-6 py-12">
    <div class="max-w-4xl mx-auto">
      <!-- Back Button -->
      <Link href="/articles" class="inline-block mb-8 group">
        <Button variant="ghost" size="sm" class="hover:text-green-600 dark:hover:text-green-400">
          <UIcon name="i-lucide-arrow-left" class="mr-2 h-4 w-4 group-hover:-translate-x-1 transition-transform" />
          Back to Articles
        </Button>
      </Link>

      <!-- Article Header -->
      <header class="mb-10">
        <Badge variant="secondary" class="mb-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
          <UIcon name="i-lucide-book-open" class="mr-1 h-3 w-3" />
          Article
        </Badge>
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
          {{ props.page.title }}
        </h1>
        <div class="flex flex-wrap items-center gap-4 text-gray-600 dark:text-gray-400">
          <div class="flex items-center gap-2">
            <UIcon name="i-lucide-calendar" class="h-4 w-4" />
            <time>{{ formatDate(props.page.published_at) }}</time>
          </div>
          <div class="flex items-center gap-2">
            <UIcon name="i-lucide-user" class="h-4 w-4" />
            <span>{{ props.page.creator.name }}</span>
          </div>
        </div>
      </header>

      <!-- Article Content -->
      <Card class="border-0 shadow-xl">
        <CardContent class="pt-8 pb-12 px-8 md:px-12">
          <div
            class="prose prose-lg prose-green dark:prose-invert max-w-none"
            v-html="formattedContent"
          />
        </CardContent>
      </Card>

      <!-- Footer Actions -->
      <div class="mt-12 flex justify-center">
        <Link href="/articles">
          <Button size="lg" variant="outline" class="shadow-lg hover:shadow-xl hover:text-green-600 dark:hover:text-green-400 transition-all">
            <UIcon name="i-lucide-grid" class="mr-2 h-5 w-5" />
            View All Articles
          </Button>
        </Link>
      </div>
    </div>
  </article>
</template>

