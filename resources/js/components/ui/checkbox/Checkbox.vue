<script setup lang="ts">
import { CheckIcon } from '@radix-icons/vue'
import { CheckboxIndicator, CheckboxRoot, type CheckboxRootEmits, type CheckboxRootProps } from 'reka-ui'
import { cn } from '@/lib/utils'

const props = defineProps<CheckboxRootProps & { class?: string }>()
const emits = defineEmits<CheckboxRootEmits>()

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props
  return delegated
})
</script>

<template>
  <CheckboxRoot
    v-bind="delegatedProps"
    :class="
      cn(
        'peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground',
        props.class
      )
    "
    @update:checked="(v) => emits('update:checked', v)"
  >
    <CheckboxIndicator class="flex h-full w-full items-center justify-center text-current">
      <CheckIcon class="h-4 w-4" />
    </CheckboxIndicator>
  </CheckboxRoot>
</template>
