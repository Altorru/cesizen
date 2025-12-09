<script setup lang="ts">
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController'
import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Form } from '@inertiajs/vue3'

const open = ref(false)
const passwordInput = ref<HTMLInputElement>()
</script>

<template>
  <Dialog v-model:open="open">
    <DialogTrigger as-child>
      <Button variant="destructive">Delete account</Button>
    </DialogTrigger>
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle>Are you sure you want to delete your account?</DialogTitle>
        <DialogDescription>
          Once your account is deleted, all of its resources and data will also be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
        </DialogDescription>
      </DialogHeader>
      <Form
        v-bind="ProfileController.destroy.form()"
        reset-on-success
        @error="() => passwordInput?.focus()"
        :options="{
          preserveScroll: true,
        }"
        class="space-y-4"
        v-slot="{ errors, processing, reset, clearErrors }"
      >
        <div class="space-y-2">
          <Label for="password">Password</Label>
          <Input 
            ref="passwordInput"
            id="password" 
            name="password" 
            type="password" 
            placeholder="Password" 
          />
          <p v-if="errors.password" class="text-sm text-destructive">{{ errors.password }}</p>
        </div>
        <DialogFooter>
          <Button
            type="button"
            variant="outline"
            @click="
              () => {
                clearErrors()
                reset()
                open = false
              }
            "
          >
            Cancel
          </Button>
          <Button variant="destructive" type="submit" :disabled="processing">
            Delete Account
          </Button>
        </DialogFooter>
      </Form>
    </DialogContent>
  </Dialog>
</template>
