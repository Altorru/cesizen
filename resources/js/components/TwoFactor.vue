<script setup lang="ts">
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { disable } from '@/routes/two-factor'
import { Form } from '@inertiajs/vue3'
import { ShieldBan } from 'lucide-vue-next'

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

const { clearTwoFactorAuthData } = useTwoFactorAuth()

onUnmounted(() => {
  clearTwoFactorAuthData()
})
</script>

<template>
  <Card class="mb-6">
    <CardHeader>
      <CardTitle>Two-Factor Authentication</CardTitle>
      <CardDescription>Manage your two-factor authentication settings</CardDescription>
    </CardHeader>
    <CardContent>
      <div v-if="!twoFactorEnabled" class="flex flex-col items-start justify-start space-y-4">
        <Badge variant="destructive">Disabled</Badge>
        <p class="text-muted-foreground">
          When you enable two-factor authentication, you will be prompted for a secure pin during login. This pin can be retrieved from a TOTP-supported
          application on your phone.
        </p>
        <div>
          <TwoFactorSetupModal :requiresConfirmation="requiresConfirmation" :twoFactorEnabled="twoFactorEnabled" />
        </div>
      </div>

      <div v-else class="flex flex-col items-start justify-start space-y-4">
        <Badge>Enabled</Badge>

        <p class="text-muted-foreground">
          With two-factor authentication enabled, you will be prompted for a secure, random pin during login, which you can retrieve from the
          TOTP-supported application on your phone.
        </p>

        <TwoFactorRecoveryCodes />

        <div class="relative inline">
          <Form v-bind="disable.form()" #default="{ processing }">
            <Button variant="destructive" type="submit" :disabled="processing">
              <ShieldBan class="mr-2 h-4 w-4" />
              Disable 2FA
            </Button>
          </Form>
        </div>
      </div>
    </CardContent>
  </Card>
</template>
