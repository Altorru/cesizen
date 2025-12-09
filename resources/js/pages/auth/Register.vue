<script setup lang="ts">
import { store } from '@/actions/App/Http/Controllers/Auth/RegisteredUserController'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import Layout from '@/layouts/AuthBasic.vue'
import { login } from '@/routes'
import { Head, router } from '@inertiajs/vue3'

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
  <div>
    <Head title="Register" />

    <div class="mx-auto max-w-md space-y-6">
      <div class="space-y-2 text-center">
        <h1 class="text-3xl font-bold">Create an account</h1>
        <p class="text-muted-foreground">
          Already have an account? 
          <Link :href="login()" class="font-medium text-primary hover:underline">
            Login
          </Link>
        </p>
      </div>

      <form @submit="onSubmit" class="space-y-4">
        <div class="space-y-2">
          <Label for="name">Name</Label>
          <Input 
            id="name"
            v-model="form.name"
            type="text" 
            placeholder="Full name"
            required 
          />
          <p v-if="errors.name" class="text-sm text-destructive">{{ errors.name }}</p>
        </div>

        <div class="space-y-2">
          <Label for="email">Email</Label>
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
            placeholder="Password"
            required 
          />
          <p v-if="errors.password" class="text-sm text-destructive">{{ errors.password }}</p>
        </div>

        <Button :disabled="form.processing" type="submit" class="w-full">
          Create account
        </Button>
      </form>

      <div class="text-center text-sm text-muted-foreground">
        By signing up, you agree to our 
        <Link href="/" class="font-medium text-primary hover:underline">
          Terms of Service
        </Link>
      </div>
    </div>
  </div>
</template>
