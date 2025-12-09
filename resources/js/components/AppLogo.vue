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
    <div class="bg-sidebar-primary text-sidebar-primary-foreground flex aspect-square size-8 items-center justify-center rounded-md">
      <AppLogoIcon class="size-5 fill-current text-white dark:text-black" />
    </div>
    <div class="grid flex-1 text-left text-sm">
      <span class="truncate leading-tight font-semibold">Cesizen</span>
    </div>
  </div>
</template>
