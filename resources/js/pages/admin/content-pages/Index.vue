<script setup lang="ts">
import AdminLayout from '@/layouts/Admin.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Link, router } from '@inertiajs/vue3'

defineOptions({ layout: AdminLayout })

interface ContentPage {
  id: string
  title: string
  slug: string
  is_published: boolean
  published_at: string | null
  created_at: string
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

const deletePage = (id: string) => {
  if (confirm('Are you sure you want to delete this page?')) {
    router.delete(`/admin/content-pages/${id}`)
  }
}
</script>

<template>
  <UDashboardPanel id="admin-content-pages">
    <template #header>
      <UDashboardNavbar title="Content Management">
        <template #leading>
          <UDashboardSidebarCollapse as="button" :disabled="false" />
        </template>
        <template #trailing>
          <Link href="/admin/content-pages/create">
            <Button>
              <UIcon name="i-lucide-plus" class="mr-2 h-4 w-4" />
              New Article
            </Button>
          </Link>
        </template>
      </UDashboardNavbar>
    </template>

    <template #body>
      <div class="p-6 space-y-6">
        <!-- Header -->
        <div>
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            Content Pages
          </h1>
          <p class="text-gray-600 dark:text-gray-400">
            Manage informational pages for your application.
          </p>
        </div>

        <!-- Pages List -->
        <Card>
          <CardHeader>
            <CardTitle>All Pages</CardTitle>
            <CardDescription>
              {{ props.pages.total }} total pages
            </CardDescription>
          </CardHeader>
          <CardContent>
            <div v-if="props.pages.data.length === 0" class="text-center py-12">
              <UIcon name="i-lucide-file-text" class="mx-auto h-12 w-12 text-gray-400 mb-4" />
              <p class="text-gray-500 dark:text-gray-400 mb-4">
                No content pages yet
              </p>
              <Link href="/admin/content-pages/create">
                <Button>Create your first page</Button>
              </Link>
            </div>

            <div v-else class="space-y-4">
              <div
                v-for="page in props.pages.data"
                :key="page.id"
                class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
              >
                <div class="flex-1">
                  <div class="flex items-center gap-3 mb-2">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                      {{ page.title }}
                    </h3>
                    <Badge :variant="page.is_published ? 'default' : 'secondary'">
                      {{ page.is_published ? 'Published' : 'Draft' }}
                    </Badge>
                  </div>
                  <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                    <span class="font-medium">Slug:</span> /{{ page.slug }}
                  </p>
                  <p class="text-xs text-gray-500 dark:text-gray-400">
                    Created by {{ page.creator.name }} on {{ formatDate(page.created_at) }}
                  </p>
                </div>

                <div class="flex items-center gap-2">
                  <Link :href="`/admin/content-pages/${page.id}/edit`">
                    <Button variant="outline" size="sm">
                      <UIcon name="i-lucide-edit" class="h-4 w-4" />
                    </Button>
                  </Link>
                  <Button variant="outline" size="sm" @click="deletePage(page.id)">
                    <UIcon name="i-lucide-trash-2" class="h-4 w-4" />
                  </Button>
                </div>
              </div>
            </div>

            <!-- Pagination -->
            <div
              v-if="props.pages.last_page > 1"
              class="mt-6 flex items-center justify-between"
            >
              <p class="text-sm text-gray-600 dark:text-gray-400">
                Showing {{ (props.pages.current_page - 1) * props.pages.per_page + 1 }} to
                {{
                  Math.min(
                    props.pages.current_page * props.pages.per_page,
                    props.pages.total
                  )
                }}
                of {{ props.pages.total }} results
              </p>
              <div class="flex gap-2">
                <Link
                  :href="`/admin/content-pages?page=${props.pages.current_page - 1}`"
                  :disabled="props.pages.current_page === 1"
                >
                  <Button
                    variant="outline"
                    size="sm"
                    :disabled="props.pages.current_page === 1"
                  >
                    Previous
                  </Button>
                </Link>
                <Link
                  :href="`/admin/content-pages?page=${props.pages.current_page + 1}`"
                  :disabled="props.pages.current_page === props.pages.last_page"
                >
                  <Button
                    variant="outline"
                    size="sm"
                    :disabled="props.pages.current_page === props.pages.last_page"
                  >
                    Next
                  </Button>
                </Link>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>
    </template>
  </UDashboardPanel>
</template>
