<script setup lang="ts">
import { update } from '@/actions/App/Http/Controllers/Settings/ProfileController'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Separator } from '@/components/ui/separator'
import Layout from '@/layouts/Default.vue'
import SettingsLayout from '@/layouts/SettingsLayout.vue'
import { send } from '@/routes/verification'
import { Head } from '@inertiajs/vue3'

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
    description: 'Your settings have been updated.',
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
  <SettingsLayout>
    <Head title="Profile settings" />

    <form @submit="onSubmit" class="space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-2xl font-bold">Profile</h2>
          <p class="text-muted-foreground">These informations will be displayed publicly.</p>
        </div>
        <Button type="submit" :disabled="form.processing">Save changes</Button>
      </div>

      <Card>
        <CardContent class="pt-6 space-y-6">
          <div class="space-y-2">
            <Label for="name">Name</Label>
            <Input 
              id="name"
              v-model="profile.name" 
              autocomplete="off"
              required
            />
            <p class="text-sm text-muted-foreground">
              Will appear on receipts, invoices, and other communication.
            </p>
          </div>

          <Separator />

          <div class="space-y-2">
            <Label for="email">Email</Label>
            <Input 
              id="email"
              v-model="profile.email" 
              type="email"
              autocomplete="off"
              required
            />
            <p class="text-sm text-muted-foreground">
              Used to sign in, for email receipts and product updates.
            </p>
            
            <div v-if="mustVerifyEmail && !auth.user.email_verified_at" class="mt-2">
              <p class="text-sm text-muted-foreground">
                Your email address is unverified.
                <Link :href="send()" class="font-medium text-primary hover:underline">
                  Click here to resend the verification email.
                </Link>
              </p>
            </div>

            <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
              A new verification link has been sent to your email address.
            </div>
          </div>

          <Separator />

          <div class="space-y-2">
            <Label>Avatar</Label>
            <div class="flex items-center gap-4">
              <Avatar class="h-20 w-20">
                <AvatarImage v-if="profile.avatar" :src="profile.avatar" :alt="profile.name" />
                <AvatarFallback>{{ getInitials(profile.name) }}</AvatarFallback>
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
        </CardContent>
      </Card>
    </form>
  </SettingsLayout>
</template>
