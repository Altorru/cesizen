<script setup lang="ts">
import { update } from '@/actions/App/Http/Controllers/Settings/ProfileController'
import PasswordController from '@/actions/App/Http/Controllers/Settings/PasswordController'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import Layout from '@/layouts/Authenticated.vue'
import { send } from '@/routes/verification'
import { Head, Form } from '@inertiajs/vue3'

defineOptions({ layout: Layout })

defineProps<{
  mustVerifyEmail: boolean
  status?: string
}>()

const auth = useAuth()

const profile = reactive({
  name: auth.value.user.name,
  email: auth.value.user.email,
})

const form = useForm({
  name: '',
  email: '',
})

const toast = useToast()

async function onSubmit(e: Event) {
  e.preventDefault()
  form.name = profile.name
  form.email = profile.email
  form.submit(update())

  toast.add({
    title: 'Succès',
    description: 'Votre profil a été mis à jour.',
    icon: 'i-lucide-check',
    color: 'success',
  })
}

function handlePasswordSuccess() {
  toast.add({
    title: 'Succès',
    description: 'Votre mot de passe a été mis à jour.',
    icon: 'i-lucide-check',
    color: 'success',
  })
}
</script>

<template>
  <div class="container mx-auto p-6 max-w-4xl space-y-8">
    <Head title="Paramètres" />

    <div>
      <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Paramètres</h1>
      <p class="text-muted-foreground">Gérez les paramètres et préférences de votre compte</p>
    </div>

    <!-- Profile Section -->
    <form @submit="onSubmit" class="space-y-6">
      <Card class="border-0 shadow-lg">
        <CardHeader>
          <CardTitle class="text-xl">Informations du Profil</CardTitle>
          <CardDescription>Mettez à jour les informations de votre profil et votre adresse e-mail.</CardDescription>
        </CardHeader>
        <CardContent class="space-y-6">
          <div class="space-y-2">
            <Label for="name">Nom</Label>
            <Input 
              id="name"
              v-model="profile.name" 
              autocomplete="off"
              placeholder="Votre nom complet"
              required
            />
            <p class="text-sm text-muted-foreground">
              C'est votre nom d'affichage public.
            </p>
          </div>

          <Separator />

          <div class="space-y-2">
            <Label for="email">Adresse e-mail</Label>
            <Input 
              id="email"
              v-model="profile.email" 
              type="email"
              autocomplete="off"
              placeholder="email@exemple.com"
              required
            />
            <p class="text-sm text-muted-foreground">
              Utilisée pour la connexion et recevoir des notifications.
            </p>
            
            <div v-if="mustVerifyEmail && !auth.user.email_verified_at" class="mt-2">
              <p class="text-sm text-muted-foreground">
                Votre adresse e-mail n'est pas vérifiée.
                <Link :href="send()" class="font-medium text-green-600 hover:text-green-700 hover:underline">
                  Cliquez ici pour renvoyer l'e-mail de vérification.
                </Link>
              </p>
            </div>

            <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
              Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
            </div>
          </div>

          <div class="flex justify-end">
            <Button type="submit" :disabled="form.processing" class="bg-green-500 hover:bg-green-600">
              Enregistrer les Modifications
            </Button>
          </div>
        </CardContent>
      </Card>
    </form>

    <!-- Password Section -->
    <Card class="border-0 shadow-lg">
      <CardHeader>
        <CardTitle class="text-xl">Changer le Mot de Passe</CardTitle>
        <CardDescription>Assurez-vous que votre compte utilise un mot de passe robuste pour rester sécurisé.</CardDescription>
      </CardHeader>
      <CardContent>
        <Form
          v-bind="PasswordController.update.form()"
          :options="{
            preserveScroll: true,
          }"
          reset-on-success
          :reset-on-error="['password', 'password_confirmation', 'current_password']"
          class="space-y-4 max-w-md"
          v-slot="{ errors, processing }"
          @success="handlePasswordSuccess"
        >
          <div class="space-y-2">
            <Label for="current_password">Mot de Passe Actuel</Label>
            <Input 
              id="current_password" 
              name="current_password" 
              type="password" 
              placeholder="••••••••"
              autocomplete="current-password"
            />
            <p v-if="errors.current_password" class="text-sm text-destructive">{{ errors.current_password }}</p>
          </div>

          <div class="space-y-2">
            <Label for="password">Nouveau Mot de Passe</Label>
            <Input 
              id="password" 
              name="password" 
              type="password" 
              placeholder="••••••••"
              autocomplete="new-password"
            />
            <p v-if="errors.password" class="text-sm text-destructive">{{ errors.password }}</p>
            <p class="text-xs text-muted-foreground">Doit contenir au moins 8 caractères</p>
          </div>

          <div class="space-y-2">
            <Label for="password_confirmation">Confirmer le Mot de Passe</Label>
            <Input 
              id="password_confirmation" 
              name="password_confirmation" 
              type="password" 
              placeholder="••••••••"
              autocomplete="new-password"
            />
            <p v-if="errors.password_confirmation" class="text-sm text-destructive">{{ errors.password_confirmation }}</p>
          </div>

          <Button type="submit" :disabled="processing" class="bg-green-500 hover:bg-green-600">
            Mettre à Jour le Mot de Passe
          </Button>
        </Form>
      </CardContent>
    </Card>

    <!-- Delete Account Section -->
    <Card class="border-0 shadow-lg bg-gradient-to-br from-red-50 to-orange-50 dark:from-red-900/10 dark:to-orange-900/10">
      <CardHeader>
        <CardTitle class="text-xl text-red-700 dark:text-red-400">Supprimer le Compte</CardTitle>
        <CardDescription>
          Supprimez définitivement votre compte et toutes ses données. Cette action est irréversible.
        </CardDescription>
      </CardHeader>
      <CardContent>
        <DeleteAccount />
      </CardContent>
    </Card>
  </div>
</template>
