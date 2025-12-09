<script setup lang="ts">
import { Avatar, AvatarFallback } from '@/components/ui/avatar'
import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { confirm, enable } from '@/routes/two-factor'
import { Form } from '@inertiajs/vue3'
import { Copy, CopyCheck, Loader2, ScanLine, ShieldCheck } from 'lucide-vue-next'

const props = defineProps<{
  requiresConfirmation: boolean
  twoFactorEnabled: boolean
}>()

const open = ref(false)
const { copy, copied } = useClipboard()
const { hasSetupData, qrCodeSvg, manualSetupKey, clearSetupData, fetchSetupData, errors } = useTwoFactorAuth()

const showVerificationStep = ref(false)
const code = ref('')

const modalConfig = computed<{
  title: string
  description: string
  buttonText: string
}>(() => {
  if (props.twoFactorEnabled) {
    return {
      title: 'Two-Factor Authentication Enabled',
      description: 'Two-factor authentication is now enabled. Scan the QR code or enter the setup key in your authenticator app.',
      buttonText: 'Close',
    }
  }

  if (showVerificationStep.value) {
    return {
      title: 'Verify Authentication Code',
      description: 'Enter the 6-digit code from your authenticator app',
      buttonText: 'Continue',
    }
  }

  return {
    title: 'Enable Two-Factor Authentication',
    description: 'To finish enabling two-factor authentication, scan the QR code or enter the setup key in your authenticator app',
    buttonText: 'Continue',
  }
})

function handleModalNextStep() {
  if (props.requiresConfirmation) {
    showVerificationStep.value = true
    return
  }

  clearSetupData()
  open.value = false
}

function resetModalState() {
  if (props.twoFactorEnabled) {
    clearSetupData()
  }

  showVerificationStep.value = false
  code.value = ''
}

async function handleUpdateOpen() {
  if (!qrCodeSvg.value) {
    await fetchSetupData()
  }
}
</script>

<template>
  <Dialog v-model:open="open" @update:open="handleUpdateOpen">
    <DialogTrigger as-child>
      <Button v-if="hasSetupData">
        <ShieldCheck class="mr-2 h-4 w-4" />
        Continue Setup
      </Button>
      <Form v-else v-bind="enable.form()" #default="{ processing }">
        <Button type="submit" :disabled="processing">
          <ShieldCheck class="mr-2 h-4 w-4" />
          Enable 2FA
        </Button>
      </Form>
    </DialogTrigger>
    <DialogContent class="sm:max-w-md" @escape-key-down="resetModalState" @pointer-down-outside="resetModalState">
      <DialogHeader>
        <div class="mt-4 flex flex-col items-center justify-center gap-2 text-center">
          <Avatar class="h-16 w-16">
            <AvatarFallback>
              <ScanLine class="h-8 w-8" />
            </AvatarFallback>
          </Avatar>
          <DialogTitle>{{ modalConfig.title }}</DialogTitle>
          <DialogDescription>{{ modalConfig.description }}</DialogDescription>
        </div>
      </DialogHeader>

      <div class="relative flex w-auto flex-col items-center justify-center space-y-5">
        <template v-if="!showVerificationStep">
          <AlertError v-if="errors?.length" :errors="errors" />
          <template v-else>
            <div class="relative mx-auto flex max-w-md items-center overflow-hidden">
              <div class="relative mx-auto aspect-square w-64 overflow-hidden rounded-lg border border-border">
                <div
                  v-if="!qrCodeSvg"
                  class="absolute inset-0 z-10 flex aspect-square h-auto w-full animate-pulse items-center justify-center bg-background"
                >
                  <Loader2 class="h-6 w-6 animate-spin" />
                </div>
                <div v-else class="relative z-10 overflow-hidden border border-border p-5">
                  <div v-html="qrCodeSvg" class="flex aspect-square size-full items-center justify-center" />
                </div>
              </div>
            </div>

            <div class="flex w-full items-center space-x-5">
              <Button @click="handleModalNextStep" class="w-full">
                {{ modalConfig.buttonText }}
              </Button>
            </div>

            <div class="relative flex w-full items-center justify-center">
              <div class="absolute inset-0 top-1/2 h-px w-full bg-border" />
              <span class="bg-background relative px-2 py-1 text-sm text-muted-foreground">or, enter the code manually</span>
            </div>

            <div class="flex w-full items-center justify-center space-x-2">
              <div class="flex w-full items-stretch gap-2">
                <div v-if="!manualSetupKey" class="flex h-full w-full items-center justify-center bg-background p-3">
                  <Loader2 class="h-4 w-4 animate-spin" />
                </div>
                <template v-else>
                  <Input v-model="manualSetupKey" class="flex-1" readonly />
                  <Button
                    :variant="copied ? 'default' : 'outline'"
                    size="icon"
                    @click="copy(manualSetupKey)"
                  >
                    <component :is="copied ? CopyCheck : Copy" class="h-4 w-4" />
                  </Button>
                </template>
              </div>
            </div>
          </template>
        </template>

        <template v-else>
          <Form v-bind="confirm.form()" reset-on-error @finish="code = ''" @success="open = false" v-slot="{ errors, processing }">
            <input type="hidden" name="code" :value="code" />
            <div class="relative w-full space-y-8">
              <div class="space-y-2">
                <Label for="code" class="text-center block">Authentication Code</Label>
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
                <p v-if="errors?.confirmTwoFactorAuthentication?.code" class="text-sm text-destructive text-center">
                  {{ errors.confirmTwoFactorAuthentication.code }}
                </p>
              </div>

              <div class="flex w-full items-center space-x-5">
                <Button
                  variant="outline"
                  class="flex-1"
                  @click="showVerificationStep = false"
                  :disabled="processing"
                >
                  Back
                </Button>
                <Button
                  type="submit"
                  class="flex-1"
                  :disabled="processing || code.length < 6"
                >
                  Confirm
                </Button>
              </div>
            </div>
          </Form>
        </template>
      </div>
    </DialogContent>
  </Dialog>
</template>
