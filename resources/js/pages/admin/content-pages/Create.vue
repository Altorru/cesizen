<script setup lang="ts">
import AdminLayout from '@/layouts/Authenticated.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import { Switch } from '@/components/ui/switch'
import { Link, useForm } from '@inertiajs/vue3'

defineOptions({ layout: AdminLayout })

const form = useForm({
  title: '',
  slug: '',
  content: '',
  is_published: false,
})

const generateSlug = () => {
  if (form.title && !form.slug) {
    form.slug = form.title
      .toLowerCase()
      .replace(/[^\w\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-')
      .trim()
  }
}

const submit = () => {
  form.post('/admin/content-pages', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    },
  })
}
</script>

<template>
  <div class="p-6 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
        Créer une nouvelle page
      </h1>
      <p class="text-gray-600 dark:text-gray-400">
        Ajouter une nouvelle page d'information à votre application.
      </p>
    </div>

    <!-- Form -->
    <Card>
      <CardHeader>
        <CardTitle>Détails de la page</CardTitle>
        <CardDescription>
          Remplissez les informations de votre page de contenu.
        </CardDescription>
      </CardHeader>
      <CardContent>
        <form @submit.prevent="submit" class="space-y-6">
                <!-- Title -->
                <div class="space-y-2">
                  <Label for="title">Titre *</Label>
                  <Input
                    id="title"
                    v-model="form.title"
                    type="text"
                    placeholder="À propos de CESIZen"
                    required
                    @blur="generateSlug"
                  />
                  <p v-if="form.errors.title" class="text-sm text-red-500">
                    {{ form.errors.title }}
                  </p>
                </div>

                <!-- Slug -->
                <div class="space-y-2">
                  <Label for="slug">Slug *</Label>
                  <div class="flex gap-2">
                    <Input
                      id="slug"
                      v-model="form.slug"
                      type="text"
                      placeholder="a-propos-de-cesizen"
                      required
                    />
                    <Button
                      type="button"
                      variant="outline"
                      @click="generateSlug"
                    >
                      Générer
                    </Button>
                  </div>
                  <p class="text-xs text-gray-500 dark:text-gray-400">
                    URL: /{{ form.slug || 'slug' }}
                  </p>
                  <p v-if="form.errors.slug" class="text-sm text-red-500">
                    {{ form.errors.slug }}
                  </p>
                </div>

                <!-- Content -->
                <div class="space-y-2">
                  <Label for="content">Contenu *</Label>
                  <Textarea
                    id="content"
                    v-model="form.content"
                    rows="12"
                    placeholder="Entrez votre contenu ici. Vous pouvez utiliser le formatage Markdown."
                    required
                  />
                  <p class="text-xs text-gray-500 dark:text-gray-400">
                    Supporte le formatage Markdown
                  </p>
                  <p v-if="form.errors.content" class="text-sm text-red-500">
                    {{ form.errors.content }}
                  </p>
                </div>

                <!-- Published Status -->
                <div class="flex items-center justify-between rounded-lg border-2 p-4 bg-gradient-to-br from-green-50 to-blue-50 dark:from-green-950/20 dark:to-blue-950/20 border-green-200 dark:border-green-800">
                  <div class="flex-1">
                    <Label for="is_published" class="text-base font-semibold cursor-pointer">
                      Publier l'article
                    </Label>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                      <span v-if="form.is_published">✅ Sera publié</span>
                      <span v-else>📄 Sera en brouillon</span>
                    </p>
                  </div>
                  <Switch
                    id="is_published"
                    v-model:checked="form.is_published"
                    class="scale-125"
                  />
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-4 border-t">
                  <Link href="/admin/content-pages">
                    <Button
                      type="button"
                      variant="outline"
                      :disabled="form.processing"
                    >
                      Annuler
                    </Button>
                  </Link>
                  <Button type="submit" :disabled="form.processing">
                    <UIcon
                      v-if="form.processing"
                      name="i-lucide-loader-2"
                      class="mr-2 h-4 w-4 animate-spin"
                    />
                    <UIcon v-else name="i-lucide-save" class="mr-2 h-4 w-4" />
                    Créer la page
                  </Button>
        </div>
      </form>
    </CardContent>
  </Card>
  </div>
</template>
