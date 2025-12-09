<script setup lang="ts">
import Layout from '@/layouts/Default.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'

defineOptions({ layout: Layout })

const page = usePage()
const user = computed(() => page.props.auth.user)
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
            Here's what's happening with your account today.
          </p>
        </div>

        <!-- Cards Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          <!-- User Info Card -->
          <Card>
            <CardHeader>
              <CardTitle>Account Information</CardTitle>
              <CardDescription>Your personal details</CardDescription>
            </CardHeader>
            <CardContent class="space-y-3">
              <div>
                <p class="text-sm text-muted-foreground">Name</p>
                <p class="font-medium">{{ user.name }}</p>
              </div>
              <div>
                <p class="text-sm text-muted-foreground">Email</p>
                <p class="font-medium">{{ user.email }}</p>
              </div>
              <div>
                <p class="text-sm text-muted-foreground">User ID</p>
                <p class="font-mono text-sm">{{ user.id }}</p>
              </div>
            </CardContent>
          </Card>

          <!-- Quick Actions Card -->
          <Card>
            <CardHeader>
              <CardTitle>Quick Actions</CardTitle>
              <CardDescription>Manage your account</CardDescription>
            </CardHeader>
            <CardContent class="space-y-2">
              <Button variant="outline" class="w-full justify-start" as-child>
                <Link href="/settings/profile">
                  <UIcon name="i-lucide-user" class="mr-2 size-4" />
                  Edit Profile
                </Link>
              </Button>
              <Button variant="outline" class="w-full justify-start" as-child>
                <Link href="/settings/security">
                  <UIcon name="i-lucide-shield" class="mr-2 size-4" />
                  Security Settings
                </Link>
              </Button>
            </CardContent>
          </Card>

          <!-- Account Status Card -->
          <Card>
            <CardHeader>
              <CardTitle>Account Status</CardTitle>
              <CardDescription>Your account details</CardDescription>
            </CardHeader>
            <CardContent class="space-y-4">
              <div class="flex items-center justify-between">
                <span class="text-sm text-muted-foreground">Member Since</span>
                <span class="text-sm font-medium">{{ new Date(user.created_at).toLocaleDateString() }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-sm text-muted-foreground">Last Updated</span>
                <span class="text-sm font-medium">{{ new Date(user.updated_at).toLocaleDateString() }}</span>
              </div>
            </CardContent>
          </Card>
        </div>
      </div>
    </template>
  </UDashboardPanel>
</template>
