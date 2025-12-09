<script setup lang="ts">
import Layout from '@/layouts/Default.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Link } from '@inertiajs/vue3'

defineOptions({ layout: Layout })

const page = usePage()
const user = computed(() => page.props.auth.user)

const quickLinks = [
  {
    title: 'Browse Articles',
    description: 'Read our mental health articles',
    icon: 'lucide:book-open',
    href: '/articles',
    color: 'text-green-600 dark:text-green-400',
  },
  {
    title: 'Profile Settings',
    description: 'Manage your account information',
    icon: 'lucide:user',
    href: '/settings/profile',
    color: 'text-blue-600 dark:text-blue-400',
  },
  {
    title: 'Security',
    description: 'Update your password and security',
    icon: 'lucide:shield',
    href: '/settings/security',
    color: 'text-purple-600 dark:text-purple-400',
  },
]

</script>

<template>
  <UDashboardPanel id="home">
    <template #header>
      <UDashboardNavbar title="Dashboard">
        <template #leading>
          <UDashboardSidebarCollapse as="button" :disabled="false" />
        </template>
      </UDashboardNavbar>
    </template>

    <template #body>
      <div class="p-6 space-y-8">
        <!-- Welcome Section -->
        <div>
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            Welcome back, {{ user.name }}!
          </h1>
          <p class="text-gray-600 dark:text-gray-400">
            Manage your wellness journey from here
          </p>
        </div>

        <!-- Account Info Card -->
        <Card>
          <CardHeader>
            <CardTitle>Your Account</CardTitle>
            <CardDescription>Personal information and account details</CardDescription>
          </CardHeader>
          <CardContent class="grid md:grid-cols-3 gap-6">
            <div>
              <p class="text-sm text-muted-foreground mb-1">Name</p>
              <p class="font-medium text-lg">{{ user.name }}</p>
            </div>
            <div>
              <p class="text-sm text-muted-foreground mb-1">Email</p>
              <p class="font-medium text-lg">{{ user.email }}</p>
            </div>
            <div>
              <p class="text-sm text-muted-foreground mb-1">Account Type</p>
              <p class="font-medium text-lg">Standard User</p>
            </div>
          </CardContent>
        </Card>

        <!-- Quick Links -->
        <div>
          <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
            Quick Links
          </h2>
          <div class="grid gap-4 md:grid-cols-3">
            <Link
              v-for="link in quickLinks"
              :key="link.href"
              :href="link.href"
              class="group"
            >
              <Card class="hover:shadow-lg transition-shadow cursor-pointer h-full">
                <CardHeader>
                  <div class="flex items-start gap-4">
                    <div class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800">
                      <Icon :name="link.icon" :class="['h-6 w-6', link.color]" />
                    </div>
                    <div class="flex-1">
                      <CardTitle class="text-lg group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                        {{ link.title }}
                      </CardTitle>
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

        <!-- Wellness Section -->
        <Card>
          <CardHeader>
            <CardTitle>Your Wellness Journey</CardTitle>
            <CardDescription>Track your mental health progress</CardDescription>
          </CardHeader>
          <CardContent>
            <div class="text-center py-8">
              <UIcon name="i-lucide-heart" class="mx-auto h-16 w-16 text-green-600 dark:text-green-400 mb-4" />
              <p class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                Welcome to CESIZen
              </p>
              <p class="text-gray-600 dark:text-gray-400 mb-6">
                Start your journey to better mental health. Explore our articles and tools.
              </p>
              <Link href="/articles">
                <Button size="lg">
                  <UIcon name="i-lucide-book-open" class="mr-2 h-5 w-5" />
                  Browse Articles
                </Button>
              </Link>
            </div>
          </CardContent>
        </Card>
      </div>
    </template>
  </UDashboardPanel>
</template>
