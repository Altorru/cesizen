<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import Authenticated from '@/layouts/Authenticated.vue'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Badge } from '@/components/ui/badge'
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'

interface User {
  id: number
  name: string
  email: string
  role: 'user' | 'admin'
  is_active: boolean
  created_at: string
}

interface Props {
  users: {
    data: User[]
    links: any[]
    current_page: number
    last_page: number
  }
  filters: {
    search?: string
    role?: string
    status?: string
  }
}

const props = defineProps<Props>()

const search = ref(props.filters.search || '')
const roleFilter = ref(props.filters.role || '')
const statusFilter = ref(props.filters.status || '')

function applyFilters() {
  router.get('/admin/users', {
    search: search.value,
    role: roleFilter.value,
    status: statusFilter.value,
  }, {
    preserveState: true,
    replace: true,
  })
}

function resetFilters() {
  search.value = ''
  roleFilter.value = ''
  statusFilter.value = ''
  router.get('/admin/users')
}

function toggleStatus(userId: number) {
  if (confirm('Êtes-vous sûr de vouloir modifier le statut de cet utilisateur ?')) {
    router.post(`/admin/users/${userId}/toggle-status`, {}, {
      preserveScroll: true,
      onSuccess: () => {
        router.reload({ only: ['users'] })
      }
    })
  }
}

function deleteUser(userId: number, userName: string) {
  if (confirm(`Êtes-vous sûr de vouloir supprimer l'utilisateur "${userName}" ? Cette action est irréversible.`)) {
    router.delete(`/admin/users/${userId}`)
  }
}

function formatDate(date: string) {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  })
}
</script>

<template>
  <Authenticated>
    <Head title="Gestion des Utilisateurs" />

    <div class="min-h-screen p-8">
      <div class="mx-auto max-w-7xl space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-blue-500 dark:from-green-400 dark:to-blue-400 bg-clip-text text-transparent">
              Gestion des Utilisateurs
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
              Gérez les comptes utilisateurs de la plateforme
            </p>
          </div>
          <Link href="/admin/users/create">
            <Button class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 shadow-lg">
              <UIcon name="i-lucide-user-plus" class="mr-2 h-4 w-4" />
              Nouvel Utilisateur
            </Button>
          </Link>
        </div>

        <!-- Filters -->
        <Card>
          <CardHeader>
            <CardTitle>Filtres</CardTitle>
          </CardHeader>
          <CardContent>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
              <div>
                <Input
                  v-model="search"
                  placeholder="Rechercher par nom ou email..."
                  @keyup.enter="applyFilters"
                />
              </div>
              <div>
                <Select v-model="roleFilter">
                  <SelectTrigger>
                    <SelectValue placeholder="Tous les rôles" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="">Tous les rôles</SelectItem>
                    <SelectItem value="user">Utilisateur</SelectItem>
                    <SelectItem value="admin">Admin</SelectItem>
                  </SelectContent>
                </Select>
              </div>
              <div>
                <Select v-model="statusFilter">
                  <SelectTrigger>
                    <SelectValue placeholder="Tous les statuts" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="">Tous les statuts</SelectItem>
                    <SelectItem value="active">Actif</SelectItem>
                    <SelectItem value="inactive">Inactif</SelectItem>
                  </SelectContent>
                </Select>
              </div>
              <div class="flex gap-2">
                <Button @click="applyFilters" variant="outline" class="flex-1">
                  <UIcon name="i-lucide-search" class="mr-2 h-4 w-4" />
                  Rechercher
                </Button>
                <Button @click="resetFilters" variant="outline">
                  <UIcon name="i-lucide-x" class="h-4 w-4" />
                </Button>
              </div>
            </div>
          </CardContent>
        </Card>

        <!-- Users Table -->
        <Card>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Nom</TableHead>
                <TableHead>Email</TableHead>
                <TableHead>Rôle</TableHead>
                <TableHead>Statut</TableHead>
                <TableHead>Date de création</TableHead>
                <TableHead class="text-right">Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-if="users.data.length === 0">
                <TableCell colspan="6" class="text-center py-8 text-gray-500">
                  Aucun utilisateur trouvé
                </TableCell>
              </TableRow>
              <TableRow v-for="user in users.data" :key="user.id">
                <TableCell class="font-medium">{{ user.name }}</TableCell>
                <TableCell>{{ user.email }}</TableCell>
                <TableCell>
                  <Badge :variant="user.role === 'admin' ? 'default' : 'secondary'">
                    {{ user.role === 'admin' ? 'Admin' : 'Utilisateur' }}
                  </Badge>
                </TableCell>
                <TableCell>
                  <Badge :variant="user.is_active ? 'default' : 'destructive'">
                    {{ user.is_active ? 'Actif' : 'Inactif' }}
                  </Badge>
                </TableCell>
                <TableCell>{{ formatDate(user.created_at) }}</TableCell>
                <TableCell class="text-right">
                  <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                      <Button variant="ghost" size="sm">
                        <UIcon name="i-lucide-more-vertical" class="h-4 w-4" />
                      </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                      <DropdownMenuItem @click="router.visit(`/admin/users/${user.id}/edit`)" class="cursor-pointer">
                        <UIcon name="i-lucide-pencil" class="mr-2 h-4 w-4" />
                        Modifier
                      </DropdownMenuItem>
                      <DropdownMenuItem @click="toggleStatus(user.id)" class="cursor-pointer">
                        <UIcon :name="user.is_active ? 'i-lucide-user-x' : 'i-lucide-user-check'" class="mr-2 h-4 w-4" />
                        {{ user.is_active ? 'Désactiver' : 'Activer' }}
                      </DropdownMenuItem>
                      <DropdownMenuItem 
                        @click="deleteUser(user.id, user.name)" 
                        class="cursor-pointer text-red-600 dark:text-red-400"
                      >
                        <UIcon name="i-lucide-trash-2" class="mr-2 h-4 w-4" />
                        Supprimer
                      </DropdownMenuItem>
                    </DropdownMenuContent>
                  </DropdownMenu>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>

          <!-- Pagination -->
          <div v-if="users.last_page > 1" class="p-4 border-t flex items-center justify-between">
            <div class="text-sm text-gray-600 dark:text-gray-400">
              Page {{ users.current_page }} sur {{ users.last_page }}
            </div>
            <div class="flex gap-2">
              <Link
                v-for="link in users.links"
                :key="link.label"
                :href="link.url"
                :class="[
                  'px-3 py-2 text-sm rounded-md transition-colors',
                  link.active
                    ? 'bg-green-500 text-white'
                    : link.url
                    ? 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300'
                    : 'opacity-50 cursor-not-allowed text-gray-400'
                ]"
                v-html="link.label"
              />
            </div>
          </div>
        </Card>
      </div>
    </div>
  </Authenticated>
</template>
