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
          <Card>
            <CardHeader class="pb-3">
              <CardDescription>Total Articles</CardDescription>
              <CardTitle class="text-4xl">{{ props.stats.total_articles }}</CardTitle>
            </CardHeader>
            <CardContent>
              <div class="text-xs text-muted-foreground">
                All content pages
              </div>
            </CardContent>
          </Card>

          <Card>
            <CardHeader class="pb-3">
              <CardDescription>Published</CardDescription>
              <CardTitle class="text-4xl text-green-600 dark:text-green-400">
                {{ props.stats.published_articles }}
              </CardTitle>
            </CardHeader>
            <CardContent>
              <div class="text-xs text-muted-foreground">
                Live on site
              </div>
            </CardContent>
          </Card>

          <Card>
            <CardHeader class="pb-3">
              <CardDescription>Drafts</CardDescription>
              <CardTitle class="text-4xl text-orange-600 dark:text-orange-400">
                {{ props.stats.draft_articles }}
              </CardTitle>
            </CardHeader>
            <CardContent>
              <div class="text-xs text-muted-foreground">
                Unpublished pages
              </div>
            </CardContent>
          </Card>

          <Card>
            <CardHeader class="pb-3">
              <CardDescription>Total Users</CardDescription>
              <CardTitle class="text-4xl text-blue-600 dark:text-blue-400">
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
              <Card class="hover:shadow-lg transition-shadow cursor-pointer h-full">
                <CardHeader>
                  <div class="flex items-start gap-4">
                    <div class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800">
                      <UIcon :name="action.icon" :class="['h-6 w-6', action.color]" />
                    </div>
                    <div class="flex-1">
                      <CardTitle class="text-lg group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                        {{ action.title }}
                      </CardTitle>
                      <CardDescription class="mt-1">
                        {{ action.description }}
                      </CardDescription>
                    </div>
                  </div>
                </CardHeader>
              </Card>
            </Link>
          </div>
        </div>

        <!-- Recent Activity -->
        <Card>
          <CardHeader>
            <CardTitle>Recent Activity</CardTitle>
            <CardDescription>Latest changes in your admin panel</CardDescription>
          </CardHeader>
          <CardContent>
            <div class="text-sm text-gray-600 dark:text-gray-400">
              <p class="mb-2">
                <UIcon name="i-lucide-info" class="inline h-4 w-4 mr-2" />
                Activity tracking coming soon...
              </p>
              <p>
                This section will show recent articles created, users registered, and other important events.
              </p>
            </div>
          </CardContent>
        </Card>
      </div>
</template>
