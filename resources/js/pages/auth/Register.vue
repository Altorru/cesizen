<script setup lang="ts">
import { store } from '@/actions/App/Http/Controllers/Auth/RegisteredUserController'
import AuthCard from '@/components/AuthCard.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import Layout from '@/layouts/Empty.vue'
import { login } from '@/routes'
import { Head, Link, router } from '@inertiajs/vue3'

defineOptions({ layout: Layout })

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const errors = ref<Record<string, string>>({})

router.on('error', (event) => {
  errors.value = getErrors(event.detail.errors)
})

function onSubmit(e: Event) {
  e.preventDefault()
  errors.value = {}
  form.password_confirmation = form.password
  form.submit(store())
  form.reset('password', 'password_confirmation')
}
</script>

<template>
  <AuthCard title="Create an account" description="Start your wellness journey today">
    <Head title="Register" />

    <form @submit="onSubmit" class="space-y-6">
      <div class="space-y-4">
        <div class="space-y-2">
          <Label for="name">Full name</Label>
          <Input 
            id="name"
            v-model="form.name"
            type="text" 
            placeholder="John Doe"
            autofocus
            required 
          />
          <p v-if="errors.name" class="text-sm text-destructive">{{ errors.name }}</p>
        </div>

        <div class="space-y-2">
          <Label for="email">Email address</Label>
          <Input 
            id="email"
            v-model="form.email"
            type="email" 
            placeholder="email@example.com"
            required 
          />
          <p v-if="errors.email" class="text-sm text-destructive">{{ errors.email }}</p>
        </div>

        <div class="space-y-2">
          <Label for="password">Password</Label>
          <Input 
            id="password"
            v-model="form.password"
            type="password" 
            placeholder="••••••••"
            required 
          />
          <p v-if="errors.password" class="text-sm text-destructive">{{ errors.password }}</p>
          <p class="text-xs text-muted-foreground">Must be at least 8 characters</p>
        </div>

        <Button :disabled="form.processing" type="submit" class="w-full">
          Create account
        </Button>
      </div>

      <div class="text-center text-sm text-muted-foreground">
        Already have an account?
        <Link :href="login()" class="text-primary hover:underline font-medium">
          Log in
        </Link>
      </div>
    </form>
  </AuthCard>
</template>
