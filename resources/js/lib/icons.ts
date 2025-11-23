import {
    LayoutGrid,
    Users,
    FolderOpen,
    BarChart3,
    ShoppingCart,
    FileText,
    Truck,
    CreditCard,
    Calendar,
    CheckSquare,
    Star,
    Settings,
    Home,
    Menu,
    Plus,
    Edit2,
    Trash2,
    ChevronDown,
    ChevronLeft,
    ChevronRight,
    MoreVertical,
    Search,
    Bell,
    LogOut,
    User,
    Pencil,
    GripVertical,
    PlusIcon,
} from 'lucide-vue-next';

// Mapa de nombres de ícones a componentes
const iconMap: Record<string, any> = {
    LayoutGrid,
    Users,
    FolderOpen,
    BarChart3,
    ShoppingCart,
    FileText,
    Truck,
    CreditCard,
    Calendar,
    CheckSquare,
    Star,
    Settings,
    Home,
    Menu,
    Plus,
    Edit2,
    Trash2,
    ChevronDown,
    ChevronLeft,
    ChevronRight,
    MoreVertical,
    Search,
    Bell,
    LogOut,
    User,
    Pencil,
    GripVertical,
    PlusIcon,
};

export function getIconComponent(iconName: string | null): any {
    if (!iconName) return LayoutGrid;
    return iconMap[iconName] || LayoutGrid;
}

export function hasIcon(iconName: string | null): boolean {
    if (!iconName) return false;
    return iconName in iconMap;
}
