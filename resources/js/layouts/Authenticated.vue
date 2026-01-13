<script setup lang="ts">
import type { NavigationMenuItem } from '@nuxt/ui'
import { Link } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth?.user)
const isAdmin = computed(() => user.value?.role === 'admin')
const open = ref(false)

// Active link detection
const currentUrl = computed(() => page.url)
const isActive = (path: string) => {
  if (path === '/') {
    return currentUrl.value === '/' || currentUrl.value === ''
  }
  return currentUrl.value.startsWith(path)
}

// Sidebar items dynamiques selon le rôle
const sidebarItems = computed(() => {
  if (!user.value) return []
  
  if (isAdmin.value) {
    // Sidebar Admin
    return [
      [
        {
          label: 'Tableau de Bord Admin',
          icon: 'i-lucide-shield',
          to: '/admin',
        },
        {
          label: 'Articles',
          icon: 'i-lucide-file-text',
          to: '/admin/content-pages',
        },
      ],
      [
        {
          label: 'Gestion du Contenu',
          icon: 'i-lucide-file-text',
          type: 'label',
        },
        {
          label: 'Tous les Articles',
          icon: 'i-lucide-list',
          to: '/admin/content-pages',
        },
        {
          label: 'Nouvel Article',
          icon: 'i-lucide-plus-circle',
          to: '/admin/content-pages/create',
        },
      ],
      [
        {
          label: 'Gestion des Utilisateurs',
          icon: 'i-lucide-users',
          to: '/admin/users',
          badge: 'Bientôt',
        },
      ],
      [
        {
          label: 'Retour au Site',
          icon: 'i-lucide-arrow-left',
          to: '/',
        },
      ],
    ] satisfies NavigationMenuItem[][]
  } else {
    // Sidebar User
    return [
      [
        {
          label: 'Tableau de Bord',
          icon: 'i-lucide-layout-dashboard',
          to: '/dashboard',
        },
        {
          label: 'Articles',
          icon: 'i-lucide-file-text',
          to: '/admin/content-pages',
        },
      ],
      [
        {
          label: 'Activités',
          icon: 'i-lucide-activity',
          type: 'label',
        },
        {
          label: 'Exercice de Respiration',
          icon: 'i-lucide-wind',
          to: '/activities/breathing',
          badge: 'Bientôt',
        },
        {
          label: 'Suivi des Émotions',
          icon: 'i-lucide-heart-pulse',
          to: '/activities/emotions',
          badge: 'Bientôt',
        },
      ]
    ] satisfies NavigationMenuItem[][]
  }
})
</script>

<template>
  <Suspense>
    <UApp>
      <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-50 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950">
        <!-- Top Navbar -->
        <header class="sticky top-0 z-50 border-b border-gray-200/50 dark:border-gray-800/50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg shadow-sm">
          <nav class="px-6 py-4">
            <div class="flex items-center justify-between">
              <!-- Left: Logo + Sidebar toggle -->
              <div class="flex items-center gap-4">
                <button
                  @click="open = !open"
                  class="lg:hidden p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
                >
                  <UIcon name="i-lucide-menu" class="h-5 w-5" />
                </button>
                
                <Link href="/" class="flex items-center gap-2 group">
                  <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-400/20 to-yellow-300/20 rounded-full blur-sm group-hover:blur-md transition-all"></div>
                    <img src="/images/logo.png" alt="CESIZen" class="relative h-7 w-7 object-contain" />
                  </div>
                  <span class="text-xl font-bold bg-gradient-to-r from-green-500 to-yellow-400 dark:from-green-400 dark:to-yellow-300 bg-clip-text text-transparent">
                    CESIZen
                  </span>
                </Link>
              </div>

              <!-- Center: Navigation links -->
              <div class="hidden md:flex items-center gap-8">
                <Link
                  href="/"
                  :class="[
                    'font-medium transition-all relative group',
                    isActive('/') 
                      ? 'text-green-500 dark:text-green-400' 
                      : 'text-gray-700 dark:text-gray-300 hover:text-green-500 dark:hover:text-green-400'
                  ]"
                >
                  Accueil
                  <span 
                    :class="[
                      'absolute -bottom-1 left-0 h-0.5 bg-gradient-to-r from-green-500 to-yellow-400 transition-all',
                      isActive('/') ? 'w-full' : 'w-0 group-hover:w-full'
                    ]"
                  ></span>
                </Link>
                <Link
                  href="/articles"
                  :class="[
                    'font-medium transition-all relative group',
                    isActive('/articles') 
                      ? 'text-green-500 dark:text-green-400' 
                      : 'text-gray-700 dark:text-gray-300 hover:text-green-500 dark:hover:text-green-400'
                  ]"
                >
                  Articles
                  <span 
                    :class="[
                      'absolute -bottom-1 left-0 h-0.5 bg-gradient-to-r from-green-500 to-yellow-400 transition-all',
                      isActive('/articles') ? 'w-full' : 'w-0 group-hover:w-full'
                    ]"
                  ></span>
                </Link>
                <Link
                  :href="isAdmin ? '/admin' : '/dashboard'"
                  :class="[
                    'font-medium transition-all relative group',
                    isActive(isAdmin ? '/admin' : '/dashboard') 
                      ? 'text-green-500 dark:text-green-400' 
                      : 'text-gray-700 dark:text-gray-300 hover:text-green-500 dark:hover:text-green-400'
                  ]"
                >
                  {{ isAdmin ? 'Admin' : 'Tableau de Bord' }}
                  <span 
                    :class="[
                      'absolute -bottom-1 left-0 h-0.5 bg-gradient-to-r from-green-500 to-yellow-400 transition-all',
                      isActive(isAdmin ? '/admin' : '/dashboard') ? 'w-full' : 'w-0 group-hover:w-full'
                    ]"
                  ></span>
                </Link>
              </div>

              <!-- Right: User menu -->
              <div class="flex items-center gap-3">
                <UserMenu :collapsed="false" />
              </div>
            </div>
          </nav>
        </header>

        <!-- Main Layout with Sidebar -->
        <div class="flex">
          <!-- Sidebar -->
          <aside
            :class="[
              'fixed lg:sticky top-[73px] left-0 h-[calc(100vh-73px)] bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-r border-gray-200/50 dark:border-gray-800/50 transition-all duration-300 z-40',
              open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
              'w-64'
            ]"
          >
            <div class="flex flex-col h-full p-4">
              <div class="flex-1 space-y-1 overflow-y-auto">
                <UNavigationMenu 
                  v-for="(items, index) in sidebarItems" 
                  :key="index"
                  :collapsed="false"
                  :items="items" 
                  orientation="vertical"
                  :class="index > 0 ? 'mt-4 pt-4 border-t border-gray-200/50 dark:border-gray-800/50' : ''"
                />
              </div>
            </div>
          </aside>

          <!-- Backdrop mobile -->
          <div
            v-if="open"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 lg:hidden"
            @click="open = false"
          />

          <!-- Main Content -->
          <main class="flex-1 min-h-[calc(100vh-73px)]">
            <slot />
          </main>
        </div>
      </div>
    </UApp>
  </Suspense>
</template>
