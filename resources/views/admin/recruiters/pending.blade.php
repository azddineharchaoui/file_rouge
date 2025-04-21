<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JobNow - Pending Recruiters</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen bg-gray-100">
    <header class="bg-emerald-900 text-white p-4">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="bg-white rounded p-1">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 7H4V19H20V7Z" fill="black" />
                        <path d="M15 3H9V7H15V3Z" fill="black" />
                    </svg>
                </div>
                <span class="font-bold text-xl">JobNow</span>
            </div>
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-white hover:text-emerald-200">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <section class="container mx-auto px-4 py-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Pending Recruiters</h2>

            @if (session('success'))
                <div class="mb-4 text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            @if ($recruiters->isEmpty())
                <p class="text-gray-600">No pending recruiters.</p>
            @else
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 text-left">Name</th>
                                <th class="py-2 text-left">Email</th>
                                <th class="py-2 text-left">Company</th>
                                <th class="py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recruiters as $recruiter)
                                <tr class="border-b">
                                    <td class="py-2">{{ $recruiter->name }}</td>
                                    <td class="py-2">{{ $recruiter->email }}</td>
                                    <td class="py-2">{{ $recruiter->companyProfile->company_name }}</td>
                                    <td class="py-2">
                                        <form action="{{ route('admin.recruiters.approve', $recruiter) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-emerald-500 text-white px-4 py-1 rounded-md hover:bg-emerald-600">Approve</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </main>

    <footer class="bg-gray-100 pt-6 pb-6">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            © {{ date('Y') }} JobNow. All rights reserved.
        </div>
    </footer>
</body>
</html>