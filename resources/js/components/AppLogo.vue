<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue'
import type { HTMLAttributes } from 'vue'

defineOptions({
  inheritAttrs: false,
})

interface Props {
  class?: HTMLAttributes['class']
}

defineProps<Props>()
</script>

<template>
  <div :class="$props.class" class="flex items-center gap-2">
    <div class="bg-sidebar-primary text-sidebar-primary-foreground flex aspect-square size-8 items-center justify-center rounded-md overflow-hidden">
      <img src="/images/logo.png" alt="CESIZen Logo" class="size-full object-contain p-1" />
    </div>
    <div class="grid flex-1 text-left text-sm">
      <span class="truncate leading-tight font-semibold">CESIZen</span>
    </div>
  </div>
</template>
