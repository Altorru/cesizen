<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'

const page = usePage()
const user = computed(() => page.props.auth?.user)
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <!-- Header -->
    <header class="sticky top-0 z-50 border-b bg-white/80 backdrop-blur-sm dark:bg-gray-800/80 dark:border-gray-700">
      <nav class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
          <!-- Logo -->
          <Link href="/" class="flex items-center space-x-2 hover:opacity-80 transition-opacity">
            <span class="text-2xl font-bold bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400 bg-clip-text text-transparent">
              CESIZen
            </span>
          </Link>

          <!-- Navigation -->
          <div class="flex items-center gap-6">
            <Link
              href="/articles"
              class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 font-medium transition-colors"
            >
              Articles
            </Link>

            <div v-if="user" class="flex items-center gap-3">
              <Link :href="user.role === 'admin' ? '/admin' : '/dashboard'">
                <Button :variant="user.role === 'admin' ? 'default' : 'outline'">
                  <UIcon :name="user.role === 'admin' ? 'i-lucide-shield' : 'i-lucide-layout-dashboard'" class="mr-2 h-4 w-4" />
                  {{ user.role === 'admin' ? 'Admin' : 'Dashboard' }}
                </Button>
              </Link>
            </div>
            <div v-else class="flex items-center gap-3">
              <Link href="/login">
                <Button variant="ghost">
                  Log in
                </Button>
              </Link>
              <Link href="/register">
                <Button>
                  Get Started
                </Button>
              </Link>
            </div>
          </div>
        </div>
      </nav>
    </header>

    <!-- Main Content -->
    <main>
      <slot />
    </main>

    <!-- Footer -->
    <footer class="border-t bg-white dark:bg-gray-800 dark:border-gray-700 mt-20">
      <div class="container mx-auto px-6 py-12">
        <div class="grid md:grid-cols-4 gap-8">
          <!-- About -->
          <div class="md:col-span-2">
            <h3 class="text-xl font-bold bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400 bg-clip-text text-transparent mb-4">
              CESIZen
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">
              Your companion for stress management and mental well-being. 
              Take control of your mental health with our simple and effective tools.
            </p>
          </div>

          <!-- Quick Links -->
          <div>
            <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h4>
            <ul class="space-y-2">
              <li>
                <Link href="/" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                  Home
                </Link>
              </li>
              <li>
                <Link href="/articles" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                  Articles
                </Link>
              </li>
              <li v-if="!user">
                <Link href="/register" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                  Get Started
                </Link>
              </li>
            </ul>
          </div>

          <!-- Support -->
          <div>
            <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Support</h4>
            <ul class="space-y-2">
              <li>
                <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                  Help Center
                </a>
              </li>
              <li>
                <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                  Privacy Policy
                </a>
              </li>
              <li>
                <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                  Terms of Service
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div class="mt-8 pt-8 border-t dark:border-gray-700 text-center text-gray-600 dark:text-gray-400">
          <p>&copy; 2025 CESIZen. All rights reserved. Built with ❤️ for your well-being.</p>
        </div>
      </div>
    </footer>
  </div>
</template>
