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
      <div class="min-h-screen bg-gradient-to-br from-green-50/50 via-white to-blue-50/50 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950">
        <!-- Pattern subtil pour plus de douceur -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(16,185,129,0.08),transparent_50%)]" />
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_80%,rgba(59,130,246,0.08),transparent_50%)]" />
        
        <div class="relative">
          <!-- Top Navbar -->
          <header class="sticky top-0 z-50 border-b border-gray-200/50 dark:border-gray-800/50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg shadow-sm">
            <nav class="px-6 py-4">
              <div class="flex items-center justify-between">
                <!-- Left: Logo -->
                <Link href="/" class="flex items-center gap-2 group">
                  <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-400/20 to-blue-400/20 rounded-full blur-sm group-hover:blur-md transition-all"></div>
                    <UIcon name="i-lucide-heart" class="relative h-7 w-7 text-green-600 dark:text-green-400" />
                  </div>
                  <span class="text-xl font-bold bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400 bg-clip-text text-transparent">
                    CESIZen
                  </span>
                </Link>

                <!-- Center: Navigation links -->
                <div class="hidden md:flex items-center gap-8">
                  <Link
                    href="/"
                    class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 font-medium transition-all relative group"
                  >
                    Home
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-green-600 to-blue-600 group-hover:w-full transition-all"></span>
                  </Link>
                  <Link
                    href="/articles"
                    class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 font-medium transition-all relative group"
                  >
                    Articles
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-green-600 to-blue-600 group-hover:w-full transition-all"></span>
                  </Link>
                  <Link
                    v-if="user"
                    :href="isAdmin ? '/admin' : '/dashboard'"
                    class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 font-medium transition-all relative group"
                  >
                    {{ isAdmin ? 'Admin' : 'Dashboard' }}
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-green-600 to-blue-600 group-hover:w-full transition-all"></span>
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
                      <UButton variant="ghost" color="neutral" class="hover:text-green-600 dark:hover:text-green-400">
                        Log in
                      </UButton>
                    </Link>
                    <Link href="/register">
                      <UButton class="bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 shadow-md hover:shadow-lg transition-all">
                        Get Started
                      </UButton>
                    </Link>
                  </template>
                </div>
              </div>
            </nav>
          </header>

          <!-- Main Content -->
          <main class="min-h-[calc(100vh-73px)]">
            <slot />
          </main>
        </div>
      </div>
    </UApp>
  </Suspense>
</template>
