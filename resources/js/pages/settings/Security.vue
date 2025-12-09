<script setup lang="ts">
import PasswordController from '@/actions/App/Http/Controllers/Settings/PasswordController'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import Layout from '@/layouts/Default.vue'
import SettingsLayout from '@/layouts/SettingsLayout.vue'
import { Form, Head } from '@inertiajs/vue3'

defineOptions({ layout: Layout })

withDefaults(
  defineProps<{
    requiresConfirmation?: boolean
    twoFactorEnabled?: boolean
  }>(),
  {
    requiresConfirmation: false,
    twoFactorEnabled: false,
  },
)

const toast = useToast()

function handleSuccess() {
  toast.add({
    title: 'Success',
    description: 'Your password has been updated.',
    icon: 'i-lucide-check',
    color: 'success',
  })
}
</script>

<template>
  <SettingsLayout>
    <Head title="Security settings" />

    <Card class="mb-6">
      <CardHeader>
        <CardTitle>Password</CardTitle>
        <CardDescription>Confirm your current password before setting a new one.</CardDescription>
      </CardHeader>
      <CardContent>
        <Form
          v-bind="PasswordController.update.form()"
          :options="{
            preserveScroll: true,
          }"
          reset-on-success
          :reset-on-error="['password', 'password_confirmation', 'current_password']"
          class="flex max-w-xs flex-col gap-4"
          v-slot="{ errors, processing }"
          @success="handleSuccess"
        >
          <div class="space-y-2">
            <Label for="current_password">Current Password</Label>
            <Input id="current_password" name="current_password" type="password" placeholder="Current password" />
            <p v-if="errors.current_password" class="text-sm text-destructive">{{ errors.current_password }}</p>
          </div>

          <div class="space-y-2">
            <Label for="password">New Password</Label>
            <Input id="password" name="password" type="password" placeholder="New password" />
            <p v-if="errors.password" class="text-sm text-destructive">{{ errors.password }}</p>
          </div>

          <div class="space-y-2">
            <Label for="password_confirmation">Confirm Password</Label>
            <Input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm password" />
            <p v-if="errors.password_confirmation" class="text-sm text-destructive">{{ errors.password_confirmation }}</p>
          </div>

          <Button type="submit" :disabled="processing" class="w-fit">Update</Button>
        </Form>
      </CardContent>
    </Card>

    <TwoFactor :requiresConfirmation="requiresConfirmation" :twoFactorEnabled="twoFactorEnabled" />

    <Card class="mt-6 border-destructive/50 bg-destructive/5">
      <CardHeader>
        <CardTitle>Delete Account</CardTitle>
        <CardDescription>
          No longer want to use our service? You can delete your account here. This action is not reversible. All information related to this account will be deleted permanently.
        </CardDescription>
      </CardHeader>
      <CardContent>
        <DeleteAccount />
      </CardContent>
    </Card>
  </SettingsLayout>
</template>
