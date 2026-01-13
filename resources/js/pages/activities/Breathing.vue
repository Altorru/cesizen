<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import Authenticated from '@/layouts/Authenticated.vue'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'

interface BreathingPattern {
  name: string
  code: string
  inhale: number
  hold: number
  exhale: number
  description: string
  color: string
}

const patterns: BreathingPattern[] = [
  {
    name: 'Relaxation Profonde',
    code: '7-4-8',
    inhale: 7,
    hold: 4,
    exhale: 8,
    description: 'Idéal pour la détente et réduire le stress',
    color: 'from-blue-400 to-blue-600'
  },
  {
    name: 'Cohérence Cardiaque',
    code: '5-5',
    inhale: 5,
    hold: 0,
    exhale: 5,
    description: 'Équilibre émotionnel et clarté mentale',
    color: 'from-green-400 to-green-600'
  },
  {
    name: 'Calme Rapide',
    code: '4-6',
    inhale: 4,
    hold: 0,
    exhale: 6,
    description: 'Apaisement rapide en quelques minutes',
    color: 'from-purple-400 to-purple-600'
  }
]

const selectedPattern = ref<BreathingPattern | null>(null)
const isActive = ref(false)
const currentPhase = ref<'inhale' | 'hold' | 'exhale'>('inhale')
const countdown = ref(0)
const cycleCount = ref(0)
const totalCycles = ref(5)

let intervalId: ReturnType<typeof setInterval> | null = null

const phaseText = computed(() => {
  switch (currentPhase.value) {
    case 'inhale':
      return 'Inspirez'
    case 'hold':
      return 'Retenez'
    case 'exhale':
      return 'Expirez'
  }
})

const phaseColor = computed(() => {
  if (!selectedPattern.value) return 'from-gray-400 to-gray-600'
  return selectedPattern.value.color
})

const circleScale = computed(() => {
  if (!isActive.value || !selectedPattern.value) return 1
  
  const pattern = selectedPattern.value
  const totalTime = currentPhase.value === 'inhale' 
    ? pattern.inhale 
    : currentPhase.value === 'hold' 
    ? pattern.hold 
    : pattern.exhale
  
  const progress = 1 - (countdown.value / totalTime)
  
  if (currentPhase.value === 'inhale') {
    return 1 + progress * 0.8 // Grandit de 1 à 1.8
  } else if (currentPhase.value === 'hold') {
    return 1.8 // Reste grand
  } else {
    return 1.8 - progress * 0.8 // Rétrécit de 1.8 à 1
  }
})

function selectPattern(pattern: BreathingPattern) {
  if (isActive.value) {
    stopExercise()
  }
  selectedPattern.value = pattern
}

function startExercise() {
  if (!selectedPattern.value) return
  
  isActive.value = true
  cycleCount.value = 0
  currentPhase.value = 'inhale'
  countdown.value = selectedPattern.value.inhale
  
  intervalId = setInterval(() => {
    if (!selectedPattern.value) return
    
    countdown.value--
    
    if (countdown.value <= 0) {
      // Passer à la phase suivante
      if (currentPhase.value === 'inhale') {
        if (selectedPattern.value.hold > 0) {
          currentPhase.value = 'hold'
          countdown.value = selectedPattern.value.hold
        } else {
          currentPhase.value = 'exhale'
          countdown.value = selectedPattern.value.exhale
        }
      } else if (currentPhase.value === 'hold') {
        currentPhase.value = 'exhale'
        countdown.value = selectedPattern.value.exhale
      } else {
        // Fin d'un cycle
        cycleCount.value++
        
        if (cycleCount.value >= totalCycles.value) {
          stopExercise()
          return
        }
        
        currentPhase.value = 'inhale'
        countdown.value = selectedPattern.value.inhale
      }
    }
  }, 1000)
}

function stopExercise() {
  isActive.value = false
  if (intervalId) {
    clearInterval(intervalId)
    intervalId = null
  }
  currentPhase.value = 'inhale'
  countdown.value = 0
  cycleCount.value = 0
}

onUnmounted(() => {
  if (intervalId) {
    clearInterval(intervalId)
  }
})
</script>

<template>
  <Authenticated>
    <Head title="Exercice de Respiration" />

    <div class="min-h-screen p-8">
      <div class="mx-auto max-w-6xl space-y-8">
        <!-- Header -->
        <div class="text-center space-y-3">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-blue-100 to-green-100 dark:from-blue-900/30 dark:to-green-900/30">
            <UIcon name="i-lucide-wind" class="h-8 w-8 text-blue-600 dark:text-blue-400" />
          </div>
          <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-green-500 dark:from-blue-400 dark:to-green-400 bg-clip-text text-transparent">
            Exercice de Respiration
          </h1>
          <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
            Pratiquez la cohérence cardiaque pour réduire le stress et améliorer votre bien-être
          </p>
        </div>

        <!-- Sélection du pattern (masqué pendant l'exercice) -->
        <div v-if="!isActive" class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <Card
            v-for="pattern in patterns"
            :key="pattern.code"
            :class="[
              'cursor-pointer transition-all hover:shadow-xl hover:-translate-y-1',
              selectedPattern?.code === pattern.code 
                ? 'ring-2 ring-green-500 dark:ring-green-400 shadow-lg' 
                : 'hover:ring-2 hover:ring-gray-300 dark:hover:ring-gray-700'
            ]"
            @click="selectPattern(pattern)"
          >
            <CardHeader>
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <CardTitle class="text-xl mb-2">{{ pattern.name }}</CardTitle>
                  <CardDescription class="text-sm">{{ pattern.description }}</CardDescription>
                </div>
                <div 
                  :class="[
                    'w-12 h-12 rounded-full flex items-center justify-center bg-gradient-to-br',
                    pattern.color
                  ]"
                >
                  <span class="text-white font-bold text-sm">{{ pattern.code }}</span>
                </div>
              </div>
            </CardHeader>
            <CardContent>
              <div class="space-y-2 text-sm">
                <div class="flex justify-between items-center">
                  <span class="text-gray-600 dark:text-gray-400">Inspiration</span>
                  <span class="font-semibold">{{ pattern.inhale }}s</span>
                </div>
                <div v-if="pattern.hold > 0" class="flex justify-between items-center">
                  <span class="text-gray-600 dark:text-gray-400">Apnée</span>
                  <span class="font-semibold">{{ pattern.hold }}s</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-gray-600 dark:text-gray-400">Expiration</span>
                  <span class="font-semibold">{{ pattern.exhale }}s</span>
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Zone d'exercice -->
        <div v-if="selectedPattern" class="flex flex-col items-center space-y-8">
          <!-- Cercle animé -->
          <div class="relative w-80 h-80 flex items-center justify-center">
            <!-- Cercle de fond -->
            <div class="absolute inset-0 rounded-full bg-gray-100 dark:bg-gray-800/50 opacity-30"></div>
            
            <!-- Cercle animé -->
            <div
              :class="[
                'absolute rounded-full bg-gradient-to-br shadow-2xl transition-all duration-1000 ease-in-out flex items-center justify-center',
                phaseColor
              ]"
              :style="{
                width: `${circleScale * 200}px`,
                height: `${circleScale * 200}px`,
                opacity: isActive ? 0.9 : 0.6
              }"
            >
              <div class="text-center text-white">
                <div class="text-4xl font-bold mb-2">{{ countdown || (isActive ? '' : 'Prêt') }}</div>
                <div class="text-lg font-medium">{{ isActive ? phaseText : selectedPattern.name }}</div>
              </div>
            </div>

            <!-- Anneaux décoratifs -->
            <div 
              v-if="isActive"
              class="absolute inset-0 rounded-full border-4 border-white/20 animate-ping"
              style="animation-duration: 3s;"
            ></div>
          </div>

          <!-- Compteur de cycles -->
          <div v-if="isActive" class="text-center">
            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Cycle</div>
            <div class="text-2xl font-bold">{{ cycleCount + 1 }} / {{ totalCycles }}</div>
          </div>

          <!-- Contrôles -->
          <div class="flex gap-4">
            <Button
              v-if="!isActive"
              @click="startExercise"
              size="lg"
              class="px-8 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white shadow-lg hover:shadow-xl transition-all"
            >
              <UIcon name="i-lucide-play" class="mr-2 h-5 w-5" />
              Commencer
            </Button>
            <Button
              v-else
              @click="stopExercise"
              size="lg"
              variant="destructive"
              class="px-8 shadow-lg hover:shadow-xl transition-all"
            >
              <UIcon name="i-lucide-square" class="mr-2 h-5 w-5" />
              Arrêter
            </Button>
            
            <Button
              v-if="!isActive && selectedPattern"
              @click="selectedPattern = null"
              size="lg"
              variant="outline"
            >
              Changer d'exercice
            </Button>
          </div>

          <!-- Instructions -->
          <Card v-if="!isActive" class="max-w-2xl w-full bg-blue-50/50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800">
            <CardContent class="pt-6">
              <div class="space-y-3">
                <div class="flex items-start gap-3">
                  <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
                  <div>
                    <div class="font-semibold text-gray-900 dark:text-white">Installez-vous confortablement</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Asseyez-vous dans un endroit calme, le dos droit</div>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
                  <div>
                    <div class="font-semibold text-gray-900 dark:text-white">Suivez le cercle</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Le cercle grandit quand vous inspirez, rétrécit quand vous expirez</div>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">3</div>
                  <div>
                    <div class="font-semibold text-gray-900 dark:text-white">Respirez naturellement</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Laissez votre respiration s'adapter au rythme</div>
                  </div>
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        <!-- Message de sélection -->
        <div v-else class="text-center py-12">
          <UIcon name="i-lucide-hand-helping" class="h-16 w-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" />
          <p class="text-lg text-gray-600 dark:text-gray-400">
            Sélectionnez un exercice pour commencer
          </p>
        </div>
      </div>
    </div>
  </Authenticated>
</template>
