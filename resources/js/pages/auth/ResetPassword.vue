<script setup lang="ts">
import NewPasswordController from '@/actions/App/Http/Controllers/Auth/NewPasswordController'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { Form, Head } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{
  token: string
  email: string
}>()

const inputEmail = ref(props.email)
</script>

<template>
  <AuthLayout title="Reset password" description="Please enter your new password below">
    <Head title="Reset password" />

    <Form
      v-bind="NewPasswordController.store.form()"
      :transform="(data) => ({ ...data, token, email })"
      :reset-on-success="['password', 'password_confirmation']"
      v-slot="{ errors, processing }"
    >
      <div class="grid gap-6">
        <div class="space-y-2">
          <Label for="email">Email</Label>
          <Input 
            id="email"
            name="email"
            type="email" 
            autocomplete="email" 
            readonly 
            v-model="inputEmail" 
          />
          <p v-if="errors.email" class="text-sm text-destructive">{{ errors.email }}</p>
        </div>

        <div class="space-y-2">
          <Label for="password">Password</Label>
          <Input 
            id="password"
            name="password"
            type="password" 
            autocomplete="new-password" 
            placeholder="Password" 
            required 
          />
          <p v-if="errors.password" class="text-sm text-destructive">{{ errors.password }}</p>
        </div>

        <div class="space-y-2">
          <Label for="password_confirmation">Confirm Password</Label>
          <Input 
            id="password_confirmation"
            name="password_confirmation"
            type="password" 
            autocomplete="new-password" 
            placeholder="Confirm password" 
            required 
          />
          <p v-if="errors.password_confirmation" class="text-sm text-destructive">{{ errors.password_confirmation }}</p>
        </div>

        <Button type="submit" :disabled="processing" class="mt-4 w-full">Reset Password</Button>
      </div>
    </Form>
  </AuthLayout>
</template>
