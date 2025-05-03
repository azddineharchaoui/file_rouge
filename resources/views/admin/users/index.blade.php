<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Gestion des utilisateurs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-6 text-green-700 bg-green-100 border border-green-400 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filtres -->
            <div class="p-6 mb-6 bg-white rounded-lg shadow-sm">
                <h3 class="mb-4 text-lg font-medium">Filtrer les utilisateurs</h3>
                <form action="{{ route('admin.users') }}" method="GET" class="flex flex-wrap gap-4">
                    <div class="w-full md:w-auto">
                        <label for="role" class="block mb-1 text-sm font-medium text-gray-700">Rôle</label>
                        <select id="role" name="role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">Tous les rôles</option>
                            <option value="candidate" {{ request('role') === 'candidate' ? 'selected' : '' }}>Candidat</option>
                            <option value="recruiter" {{ request('role') === 'recruiter' ? 'selected' : '' }}>Recruteur</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                        </select>
                    </div>
                    <div class="w-full md:w-auto">
                        <label for="status" class="block mb-1 text-sm font-medium text-gray-700">Statut</label>
                        <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">Tous les statuts</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                        </select>
                    </div>
                    <div class="flex items-end w-full gap-2 md:w-auto">
                        <button type="submit" class="px-4 py-2 text-white transition bg-emerald-500 rounded-md hover:bg-emerald-600">
                            Filtrer
                        </button>
                        <a href="{{ route('admin.users') }}" class="px-4 py-2 text-gray-700 transition bg-gray-200 rounded-md hover:bg-gray-300">
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium">Liste des utilisateurs</h3>
                        <p class="text-gray-600">Gérez les utilisateurs de la plateforme.</p>
                    </div>

                    @if ($users->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-sm text-gray-700 border-b">
                                        <th class="px-6 py-4 font-medium">Nom</th>
                                        <th class="px-6 py-4 font-medium">Email</th>
                                        <th class="px-6 py-4 font-medium">Rôle</th>
                                        <th class="px-6 py-4 font-medium">Statut</th>
                                        <th class="px-6 py-4 font-medium">Date d'inscription</th>
                                        <th class="px-6 py-4 font-medium">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr class="text-sm text-gray-700 border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $user->name }}</td>
                                        <td class="px-6 py-4">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            @if($user->role === 'admin')
                                                <span class="px-2 py-1 text-xs text-white bg-purple-500 rounded-full">Admin</span>
                                            @elseif($user->role === 'recruiter')
                                                <span class="px-2 py-1 text-xs text-white bg-blue-500 rounded-full">Recruteur</span>
                                            @else
                                                <span class="px-2 py-1 text-xs text-white bg-green-500 rounded-full">Candidat</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($user->is_active)
                                                <span class="px-2 py-1 text-xs text-white bg-green-500 rounded-full">Actif</span>
                                            @else
                                                <span class="px-2 py-1 text-xs text-white bg-red-500 rounded-full">Inactif</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4">
                                            @if($user->role !== 'admin' || auth()->id() !== $user->id)
                                                <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    @if($user->is_active)
                                                        <button type="submit" class="px-3 py-1 text-xs text-white bg-red-500 rounded hover:bg-red-600">
                                                            Désactiver
                                                        </button>
                                                    @else
                                                        <button type="submit" class="px-3 py-1 text-xs text-white bg-green-500 rounded hover:bg-green-600">
                                                            Activer
                                                        </button>
                                                    @endif
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-500">Action non disponible</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $users->links() }}
                        </div>
                    @else
                        <div class="p-8 text-center text-gray-500 bg-gray-50 rounded-lg">
                            <p class="text-lg">Aucun utilisateur trouvé avec ces critères.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>