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
import { Link, usePage } from '@inertiajs/vue3';
import { Settings } from 'lucide-vue-next';
import { ref, computed } from 'vue';
import AppLogo from './AppLogo.vue';
import { getIconComponent } from '@/lib/icons';

const page = usePage();
const darkMode = ref(false);

// Obtener el menú del props compartido
const menuItems = computed(() => {
    const menu = (page.props as any).menu || [];
    return menu.map((item: any) => ({
        title: item.label,
        href: item.href || (item.route ? `/api/menu/route/${item.route}` : ''),
        icon: getIconComponent(item.icon),
        items: item.children?.map((child: any) => ({
            title: child.label,
            href: child.href || (child.route ? `/api/menu/route/${child.route}` : ''),
        })) || [],
    }));
});

const footerNavItems: NavItem[] = [
    {
        title: 'Gestión de Menú',
        href: '/menu-items',
        icon: Settings,
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
            <NavMain :items="menuItems" />
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