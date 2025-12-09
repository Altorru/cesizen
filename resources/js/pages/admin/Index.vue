<script setup lang="ts">
import AdminLayout from '@/layouts/Authenticated.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Link } from '@inertiajs/vue3'

defineOptions({ layout: AdminLayout })

interface Props {
  stats: {
    total_articles: number
    published_articles: number
    draft_articles: number
    total_users: number
  }
}

const props = defineProps<Props>()

const quickActions = [
  {
    title: 'New Article',
    description: 'Create a new content page',
    icon: 'i-lucide-plus-circle',
    href: '/admin/content-pages/create',
    color: 'text-green-600 dark:text-green-400',
  },
  {
    title: 'Manage Articles',
    description: 'View and edit all articles',
    icon: 'i-lucide-list',
    href: '/admin/content-pages',
    color: 'text-blue-600 dark:text-blue-400',
  },
  {
    title: 'Manage Users',
    description: 'View and manage users',
    icon: 'i-lucide-users',
    href: '/admin/users',
    color: 'text-purple-600 dark:text-purple-400',
  },
  {
    title: 'View Site',
    description: 'Go to public website',
    icon: 'i-lucide-external-link',
    href: '/',
    color: 'text-gray-600 dark:text-gray-400',
  },
]
</script>

<template>
  <div class="p-6 space-y-8 max-w-7xl mx-auto">
    <!-- Welcome Section -->
    <div>
      <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
        Welcome to Admin Panel
      </h1>
      <p class="text-gray-600 dark:text-gray-400">
        Manage your CESIZen application content and users
      </p>
    </div>

    <!-- Stats Grid -->
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
          <Card class="border-0 shadow-lg hover:shadow-xl transition-all hover:scale-[1.02]">
            <CardHeader class="pb-3">
              <CardDescription>Total Articles</CardDescription>
              <CardTitle class="text-5xl font-bold bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400 bg-clip-text text-transparent">{{ props.stats.total_articles }}</CardTitle>
            </CardHeader>
            <CardContent>
              <div class="text-xs text-muted-foreground">
                All content pages
              </div>
            </CardContent>
          </Card>

          <Card class="border-0 shadow-lg hover:shadow-xl transition-all hover:scale-[1.02] bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20">
            <CardHeader class="pb-3">
              <CardDescription>Published</CardDescription>
              <CardTitle class="text-5xl font-bold text-green-600 dark:text-green-400">
                {{ props.stats.published_articles }}
              </CardTitle>
            </CardHeader>
            <CardContent>
              <div class="text-xs text-muted-foreground">
                Live on site
              </div>
            </CardContent>
          </Card>

          <Card class="border-0 shadow-lg hover:shadow-xl transition-all hover:scale-[1.02] bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20">
            <CardHeader class="pb-3">
              <CardDescription>Drafts</CardDescription>
              <CardTitle class="text-5xl font-bold text-orange-600 dark:text-orange-400">
                {{ props.stats.draft_articles }}
              </CardTitle>
            </CardHeader>
            <CardContent>
              <div class="text-xs text-muted-foreground">
                Unpublished pages
              </div>
            </CardContent>
          </Card>

          <Card class="border-0 shadow-lg hover:shadow-xl transition-all hover:scale-[1.02] bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20">
            <CardHeader class="pb-3">
              <CardDescription>Total Users</CardDescription>
              <CardTitle class="text-5xl font-bold text-blue-600 dark:text-blue-400">
                {{ props.stats.total_users }}
              </CardTitle>
            </CardHeader>
            <CardContent>
              <div class="text-xs text-muted-foreground">
                Registered accounts
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Quick Actions -->
        <div>
          <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
            Quick Actions
          </h2>
          <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <Link
              v-for="action in quickActions"
              :key="action.href"
              :href="action.href"
              class="group"
            >
              <Card class="border-0 shadow-lg hover:shadow-2xl hover:shadow-green-500/10 transition-all cursor-pointer h-full hover:scale-[1.02]">
                <CardHeader>
                  <div class="flex items-start gap-4">
                    <div class="p-3 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 group-hover:scale-110 transition-transform">
                      <UIcon :name="action.icon" :class="['h-6 w-6', action.color]" />
                    </div>
                    <div class="flex-1">
                      <CardTitle class="text-lg group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors mb-1">
                        {{ action.title }}
                      </CardTitle>
                      <CardDescription class="text-sm">
                        {{ action.description }}
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
