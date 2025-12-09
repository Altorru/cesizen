<script setup lang="ts">
import { update } from '@/actions/App/Http/Controllers/Settings/ProfileController'
import PasswordController from '@/actions/App/Http/Controllers/Settings/PasswordController'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Separator } from '@/components/ui/separator'
import Layout from '@/layouts/Authenticated.vue'
import { send } from '@/routes/verification'
import { Head, Form } from '@inertiajs/vue3'

defineOptions({ layout: Layout })

defineProps<{
  mustVerifyEmail: boolean
  status?: string
}>()

const fileRef = ref<HTMLInputElement>()
const auth = useAuth()

const profile = reactive({
  name: auth.value.user.name,
  email: auth.value.user.email,
  avatar: undefined as string | undefined,
})

const form = useForm({
  name: '',
  email: '',
  avatar: undefined as string | undefined,
})

const toast = useToast()

async function onSubmit(e: Event) {
  e.preventDefault()
  form.name = profile.name
  form.email = profile.email
  form.avatar = profile.avatar
  form.submit(update())

  toast.add({
    title: 'Success',
    description: 'Your profile has been updated.',
    icon: 'i-lucide-check',
    color: 'success',
  })
}

function handlePasswordSuccess() {
  toast.add({
    title: 'Success',
    description: 'Your password has been updated.',
    icon: 'i-lucide-check',
    color: 'success',
  })
}

function onFileChange(e: Event) {
  const input = e.target as HTMLInputElement
  if (!input.files?.length) return
  profile.avatar = URL.createObjectURL(input.files[0])
}

function onFileClick() {
  fileRef.value?.click()
}

function getInitials(name: string) {
  return name
    .split(' ')
    .map(n => n[0])
    .join('')
    .toUpperCase()
    .slice(0, 2)
}
</script>

<template>
  <div class="container mx-auto p-6 max-w-4xl space-y-8">
    <Head title="Settings" />

    <div>
      <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Settings</h1>
      <p class="text-muted-foreground">Manage your account settings and preferences</p>
    </div>

    <!-- Profile Section -->
    <form @submit="onSubmit" class="space-y-6">
      <Card class="border-0 shadow-lg">
        <CardHeader>
          <CardTitle class="text-xl">Profile Information</CardTitle>
          <CardDescription>Update your account's profile information and email address.</CardDescription>
        </CardHeader>
        <CardContent class="space-y-6">
          <div class="space-y-2">
            <Label for="name">Name</Label>
            <Input 
              id="name"
              v-model="profile.name" 
              autocomplete="off"
              placeholder="Your full name"
              required
            />
            <p class="text-sm text-muted-foreground">
              This is your public display name.
            </p>
          </div>

          <Separator />

          <div class="space-y-2">
            <Label for="email">Email address</Label>
            <Input 
              id="email"
              v-model="profile.email" 
              type="email"
              autocomplete="off"
              placeholder="email@example.com"
              required
            />
            <p class="text-sm text-muted-foreground">
              Used to sign in and receive notifications.
            </p>
            
            <div v-if="mustVerifyEmail && !auth.user.email_verified_at" class="mt-2">
              <p class="text-sm text-muted-foreground">
                Your email address is unverified.
                <Link :href="send()" class="font-medium text-primary hover:underline">
                  Click here to resend the verification email.
                </Link>
              </p>
            </div>

            <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
              A new verification link has been sent to your email address.
            </div>
          </div>

          <Separator />

          <div class="space-y-2">
            <Label>Avatar</Label>
            <div class="flex items-center gap-4">
              <Avatar class="h-20 w-20 border-2 border-gray-200 dark:border-gray-800">
                <AvatarImage v-if="profile.avatar" :src="profile.avatar" :alt="profile.name" />
                <AvatarFallback class="text-lg">{{ getInitials(profile.name) }}</AvatarFallback>
              </Avatar>
              <div>
                <Button type="button" variant="outline" @click="onFileClick">
                  Choose file
                </Button>
                <p class="text-sm text-muted-foreground mt-1">JPG, GIF or PNG. 1MB Max.</p>
                <input 
                  ref="fileRef" 
                  type="file" 
                  class="hidden" 
                  accept=".jpg, .jpeg, .png, .gif" 
                  @change="onFileChange" 
                />
              </div>
            </div>
          </div>

          <div class="flex justify-end">
            <Button type="submit" :disabled="form.processing">
              Save Changes
            </Button>
          </div>
        </CardContent>
      </Card>
    </form>

    <!-- Password Section -->
    <Card class="border-0 shadow-lg">
      <CardHeader>
        <CardTitle class="text-xl">Change Password</CardTitle>
        <CardDescription>Ensure your account is using a strong password to stay secure.</CardDescription>
      </CardHeader>
      <CardContent>
        <Form
          v-bind="PasswordController.update.form()"
          :options="{
            preserveScroll: true,
          }"
          reset-on-success
          :reset-on-error="['password', 'password_confirmation', 'current_password']"
          class="space-y-4 max-w-md"
          v-slot="{ errors, processing }"
          @success="handlePasswordSuccess"
        >
          <div class="space-y-2">
            <Label for="current_password">Current Password</Label>
            <Input 
              id="current_password" 
              name="current_password" 
              type="password" 
              placeholder="••••••••"
              autocomplete="current-password"
            />
            <p v-if="errors.current_password" class="text-sm text-destructive">{{ errors.current_password }}</p>
          </div>

          <div class="space-y-2">
            <Label for="password">New Password</Label>
            <Input 
              id="password" 
              name="password" 
              type="password" 
              placeholder="••••••••"
              autocomplete="new-password"
            />
            <p v-if="errors.password" class="text-sm text-destructive">{{ errors.password }}</p>
            <p class="text-xs text-muted-foreground">Must be at least 8 characters</p>
          </div>

          <div class="space-y-2">
            <Label for="password_confirmation">Confirm Password</Label>
            <Input 
              id="password_confirmation" 
              name="password_confirmation" 
              type="password" 
              placeholder="••••••••"
              autocomplete="new-password"
            />
            <p v-if="errors.password_confirmation" class="text-sm text-destructive">{{ errors.password_confirmation }}</p>
          </div>

          <Button type="submit" :disabled="processing">
            Update Password
          </Button>
        </Form>
      </CardContent>
    </Card>

    <!-- Delete Account Section -->
    <Card class="border-0 shadow-lg bg-gradient-to-br from-red-50 to-orange-50 dark:from-red-900/10 dark:to-orange-900/10">
      <CardHeader>
        <CardTitle class="text-xl text-red-700 dark:text-red-400">Delete Account</CardTitle>
        <CardDescription>
          Permanently delete your account and all of its data. This action cannot be undone.
        </CardDescription>
      </CardHeader>
      <CardContent>
        <DeleteAccount />
      </CardContent>
    </Card>
  </div>
</template>
