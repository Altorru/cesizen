<script setup lang="ts">
  import { dashboard, login, register } from '@/routes'
</script>

<template>
  <Head title="Welcome to Cesizen" />
  
  <div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 dark:from-gray-900 dark:to-gray-800">
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-sm shadow-sm dark:bg-gray-800/80">
      <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <span class="text-2xl font-bold text-green-600 dark:text-green-400">Cesizen</span>
        </div>
        
        <div class="flex items-center space-x-4">
          <Link
            v-if="$page.props.auth.user"
            :href="dashboard()"
            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
          >
            Dashboard
          </Link>
          <template v-else>
            <Link
              :href="login()"
              class="px-6 py-2 text-green-600 hover:text-green-700 font-medium transition-colors dark:text-green-400"
            >
              Log in
            </Link>
            <Link
              :href="register()"
              class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
            >
              Register
            </Link>
          </template>
        </div>
      </nav>
    </header>

    <!-- Hero Section -->
    <main class="container mx-auto px-6 py-20">
      <div class="text-center max-w-4xl mx-auto">
        <h1 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6">
          Welcome to <span class="text-green-600 dark:text-green-400">Cesizen</span>
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 mb-12">
          Your modern Laravel + Vue application is ready to go. Start building something amazing!
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
          <Link
            v-if="!$page.props.auth.user"
            :href="register()"
            class="px-8 py-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-lg font-semibold shadow-lg"
          >
            Get Started
          </Link>
          <Link
            :href="dashboard()"
            class="px-8 py-4 bg-white text-green-600 rounded-lg hover:bg-gray-50 transition-colors text-lg font-semibold shadow-lg dark:bg-gray-800 dark:text-green-400"
          >
            View Dashboard
          </Link>
        </div>
      </div>

      <!-- Features -->
      <div class="mt-24 grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
          <div class="text-3xl mb-4">⚡</div>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Fast & Modern</h3>
          <p class="text-gray-600 dark:text-gray-300">Built with Laravel 11, Vue 3, and Vite for lightning-fast development.</p>
        </div>
        
        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
          <div class="text-3xl mb-4">🎨</div>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Beautiful UI</h3>
          <p class="text-gray-600 dark:text-gray-300">Styled with Tailwind CSS and Nuxt UI components for a polished look.</p>
        </div>
        
        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
          <div class="text-3xl mb-4">🔐</div>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Secure</h3>
          <p class="text-gray-600 dark:text-gray-300">Authentication powered by Laravel Fortify with 2FA support.</p>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer class="container mx-auto px-6 py-8 mt-20 text-center text-gray-600 dark:text-gray-400">
      <p>&copy; 2025 Cesizen. Built with ❤️ using Laravel & Vue.</p>
    </footer>
  </div>
</template>
