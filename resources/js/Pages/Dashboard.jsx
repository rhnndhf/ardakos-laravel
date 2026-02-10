import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage, router } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/Components/ui/select";
import { Badge } from "@/Components/ui/badge";
import { Building2, Users, Bed, CreditCard, DoorClosed, DoorOpen, LayoutGrid, AlertCircle } from 'lucide-react';
import { clsx } from 'clsx';

export default function Dashboard({ auth, landlords, rooms, stats }) {
    const { url } = usePage();
    const queryParams = new URLSearchParams(window.location.search);
    const currentLandlordId = queryParams.get('landlord_id') || "";

    const handleLandlordSwitch = (value) => {
        if (value && value !== "all") {
            router.get(route('dashboard'), { landlord_id: value });
        } else {
            router.get(route('dashboard'));
        }
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Command Center" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

                    {/* Header & Controls */}
                    <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h1 className="text-2xl font-bold tracking-tight">Overview</h1>
                            <p className="text-muted-foreground text-gray-500">
                                Real-time updates on occupancy and revenue.
                            </p>
                        </div>

                        {/* Landlord Switcher */}
                        {landlords.length > 0 && (
                            <div className="w-full md:w-[250px]">
                                <Select value={currentLandlordId} onValueChange={handleLandlordSwitch}>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select Landlord" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="all">All Landlords</SelectItem>
                                        {landlords.map((landlord) => (
                                            <SelectItem key={landlord.id} value={String(landlord.id)}>
                                                {landlord.name}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                            </div>
                        )}
                    </div>

                    {/* Stats Overview */}
                    <div className="grid gap-4 md:grid-cols-3">
                        <Card>
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-sm font-medium">Total Rooms</CardTitle>
                                <Building2 className="h-4 w-4 text-muted-foreground text-gray-400" />
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">{stats.total_rooms}</div>
                                <p className="text-xs text-muted-foreground text-gray-500">
                                    Across all properties
                                </p>
                            </CardContent>
                        </Card>
                        <Card>
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-sm font-medium">Occupancy Rate</CardTitle>
                                <Users className="h-4 w-4 text-muted-foreground text-gray-400" />
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">
                                    {stats.total_rooms > 0
                                        ? Math.round((stats.occupied / stats.total_rooms) * 100)
                                        : 0}%
                                </div>
                                <div className="flex items-center gap-2 mt-1">
                                    <Badge variant="secondary" className="text-xs">
                                        {stats.occupied} Occupied
                                    </Badge>
                                    <Badge variant="outline" className="text-xs">
                                        {stats.available} Available
                                    </Badge>
                                </div>
                            </CardContent>
                        </Card>
                        <Card>
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-sm font-medium">Revenue (Est)</CardTitle>
                                <CreditCard className="h-4 w-4 text-muted-foreground text-gray-400" />
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">IDR ...</div>
                                <p className="text-xs text-muted-foreground text-gray-500">
                                    Monthly projection
                                </p>
                            </CardContent>
                        </Card>
                    </div>

                    {/* Room Grid */}
                    <Card className="col-span-4">
                        <CardHeader>
                            <CardTitle>Room Status</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                {rooms.map((room) => (
                                    <div
                                        key={room.id}
                                        className={clsx(
                                            "relative group flex flex-col items-center justify-center p-4 border rounded-xl transition-all duration-200 hover:shadow-lg cursor-pointer",
                                            room.occupancy_status === 'Terisi'
                                                ? "bg-red-50/50 border-red-100 hover:border-red-200"
                                                : "bg-green-50/50 border-green-100 hover:border-green-200"
                                        )}
                                    >
                                        <div className="absolute top-2 right-2">
                                            {room.occupancy_status === 'Terisi' ? (
                                                <DoorClosed className="h-4 w-4 text-red-400" />
                                            ) : (
                                                <DoorOpen className="h-4 w-4 text-green-400" />
                                            )}
                                        </div>

                                        <div className="text-xl font-bold text-gray-800 mb-1">{room.room_number}</div>
                                        <div className="text-xs font-medium text-gray-500 mb-3">{room.room_type}</div>

                                        <Badge variant={room.occupancy_status === 'Terisi' ? "destructive" : "success"}>
                                            {room.occupancy_status === 'Terisi' ? 'Occupied' : 'Available'}
                                        </Badge>

                                        {room.tenants && room.tenants[0] && (
                                            <div className="mt-3 text-xs text-gray-600 font-medium flex items-center gap-1">
                                                <Users className="h-3 w-3" />
                                                <span className="truncate max-w-[80px]">{room.tenants[0].name}</span>
                                            </div>
                                        )}
                                    </div>
                                ))}
                            </div>

                            {rooms.length === 0 && (
                                <div className="flex flex-col items-center justify-center py-12 text-center">
                                    <div className="bg-gray-100 p-3 rounded-full mb-4">
                                        <LayoutGrid className="h-6 w-6 text-gray-400" />
                                    </div>
                                    <h3 className="text-lg font-medium text-gray-900">No rooms found</h3>
                                    <p className="text-gray-500 mt-1 max-w-sm">
                                        Select a landlord to view their rooms, or add new rooms to the system.
                                    </p>
                                </div>
                            )}
                        </CardContent>
                    </Card>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
