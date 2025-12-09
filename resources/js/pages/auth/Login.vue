<script setup lang="ts">
import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController'
import AuthCard from '@/components/AuthCard.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import Layout from '@/layouts/Empty.vue'
import { register } from '@/routes'
import { request } from '@/routes/password'
import { Form, Head, Link } from '@inertiajs/vue3'

defineOptions({ layout: Layout })

defineProps<{
  status?: string
  canResetPassword: boolean
}>()
</script>

<template>
  <AuthCard title="Bon retour" description="Entrez vos identifiants pour accéder à votre compte">
    <Head title="Connexion" />

    <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600 dark:text-green-400">
      {{ status }}
    </div>

    <Form
      v-bind="AuthenticatedSessionController.store.form()"
      :reset-on-success="['password']"
      v-slot="{ errors, processing }"
      class="space-y-6"
    >
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

        <div class="space-y-2">
          <div class="flex items-center justify-between">
            <Label for="password">Mot de passe</Label>
            <Link v-if="canResetPassword" :href="request()" class="text-sm text-green-600 hover:text-green-700 hover:underline">
              Mot de passe oublié ?
            </Link>
          </div>
          <Input 
            id="password"
            name="password"
            type="password" 
            autocomplete="current-password" 
            placeholder="••••••••" 
            required 
          />
          <p v-if="errors.password" class="text-sm text-destructive">{{ errors.password }}</p>
        </div>

        <div class="flex items-center space-x-2">
          <input 
            id="remember" 
            name="remember" 
            type="checkbox" 
            class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500 focus:ring-offset-0"
          />
          <Label for="remember" class="text-sm font-normal cursor-pointer">Se souvenir de moi</Label>
        </div>

        <Button :disabled="processing" type="submit" class="w-full bg-green-500 hover:bg-green-600">
          Se connecter
        </Button>
      </div>

      <div class="text-center text-sm text-muted-foreground">
        Vous n'avez pas de compte ?
        <Link :href="register()" class="text-green-600 hover:text-green-700 hover:underline font-medium">
          S'inscrire
        </Link>
      </div>
    </Form>
  </AuthCard>
</template>
