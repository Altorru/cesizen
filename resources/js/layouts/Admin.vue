<script setup lang="ts">
import type { NavigationMenuItem } from '@nuxt/ui'

const page = usePage()
const user = computed(() => page.props.auth.user)

const open = ref(false)

const adminLinks = computed(() => {
  return [
    [
      {
        label: 'Dashboard',
        icon: 'i-lucide-layout-dashboard',
        to: '/admin',
        onSelect: () => {
          open.value = false
        },
      },
    ],
    [
      {
        label: 'Content',
        icon: 'i-lucide-file-text',
        type: 'trigger',
        defaultOpen: true,
        children: [
          {
            label: 'All Articles',
            to: '/admin/content-pages',
            icon: 'i-lucide-list',
            onSelect: () => {
              open.value = false
            },
          },
          {
            label: 'New Article',
            to: '/admin/content-pages/create',
            icon: 'i-lucide-plus-circle',
            onSelect: () => {
              open.value = false
            },
          },
        ],
      },
    ],
    [
      {
        label: 'Users',
        icon: 'i-lucide-users',
        to: '/admin/users',
        onSelect: () => {
          open.value = false
        },
      },
    ],
    [
      {
        label: 'Back to Site',
        icon: 'i-lucide-arrow-left',
        to: '/',
        onSelect: () => {
          open.value = false
        },
      },
    ],
  ] satisfies NavigationMenuItem[][]
})

const groups = computed(() => [
  {
    id: 'admin',
    label: 'Admin Navigation',
    items: adminLinks.value.flat(),
  },
])
</script>

<template>
  <Suspense>
    <UApp>
      <UDashboardGroup unit="rem" storage="local">
        <!-- Admin Sidebar -->
        <UDashboardSidebar
          id="admin-sidebar"
          v-model:open="open"
          collapsible
          resizable
          class="bg-elevated/25"
          :ui="{ footer: 'lg:border-t lg:border-default' }"
        >
          <template #header="{ collapsed }">
            <div class="flex items-center gap-2 px-3 py-4 border-b">
              <UIcon v-if="collapsed" name="i-lucide-shield" class="size-8 text-green-600" />
              <div v-else class="flex items-center gap-2">
                <UIcon name="i-lucide-shield" class="size-6 text-green-600" />
                <span class="font-bold text-lg">Admin Panel</span>
              </div>
            </div>
          </template>

          <template #default="{ collapsed }">
            <UDashboardSearchButton :collapsed="collapsed" class="bg-transparent ring-default" />

            <UNavigationMenu 
              v-for="(links, index) in adminLinks" 
              :key="index"
              :collapsed="collapsed" 
              :items="links" 
              orientation="vertical" 
              tooltip 
              popover 
              :class="index === adminLinks.length - 1 ? 'mt-auto' : ''"
            />
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
