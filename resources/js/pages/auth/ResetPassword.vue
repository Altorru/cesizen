<script setup lang="ts">
import NewPasswordController from '@/actions/App/Http/Controllers/Auth/NewPasswordController'
import AuthCard from '@/components/AuthCard.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import Layout from '@/layouts/Empty.vue'
import { Form, Head } from '@inertiajs/vue3'
import { ref } from 'vue'

defineOptions({ layout: Layout })

const props = defineProps<{
  token: string
  email: string
}>()

const inputEmail = ref(props.email)
</script>

<template>
  <AuthCard title="Reset password" description="Enter your new password below">
    <Head title="Reset password" />

    <Form
      v-bind="NewPasswordController.store.form()"
      :transform="(data) => ({ ...data, token, email })"
      :reset-on-success="['password', 'password_confirmation']"
      v-slot="{ errors, processing }"
      class="space-y-6"
    >
      <div class="space-y-4">
        <div class="space-y-2">
          <Label for="email">Email address</Label>
          <Input 
            id="email"
            name="email"
            type="email" 
            autocomplete="email" 
            readonly 
            v-model="inputEmail"
            class="bg-gray-50 dark:bg-gray-900" 
          />
          <p v-if="errors.email" class="text-sm text-destructive">{{ errors.email }}</p>
        </div>

        <div class="space-y-2">
          <Label for="password">New password</Label>
          <Input 
            id="password"
            name="password"
            type="password" 
            autocomplete="new-password" 
            placeholder="••••••••" 
            required 
          />
          <p v-if="errors.password" class="text-sm text-destructive">{{ errors.password }}</p>
          <p class="text-xs text-muted-foreground">Must be at least 8 characters</p>
        </div>

        <div class="space-y-2">
          <Label for="password_confirmation">Confirm password</Label>
          <Input 
            id="password_confirmation"
            name="password_confirmation"
            type="password" 
            autocomplete="new-password" 
            placeholder="••••••••" 
            required 
          />
          <p v-if="errors.password_confirmation" class="text-sm text-destructive">{{ errors.password_confirmation }}</p>
        </div>

        <Button type="submit" :disabled="processing" class="w-full">Reset Password</Button>
      </div>
    </Form>
  </AuthCard>
</template>
