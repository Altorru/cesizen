<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { dashboard, login, register } from '@/routes'

const page = usePage()

// Redirect to dashboard if user is authenticated
// if (page.props.auth.user) {
//   router.visit(dashboard())
// }
</script>

<template>
  <Head title="Welcome to Cesizen" />
  
  <div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 dark:from-gray-900 dark:to-gray-800">
    <!-- Header -->
    <header class="border-b bg-white/80 backdrop-blur-sm dark:bg-gray-800/80 dark:border-gray-700">
      <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <span class="text-2xl font-bold text-green-600 dark:text-green-400">Cesizen</span>
        </div>
        
        <div class="flex items-center gap-3">
          <Button variant="ghost" as-child>
            <Link :href="login()">Log in</Link>
          </Button>
          <Button as-child>
            <Link :href="register()">Get Started</Link>
          </Button>
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
          Your modern Laravel + Vue application built with cutting-edge technology.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
          <Button size="lg" as-child>
            <Link :href="register()">
              Get Started
            </Link>
          </Button>
          <Button size="lg" variant="outline" as-child>
            <Link :href="login()">
              Sign In
            </Link>
          </Button>
        </div>
      </div>

      <!-- Features -->
      <div class="mt-24 grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        <Card>
          <CardHeader>
            <div class="text-3xl mb-2">⚡</div>
            <CardTitle>Fast & Modern</CardTitle>
            <CardDescription>
              Built with Laravel 12, Vue 3, and Vite for lightning-fast development.
            </CardDescription>
          </CardHeader>
        </Card>
        
        <Card>
          <CardHeader>
            <div class="text-3xl mb-2">🎨</div>
            <CardTitle>Beautiful UI</CardTitle>
            <CardDescription>
              Styled with Tailwind CSS and shadcn-vue components for a polished look.
            </CardDescription>
          </CardHeader>
        </Card>
        
        <Card>
          <CardHeader>
            <div class="text-3xl mb-2">🔐</div>
            <CardTitle>Secure</CardTitle>
            <CardDescription>
              Authentication powered by Laravel Fortify with 2FA support.
            </CardDescription>
          </CardHeader>
        </Card>
      </div>
    </main>

    <!-- Footer -->
    <footer class="container mx-auto px-6 py-8 mt-20 text-center text-gray-600 dark:text-gray-400 border-t dark:border-gray-700">
      <p>&copy; 2025 Cesizen. Built with ❤️ using Laravel & Vue.</p>
    </footer>
  </div>
</template>
