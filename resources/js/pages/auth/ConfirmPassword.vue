<script setup lang="ts">
import AuthCard from '@/components/AuthCard.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import Layout from '@/layouts/Empty.vue'
import { store } from '@/routes/password/confirm'
import { Form, Head } from '@inertiajs/vue3'

defineOptions({ layout: Layout })
</script>

<template>
  <AuthCard title="Confirm your password" description="This is a secure area. Please confirm your password to continue.">
    <Head title="Confirm password" />

    <Form v-bind="store.form()" reset-on-success v-slot="{ errors, processing }" class="space-y-6">
      <div class="space-y-4">
        <div class="space-y-2">
          <Label for="password">Password</Label>
          <Input 
            id="password"
            name="password"
            type="password" 
            autocomplete="current-password"
            placeholder="••••••••" 
            autofocus 
            required 
          />
          <p v-if="errors.password" class="text-sm text-destructive">{{ errors.password }}</p>
        </div>

        <Button type="submit" :disabled="processing" class="w-full">Confirm</Button>
      </div>
    </Form>
  </AuthCard>
</template>
