<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, Users, FolderOpen, BarChart3, ShoppingCart, Truck, CreditCard, Calendar, CheckSquare, Star, FileText } from 'lucide-vue-next';
import { ref } from 'vue';
import AppLogo from './AppLogo.vue';

const darkMode = ref(false);

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Clientes',
        href: '/clientes',
        icon: Users,
    },
    {
        title: 'Proyectos',
        href: '/proyectos',
        icon: FolderOpen,
    },
    {
        title: 'Cotizaciones',
        href: '/cotizaciones',
        icon: BarChart3,
    },
    {
        title: 'Diseños',
        href: '/disenos',
        icon: ShoppingCart,
    },
    {
        title: 'Productos',
        href: '/productos',
        icon: FileText,
    },
    {
        title: 'Proveedores',
        href: '/proveedores',
        icon: Truck,
    },
    {
        title: 'Plan Pagos',
        href: '/plan-pagos',
        icon: CreditCard,
    },
    {
        title: 'Pagos',
        href: '/pagos',
        icon: CreditCard,
    },
    {
        title: 'Cronogramas',
        href: '/cronogramas',
        icon: Calendar,
    },
    {
        title: 'Tareas',
        href: '/tareas',
        icon: CheckSquare,
    },
    {
        title: 'Evaluaciones',
        href: '/evaluacion-servicios',
        icon: Star,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];

const toggleDarkMode = () => {
    darkMode.value = !darkMode.value;
    if (darkMode.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
};

// Initialize dark mode from localStorage
if (typeof localStorage !== 'undefined') {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        darkMode.value = true;
        document.documentElement.classList.add('dark');
    }
}
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <div class="p-4 border-t">
                <button
                    @click="toggleDarkMode"
                    class="w-full px-3 py-2 rounded-md text-sm font-medium transition-colors"
                    :class="darkMode 
                        ? 'bg-slate-800 text-yellow-400 hover:bg-slate-700'
                        : 'bg-slate-100 text-slate-900 hover:bg-slate-200'"
                >
                    {{ darkMode ? '☀️ Modo Claro' : '🌙 Modo Oscuro' }}
                </button>
            </div>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>