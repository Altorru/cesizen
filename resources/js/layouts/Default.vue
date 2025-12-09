<script setup lang="ts">
  import type { NavigationMenuItem } from '@nuxt/ui'

  const { url } = usePage()
  const toast = useToast()

  const open = ref(false)

  const links = [
    [
      {
        label: 'Dashboard',
        icon: 'i-lucide-house',
        to: '/dashboard',
        onSelect: () => {
          open.value = false
        },
      },
      {
        label: 'Settings',
        to: '/settings',
        icon: 'i-lucide-settings',
        defaultOpen: true,
        type: 'trigger',
        children: [
          {
            label: 'Profile',
            to: '/settings/profile',
            exact: true,
            onSelect: () => {
              open.value = false
            },
          },
          {
            label: 'Security',
            to: '/settings/security',
            onSelect: () => {
              open.value = false
            },
          },
        ],
      },
    ],
    [
      {
        label: 'Help & Support',
        icon: 'i-lucide-info',
        to: 'https://laravel.com/docs',
        target: '_blank',
      },
    ],
  ] satisfies NavigationMenuItem[][]

  const groups = computed(() => [
    {
      id: 'links',
      label: 'Go to',
      items: links.flat(),
    },
  ])

  const cookie = useStorage('cookie-consent', 'pending')
  if (cookie.value !== 'accepted') {
    toast.add({
      title: 'We use first-party cookies to enhance your experience on our website.',
      duration: 0,
      close: false,
      actions: [
        {
          label: 'Accept',
          color: 'neutral',
          variant: 'outline',
          onClick: () => {
            cookie.value = 'accepted'
          },
        },
        {
          label: 'Opt out',
          color: 'neutral',
          variant: 'ghost',
        },
      ],
    })
  }
</script>

<template>
  <Suspense>
    <UApp>
      <UDashboardGroup unit="rem" storage="local">
        <UDashboardSidebar
          id="default"
          v-model:open="open"
          collapsible
          resizable
          class="bg-elevated/25"
          :ui="{ footer: 'lg:border-t lg:border-default' }"
        >
          <template #header="{ collapsed }">
            <div class="flex items-center gap-2 px-3 py-4">
              <AppLogoIcon v-if="collapsed" class="size-8" />
              <AppLogo v-else class="h-8" />
            </div>
          </template>

          <template #default="{ collapsed }">
            <UDashboardSearchButton :collapsed="collapsed" class="bg-transparent ring-default" />

            <UNavigationMenu :collapsed="collapsed" :items="links[0]" orientation="vertical" tooltip popover />

            <UNavigationMenu :collapsed="collapsed" :items="links[1]" orientation="vertical" tooltip class="mt-auto" />
          </template>

          <template #footer="{ collapsed }">
            <UserMenu :collapsed="collapsed" />
          </template>
        </UDashboardSidebar>

        <UDashboardSearch :groups="groups" />

        <slot />
      </UDashboardGroup>
    </UApp>
  </Suspense>
</template>
