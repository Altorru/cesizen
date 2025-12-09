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
  <AuthCard title="Vérifiez votre e-mail" description="Nous vous avons envoyé un lien de vérification. Veuillez consulter votre boîte de réception.">
    <Head title="Vérification de l'e-mail" />

    <div class="space-y-6">
      <div v-if="status === 'verification-link-sent'" class="p-3 text-center text-sm font-medium text-green-700 bg-green-50 dark:bg-green-900/20 dark:text-green-400 rounded-lg">
        Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
      </div>

      <Form v-bind="EmailVerificationNotificationController.store.form()" v-slot="{ processing }" class="space-y-4">
        <Button type="submit" :disabled="processing" variant="outline" class="w-full border-green-500 text-green-600 hover:bg-green-50">
          <UIcon name="i-lucide-mail" class="mr-2 h-4 w-4" />
          Renvoyer l'E-mail de Vérification
        </Button>
      </Form>

      <div class="text-center">
        <Link :href="logout()" as="button" class="text-sm text-muted-foreground hover:text-foreground transition-colors">
          Se déconnecter
        </Link>
      </div>
    </div>
  </AuthCard>
</template>
