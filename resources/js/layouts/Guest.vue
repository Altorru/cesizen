<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

// Layout pour les pages publiques avec navbar adaptative selon l'état de connexion
const page = usePage()
const user = computed(() => page.props.auth?.user)
const isAdmin = computed(() => user.value?.role === 'admin')
</script>

<template>
  <Suspense>
    <UApp>
      <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Top Navbar -->
        <header class="sticky top-0 z-50 border-b bg-white dark:bg-gray-800 shadow-sm">
          <nav class="px-6 py-3">
            <div class="flex items-center justify-between">
              <!-- Left: Logo -->
              <Link href="/" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                <UIcon name="i-lucide-heart" class="h-6 w-6 text-green-600" />
                <span class="text-xl font-bold bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400 bg-clip-text text-transparent">
                  CESIZen
                </span>
              </Link>

              <!-- Center: Navigation links -->
              <div class="hidden md:flex items-center gap-6">
                <Link
                  href="/"
                  class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 font-medium transition-colors"
                >
                  Home
                </Link>
                <Link
                  href="/articles"
                  class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 font-medium transition-colors"
                >
                  Articles
                </Link>
                <Link
                  v-if="user"
                  :href="isAdmin ? '/admin' : '/dashboard'"
                  class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 font-medium transition-colors"
                >
                  {{ isAdmin ? 'Admin' : 'Dashboard' }}
                </Link>
              </div>

              <!-- Right: User menu or Auth buttons -->
              <div class="flex items-center gap-3">
                <template v-if="user">                  
                  <!-- User Dropdown Menu -->
                  <UserMenu :collapsed="false" />
                </template>
                
                <template v-else>
                  <Link href="/login">
                    <UButton variant="ghost" color="neutral">
                      Log in
                    </UButton>
                  </Link>
                  <Link href="/register">
                    <UButton>
                      Get Started
                    </UButton>
                  </Link>
                </template>
              </div>
            </div>
          </nav>
        </header>

        <!-- Main Content -->
        <main class="min-h-[calc(100vh-57px)]">
          <slot />
        </main>
      </div>
    </UApp>
  </Suspense>
</template>
