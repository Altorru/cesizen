<script setup lang="ts">
import PasswordResetLinkController from '@/actions/App/Http/Controllers/Auth/PasswordResetLinkController'
import AuthCard from '@/components/AuthCard.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import Layout from '@/layouts/Empty.vue'
import { login } from '@/routes'
import { Form, Head, Link } from '@inertiajs/vue3'

defineOptions({ layout: Layout })

defineProps<{
  status?: string
}>()
</script>

<template>
  <AuthCard title="Mot de passe oublié ?" description="Pas de souci, nous vous enverrons des instructions de réinitialisation">
    <Head title="Mot de passe oublié" />

    <div v-if="status" class="mb-4 p-3 text-center text-sm font-medium text-green-700 bg-green-50 dark:bg-green-900/20 dark:text-green-400 rounded-lg">
      {{ status }}
    </div>

    <Form v-bind="PasswordResetLinkController.store.form()" v-slot="{ errors, processing }" class="space-y-6">
      <div class="space-y-4">
        <div class="space-y-2">
          <Label for="email">Adresse e-mail</Label>
          <Input 
            id="email"
            name="email" 
            type="email" 
            autocomplete="email" 
            placeholder="email@exemple.com" 
            autofocus 
            required 
          />
          <p v-if="errors.email" class="text-sm text-destructive">{{ errors.email }}</p>
        </div>

        <Button type="submit" :disabled="processing" class="w-full bg-green-500 hover:bg-green-600">
          Envoyer le Lien de Réinitialisation
        </Button>
      </div>

      <div class="text-center text-sm text-muted-foreground">
        Vous vous souvenez de votre mot de passe ?
        <Link :href="login()" class="text-green-600 hover:text-green-700 hover:underline font-medium">
          Retour à la connexion
        </Link>
      </div>
    </Form>
  </AuthCard>
</template>
