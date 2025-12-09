<script setup lang="ts">
import GuestLayout from '@/layouts/Guest.vue'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Link } from '@inertiajs/vue3'

defineOptions({ layout: GuestLayout })

const page = usePage()
const user = computed(() => page.props.auth?.user)
const isAdmin = computed(() => user.value?.role === 'admin')


const features = [
  {
    emoji: '🧘',
    title: 'Breathing Exercises',
    description: 'Guided breathing exercises to help you relax and reduce stress through proven techniques.',
  },
  {
    emoji: '📊',
    title: 'Emotion Tracking',
    description: 'Keep track of your emotions and identify patterns to better understand your mental state.',
  },
  {
    emoji: '📚',
    title: 'Educational Content',
    description: 'Access a wealth of articles and resources about mental health and stress management.',
  },
  {
    emoji: '🎯',
    title: 'Personal Dashboard',
    description: 'Monitor your progress and see your journey towards better mental well-being.',
  },
  {
    emoji: '🔒',
    title: 'Private & Secure',
    description: 'Your data is encrypted and protected. We respect your privacy and confidentiality.',
  },
  {
    emoji: '📱',
    title: 'Always Available',
    description: 'Access your wellness tools anytime, anywhere, on any device.',
  },
]
</script>

<template>
  <Head title="Welcome to CESIZen - Your Mental Wellness Companion" />

  <!-- Hero Section -->
  <section class="container mx-auto px-6 py-20 md:py-28">
    <div class="text-center max-w-4xl mx-auto">
      <div class="inline-block mb-6">
        <span class="px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full text-sm font-medium">
          🌟 Your Mental Wellness Journey Starts Here
        </span>
      </div>
      
      <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 dark:text-white mb-6">
        Take Control of Your
        <span class="bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400 bg-clip-text text-transparent">
          Mental Health
        </span>
      </h1>
      
      <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 mb-12 max-w-3xl mx-auto">
        CESIZen helps you manage stress, track your emotions, and improve your mental well-being 
        with simple, science-backed tools.
      </p>

      <div v-if="user" class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <Link :href="isAdmin ? '/admin' : '/dashboard'">
          <Button size="lg" class="min-w-[200px]">
            <UIcon :name="isAdmin ? 'i-lucide-shield' : 'i-lucide-layout-dashboard'" class="mr-2 h-5 w-5" />
            {{ isAdmin ? 'Admin Panel' : 'Dashboard' }}
          </Button>
        </Link>
        <Link href="/articles">
          <Button size="lg" variant="outline" class="min-w-[200px]">
            <UIcon name="i-lucide-book-open" class="mr-2 h-5 w-5" />
            Read Articles
          </Button>
        </Link>
      </div>
      
      <div v-else class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <Link href="/register">
          <Button size="lg" class="min-w-[200px]">
            <UIcon name="i-lucide-sparkles" class="mr-2 h-5 w-5" />
            Get Started Free
          </Button>
        </Link>
        <Link href="/articles">
          <Button size="lg" variant="outline" class="min-w-[200px]">
            <UIcon name="i-lucide-book-open" class="mr-2 h-5 w-5" />
            Browse Articles
          </Button>
        </Link>
      </div>

      <p class="text-sm text-gray-500 dark:text-gray-400 mt-6">
        No credit card required • Free forever • Privacy focused
      </p>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="bg-gradient-to-r from-green-50/50 to-blue-50/50 dark:from-gray-900/50 dark:to-gray-800/50 py-16 border-y border-gray-200/50 dark:border-gray-800/50">
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        <div class="group">
          <div class="text-5xl font-bold bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400 bg-clip-text text-transparent mb-2 group-hover:scale-110 transition-transform">100%</div>
          <div class="text-gray-600 dark:text-gray-400 font-medium">Free to Use</div>
        </div>
        <div class="group">
          <div class="text-5xl font-bold bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400 bg-clip-text text-transparent mb-2 group-hover:scale-110 transition-transform">24/7</div>
          <div class="text-gray-600 dark:text-gray-400 font-medium">Available</div>
        </div>
        <div class="group">
          <div class="text-5xl mb-2 group-hover:scale-110 transition-transform">🔒</div>
          <div class="text-gray-600 dark:text-gray-400 font-medium">Secure & Private</div>
        </div>
        <div class="group">
          <div class="text-5xl mb-2 group-hover:scale-110 transition-transform">✨</div>
          <div class="text-gray-600 dark:text-gray-400 font-medium">Science-Based</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="container mx-auto px-6 py-20">
    <div class="text-center mb-16">
      <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
        Everything You Need for Mental Wellness
      </h2>
      <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
        Powerful tools designed to help you understand and improve your mental health
      </p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
      <Card v-for="(feature, index) in features" :key="index" class="group hover:shadow-2xl hover:shadow-green-500/10 transition-all hover:scale-[1.02] border-0 bg-white dark:bg-gray-900">
        <CardHeader>
          <div class="text-5xl mb-4 group-hover:scale-110 transition-transform">{{ feature.emoji }}</div>
          <CardTitle class="text-xl mb-2 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">{{ feature.title }}</CardTitle>
          <CardDescription class="text-base">
            {{ feature.description }}
          </CardDescription>
        </CardHeader>
      </Card>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="container mx-auto px-6 py-20">
    <Card class="bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-700 dark:to-blue-700 border-0 shadow-2xl shadow-green-500/20">
      <CardContent class="py-16 px-6 text-center">
        <div class="max-w-3xl mx-auto">
          <div class="inline-block mb-6">
            <div class="text-6xl">🌿</div>
          </div>
          <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Ready to Start Your Wellness Journey?
          </h2>
          <p class="text-xl text-green-50 mb-8">
            Join CESIZen today and take the first step towards better mental health and stress management.
          </p>
          <div v-if="!user" class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <Link href="/register">
              <Button size="lg" variant="secondary" class="min-w-[200px] shadow-lg hover:shadow-xl transition-all">
                <UIcon name="i-lucide-sparkles" class="mr-2 h-5 w-5" />
                Create Free Account
              </Button>
            </Link>
            <Link href="/login">
              <Button size="lg" variant="outline" class="min-w-[200px] bg-white/10 hover:bg-white/20 text-white border-white/30 shadow-lg hover:shadow-xl transition-all">
                Sign In
              </Button>
            </Link>
          </div>
          <div v-else>
            <Link href="/dashboard">
              <Button size="lg" variant="secondary" class="min-w-[200px] shadow-lg hover:shadow-xl transition-all">
                <UIcon name="i-lucide-arrow-right" class="mr-2 h-5 w-5" />
                Continue to Dashboard
              </Button>
            </Link>
          </div>
        </div>
      </CardContent>
    </Card>
  </section>
</template>

