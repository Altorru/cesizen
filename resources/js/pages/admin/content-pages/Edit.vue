<script setup lang="ts">
import AdminLayout from '@/layouts/Admin.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import { Checkbox } from '@/components/ui/checkbox'
import { Link, useForm } from '@inertiajs/vue3'

defineOptions({ layout: AdminLayout })

interface ContentPage {
  id: string
  title: string
  slug: string
  content: string
  is_published: boolean
  published_at: string | null
}

interface Props {
  page: ContentPage
}

const props = defineProps<Props>()

const form = useForm({
  title: props.page.title,
  slug: props.page.slug,
  content: props.page.content,
  is_published: Boolean(props.page.is_published),
})

const generateSlug = () => {
  if (form.title) {
    form.slug = form.title
      .toLowerCase()
      .replace(/[^\w\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-')
      .trim()
  }
}

const submit = () => {
  form.put(`/admin/content-pages/${props.page.id}`, {
    preserveScroll: true,
  })
}
</script>

<template>
  <UDashboardPanel id="admin-content-pages-edit">
    <template #header>
      <UDashboardNavbar title="Edit Content Page">
        <template #leading>
          <UDashboardSidebarCollapse as="button" :disabled="false" />
        </template>
      </UDashboardNavbar>
    </template>

    <template #body>
      <div class="p-6">
        <div class="max-w-3xl mx-auto">
          <!-- Header -->
          <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
              Edit Page
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
              Update the information for this content page.
            </p>
          </div>

          <!-- Form -->
          <Card>
            <CardHeader>
              <CardTitle>Page Details</CardTitle>
              <CardDescription>
                Modify the content and settings of your page.
              </CardDescription>
            </CardHeader>
            <CardContent>
              <form @submit.prevent="submit" class="space-y-6">
                <!-- Title -->
                <div class="space-y-2">
                  <Label for="title">Title *</Label>
                  <Input
                    id="title"
                    v-model="form.title"
                    type="text"
                    placeholder="About CESIZen"
                    required
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
                      placeholder="about-cesizen"
                      required
                    />
                    <Button
                      type="button"
                      variant="outline"
                      @click="generateSlug"
                    >
                      Generate
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
                  <Label for="content">Content *</Label>
                  <Textarea
                    id="content"
                    v-model="form.content"
                    rows="12"
                    placeholder="Enter your content here. You can use Markdown formatting."
                    required
                  />
                  <p class="text-xs text-gray-500 dark:text-gray-400">
                    Supports Markdown formatting
                  </p>
                  <p v-if="form.errors.content" class="text-sm text-red-500">
                    {{ form.errors.content }}
                  </p>
                </div>

                <!-- Published Status -->
                <div class="space-y-2">
                  <div class="flex items-center space-x-2">
                    <Checkbox
                      id="is_published"
                      :checked="Boolean(form.is_published)"
                      @update:checked="(value) => { form.is_published = Boolean(value) }"
                    />
                    <Label
                      for="is_published"
                      class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 cursor-pointer"
                    >
                      Published
                    </Label>
                  </div>
                  <p class="text-xs text-gray-500 dark:text-gray-400">
                    Status: <span :class="form.is_published ? 'text-green-600 font-medium' : 'text-gray-600'">{{ form.is_published ? '✓ Published' : '○ Draft' }}</span>
                  </p>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-4 border-t">
                  <Link href="/admin/content-pages">
                    <Button
                      type="button"
                      variant="outline"
                      :disabled="form.processing"
                    >
                      Cancel
                    </Button>
                  </Link>
                  <Button type="submit" :disabled="form.processing">
                    <UIcon
                      v-if="form.processing"
                      name="i-lucide-loader-2"
                      class="mr-2 h-4 w-4 animate-spin"
                    />
                    <UIcon v-else name="i-lucide-save" class="mr-2 h-4 w-4" />
                    Save Changes
                  </Button>
                </div>
              </form>
            </CardContent>
          </Card>
        </div>
      </div>
    </template>
  </UDashboardPanel>
</template>
