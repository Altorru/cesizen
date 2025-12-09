<script setup lang="ts">
import PasswordResetLinkController from '@/actions/App/Http/Controllers/Auth/PasswordResetLinkController'
import AuthCard from '@/components/AuthCard.vue'
import TextLink from '@/components/TextLink.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import Layout from '@/layouts/Empty.vue'
import { login } from '@/routes'
import { Form, Head } from '@inertiajs/vue3'

defineOptions({ layout: Layout })

defineProps<{
  status?: string
}>()
</script>

<template>
  <AuthCard title="Forgot password" description="Enter your email to receive a password reset link">
    <Head title="Forgot password" />

    <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
      {{ status }}
    </div>

    <div class="space-y-6">
      <Form v-bind="PasswordResetLinkController.store.form()" v-slot="{ errors, processing }">
        <div class="space-y-2">
          <Label for="email">Email address</Label>
          <Input 
            id="email"
            name="email" 
            type="email" 
            autocomplete="off" 
            placeholder="email@example.com" 
            autofocus 
            required 
          />
          <p v-if="errors.email" class="text-sm text-destructive">{{ errors.email }}</p>
        </div>

        <div class="my-6 flex items-center justify-start">
          <Button type="submit" :disabled="processing" class="w-full">Send Reset Link</Button>
        </div>
      </Form>

      <div class="text-muted-foreground space-x-1 text-center text-sm">
        <span class="text-muted-foreground">Or, return to</span>
        <TextLink :href="login()" class="text-sm font-medium text-primary">log in</TextLink>
      </div>
    </div>
  </AuthCard>
</template>
