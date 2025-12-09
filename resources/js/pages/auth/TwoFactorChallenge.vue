<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { store } from '@/routes/two-factor/login'
import { Form, Head } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const authConfigContent = computed<{
  title: string
  description: string
  toggleText: string
}>(() => {
  if (showRecoveryInput.value) {
    return {
      title: 'Recovery Code',
      description: 'Please confirm access to your account by entering one of your emergency recovery codes.',
      toggleText: 'login using an authentication code',
    }
  }

  return {
    title: 'Authentication Code',
    description: 'Enter the authentication code provided by your authenticator application.',
    toggleText: 'login using a recovery code',
  }
})

const showRecoveryInput = ref<boolean>(false)

function toggleRecoveryMode(clearErrors: () => void) {
  showRecoveryInput.value = !showRecoveryInput.value
  clearErrors()
  code.value = ''
}

const code = ref<string>('')
</script>

<template>
  <AuthLayout :title="authConfigContent.title" :description="authConfigContent.description">
    <Head title="Two-Factor Authentication" />

    <div class="space-y-6">
      <template v-if="!showRecoveryInput">
        <Form v-bind="store.form()" class="space-y-4" reset-on-error @error="code = ''" #default="{ errors, processing, clearErrors }">
          <input type="hidden" name="code" :value="code" />

          <div class="space-y-2">
            <Label for="code">Authentication Code</Label>
            <Input 
              id="code"
              v-model="code" 
              type="text" 
              placeholder="000000" 
              maxlength="6"
              class="text-center text-2xl tracking-widest" 
              autofocus 
              required
            />
            <p v-if="errors.code" class="text-sm text-destructive text-center">{{ errors.code }}</p>
          </div>

          <Button type="submit" :disabled="processing" class="w-full">Continue</Button>

          <div class="text-center text-sm text-muted-foreground">
            <span>or you can </span>
            <button
              type="button"
              class="text-primary underline underline-offset-4 hover:text-primary/80"
              @click="() => toggleRecoveryMode(clearErrors)"
            >
              {{ authConfigContent.toggleText }}
            </button>
          </div>
        </Form>
      </template>

      <template v-else>
        <Form v-bind="store.form()" class="space-y-4" reset-on-error #default="{ errors, processing, clearErrors }">
          <div class="space-y-2">
            <Label for="recovery_code">Recovery Code</Label>
            <Input 
              id="recovery_code"
              name="recovery_code"
              type="text" 
              placeholder="Enter recovery code" 
              :autofocus="showRecoveryInput" 
              required 
            />
            <p v-if="errors.recovery_code" class="text-sm text-destructive">{{ errors.recovery_code }}</p>
          </div>

          <Button type="submit" :disabled="processing" class="w-full">Continue</Button>

          <div class="text-center text-sm text-muted-foreground">
            <span>or you can </span>
            <button
              type="button"
              class="text-primary underline underline-offset-4 hover:text-primary/80"
              @click="() => toggleRecoveryMode(clearErrors)"
            >
              {{ authConfigContent.toggleText }}
            </button>
          </div>
        </Form>
      </template>
    </div>
  </AuthLayout>
</template>
