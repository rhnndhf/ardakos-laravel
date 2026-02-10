import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage, router } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { clsx } from 'clsx';

export default function Dashboard({ auth, landlords, rooms, stats }) {
    const { url } = usePage();
    const queryParams = new URLSearchParams(window.location.search);
    const currentLandlordId = queryParams.get('landlord_id');

    const handleLandlordSwitch = (e) => {
        const landlordId = e.target.value;
        if (landlordId) {
            router.get(route('dashboard'), { landlord_id: landlordId });
        } else {
            router.get(route('dashboard'));
        }
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                    {/* Stats Overview */}
                    <div className="grid gap-4 md:grid-cols-3">
                        <Card>
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-sm font-medium">Total Rooms</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">{stats.total_rooms}</div>
                            </CardContent>
                        </Card>
                        <Card>
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-sm font-medium">Occupied</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold text-green-600">{stats.occupied}</div>
                            </CardContent>
                        </Card>
                        <Card>
                            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle className="text-sm font-medium">Available</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold text-blue-600">{stats.available}</div>
                            </CardContent>
                        </Card>
                    </div>

                    {/* Landlord Switcher (Only visible if landlords data is passed) */}
                    {landlords.length > 0 && (
                        <div className="flex items-center space-x-4 bg-white p-4 rounded-lg shadow">
                            <label className="font-medium text-gray-700">Switch Landlord:</label>
                            <select
                                className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                onChange={handleLandlordSwitch}
                                value={currentLandlordId || ''}
                            >
                                <option value="">Select Landlord...</option>
                                {landlords.map((landlord) => (
                                    <option key={landlord.id} value={landlord.id}>
                                        {landlord.name}
                                    </option>
                                ))}
                            </select>
                        </div>
                    )}

                    {/* Room Grid */}
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 className="text-lg font-medium mb-4">Room Status</h3>

                        <div className="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            {rooms.map((room) => (
                                <Card key={room.id} className={clsx(
                                    "cursor-pointer hover:shadow-md transition-shadow",
                                    room.occupancy_status === 'Terisi' ? "border-l-4 border-l-red-500" : "border-l-4 border-l-green-500"
                                )}>
                                    <CardContent className="p-4">
                                        <div className="font-bold text-lg">{room.room_number}</div>
                                        <div className="text-sm text-gray-500">{room.room_type}</div>
                                        <div className={clsx(
                                            "mt-2 text-xs font-semibold px-2 py-1 rounded-full inline-block",
                                            room.occupancy_status === 'Terisi' ? "bg-red-100 text-red-800" : "bg-green-100 text-green-800"
                                        )}>
                                            {room.occupancy_status || 'Tersedia'}
                                        </div>
                                        {room.tenants && room.tenants[0] && (
                                            <div className="mt-2 text-xs text-gray-600 truncate">
                                                {room.tenants[0].name}
                                            </div>
                                        )}
                                    </CardContent>
                                </Card>
                            ))}
                        </div>

                        {rooms.length === 0 && (
                            <div className="text-center py-12 text-gray-500">
                                No rooms found. Select a landlord or add specific rooms.
                            </div>
                        )}
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
