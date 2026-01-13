<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import Authenticated from '@/layouts/Authenticated.vue'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { Switch } from '@/components/ui/switch'

interface User {
  id: number
  name: string
  email: string
  role: 'user' | 'admin'
  is_active: boolean
}

const props = defineProps<{
  user: User
}>()

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  password: '',
  password_confirmation: '',
  role: props.user.role,
  is_active: props.user.is_active,
})

const toast = useToast()

function onSubmit(e: Event) {
  e.preventDefault()
  
  form.put(`/admin/users/${props.user.id}`, {
    onSuccess: () => {
      toast.add({
        title: 'Succès',
        description: 'Utilisateur mis à jour avec succès.',
        icon: 'i-lucide-check',
        color: 'success',
      })
    },
    onError: (errors) => {
      toast.add({
        title: 'Erreur',
        description: 'Veuillez corriger les erreurs du formulaire.',
        icon: 'i-lucide-alert-circle',
        color: 'error',
      })
    }
  })
}
</script>

<template>
  <Authenticated>
    <Head :title="`Modifier ${user.name}`" />

    <div class="min-h-screen p-8">
      <div class="mx-auto max-w-3xl space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
          <Link href="/admin/users">
            <Button variant="ghost" size="icon">
              <UIcon name="i-lucide-arrow-left" class="h-5 w-5" />
            </Button>
          </Link>
          <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-blue-500 dark:from-green-400 dark:to-blue-400 bg-clip-text text-transparent">
              Modifier l'Utilisateur
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
              {{ user.name }}
            </p>
          </div>
        </div>

        <!-- Form -->
        <form @submit="onSubmit">
          <Card>
            <CardHeader>
              <CardTitle>Informations de l'Utilisateur</CardTitle>
              <CardDescription>
                Modifiez les informations de l'utilisateur
              </CardDescription>
            </CardHeader>
            <CardContent class="space-y-6">
              <!-- Name -->
              <div class="space-y-2">
                <Label for="name">Nom complet *</Label>
                <Input
                  id="name"
                  v-model="form.name"
                  type="text"
                  placeholder="Jean Dupont"
                  :class="{ 'border-red-500': form.errors.name }"
                  required
                />
                <p v-if="form.errors.name" class="text-sm text-red-500">
                  {{ form.errors.name }}
                </p>
              </div>

              <!-- Email -->
              <div class="space-y-2">
                <Label for="email">Email *</Label>
                <Input
                  id="email"
                  v-model="form.email"
                  type="email"
                  placeholder="jean.dupont@exemple.fr"
                  :class="{ 'border-red-500': form.errors.email }"
                  required
                />
                <p v-if="form.errors.email" class="text-sm text-red-500">
                  {{ form.errors.email }}
                </p>
              </div>

              <!-- Password -->
              <div class="space-y-2">
                <Label for="password">Nouveau mot de passe</Label>
                <Input
                  id="password"
                  v-model="form.password"
                  type="password"
                  placeholder="••••••••"
                  :class="{ 'border-red-500': form.errors.password }"
                />
                <p class="text-sm text-gray-500">Laisser vide pour conserver le mot de passe actuel</p>
                <p v-if="form.errors.password" class="text-sm text-red-500">
                  {{ form.errors.password }}
                </p>
              </div>

              <!-- Password Confirmation -->
              <div v-if="form.password" class="space-y-2">
                <Label for="password_confirmation">Confirmer le mot de passe</Label>
                <Input
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  type="password"
                  placeholder="••••••••"
                />
              </div>

              <!-- Role -->
              <div class="space-y-2">
                <Label for="role">Rôle *</Label>
                <Select v-model="form.role">
                  <SelectTrigger id="role" :class="{ 'border-red-500': form.errors.role }">
                    <SelectValue placeholder="Sélectionner un rôle" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="user">
                      <div class="flex items-center gap-2">
                        <UIcon name="i-lucide-user" class="h-4 w-4" />
                        Utilisateur
                      </div>
                    </SelectItem>
                    <SelectItem value="admin">
                      <div class="flex items-center gap-2">
                        <UIcon name="i-lucide-shield" class="h-4 w-4" />
                        Administrateur
                      </div>
                    </SelectItem>
                  </SelectContent>
                </Select>
                <p v-if="form.errors.role" class="text-sm text-red-500">
                  {{ form.errors.role }}
                </p>
              </div>

              <!-- Active Status -->
              <div :class="[
                'flex items-center justify-between rounded-lg border-2 p-4 transition-all hover:shadow-md',
                form.is_active 
                  ? 'bg-gradient-to-br from-green-50 to-blue-50 dark:from-green-950/20 dark:to-blue-950/20 border-green-200 dark:border-green-800'
                  : 'bg-gradient-to-br from-red-50 to-orange-50 dark:from-red-950/20 dark:to-orange-950/20 border-red-200 dark:border-red-800'
              ]">
                <div class="space-y-0.5 flex-1">
                  <Label for="is_active" class="text-base font-semibold text-gray-900 dark:text-white cursor-pointer flex items-center gap-2">
                    <span v-if="form.is_active">🟢 Compte actif</span>
                    <span v-else>🔴 Compte désactivé</span>
                  </Label>
                  <p class="text-sm" :class="form.is_active ? 'text-gray-600 dark:text-gray-400' : 'text-red-600 dark:text-red-400'">
                    {{ form.is_active ? 'L\'utilisateur peut se connecter' : 'Désactiver empêche l\'utilisateur de se connecter' }}
                  </p>
                </div>
                <Switch
                  id="is_active"
                  v-model:checked="form.is_active"
                  class="scale-125"
                />
              </div>

              <!-- Actions -->
              <div class="flex justify-end gap-3 pt-4">
                <Link href="/admin/users">
                  <Button type="button" variant="outline">
                    Annuler
                  </Button>
                </Link>
                <Button
                  type="submit"
                  :disabled="form.processing"
                  class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700"
                >
                  <UIcon v-if="!form.processing" name="i-lucide-save" class="mr-2 h-4 w-4" />
                  <UIcon v-else name="i-lucide-loader-2" class="mr-2 h-4 w-4 animate-spin" />
                  {{ form.processing ? 'Enregistrement...' : 'Enregistrer les Modifications' }}
                </Button>
              </div>
            </CardContent>
          </Card>
        </form>
      </div>
    </div>
  </Authenticated>
</template>
