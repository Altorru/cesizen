<script setup lang="ts">
import EmailVerificationNotificationController from '@/actions/App/Http/Controllers/Auth/EmailVerificationNotificationController'
import AuthCard from '@/components/AuthCard.vue'
import { Button } from '@/components/ui/button'
import Layout from '@/layouts/Empty.vue'
import { logout } from '@/routes'
import { Form, Head, Link } from '@inertiajs/vue3'

defineOptions({ layout: Layout })

defineProps<{
  status?: string
}>()
</script>

<template>
  <AuthCard title="Verify your email" description="We've sent you a verification link. Please check your inbox.">
    <Head title="Email verification" />

    <div class="space-y-6">
      <div v-if="status === 'verification-link-sent'" class="p-3 text-center text-sm font-medium text-green-700 bg-green-50 dark:bg-green-900/20 dark:text-green-400 rounded-lg">
        A new verification link has been sent to your email address.
      </div>

      <Form v-bind="EmailVerificationNotificationController.store.form()" v-slot="{ processing }" class="space-y-4">
        <Button type="submit" :disabled="processing" variant="outline" class="w-full">
          <UIcon name="i-lucide-mail" class="mr-2 h-4 w-4" />
          Resend Verification Email
        </Button>
      </Form>

      <div class="text-center">
        <Link :href="logout()" as="button" class="text-sm text-muted-foreground hover:text-foreground transition-colors">
          Log out
        </Link>
      </div>
    </div>
  </AuthCard>
</template>
