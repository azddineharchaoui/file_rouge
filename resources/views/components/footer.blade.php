<footer class="bg-gray-100 pt-12 pb-6 mt-auto">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div>
                <h3 class="font-bold mb-4">JobNow</h3>
                <p class="text-gray-500 text-sm">
                    Connecting talent with opportunity since {{ date('Y') }}.
                </p>
            </div>
            <div>
                <h3 class="font-bold mb-4">Company</h3>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li><a href="{{ route('about') }}" class="hover:text-emerald-500">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-emerald-500">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold mb-4">Job Categories</h3>
                <ul class="space-y-2 text-sm text-gray-500">
                    @foreach($footerCategories as $category)
                        <li><a href="{{ route('jobs.byCategory', $category->id) }}" class="hover:text-emerald-500">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="font-bold mb-4">Newsletter</h3>
                <p class="text-gray-500 text-sm mb-4">Subscribe to our newsletter</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex">
                    @csrf
                    <input 
                        type="email" 
                        name="email"
                        placeholder="Email Address" 
                        class="flex-1 p-2 border rounded-l focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        required
                    >
                    <button type="submit" class="bg-emerald-500 text-white px-4 py-2 rounded-r hover:bg-emerald-600">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
        <div class="border-t pt-6 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-500 text-sm">© Copyright JobNow, {{ date('Y') }}</p>
            <div class="flex gap-4 text-sm">
                <a href="{{ route('privacy') }}" class="text-gray-500 hover:text-emerald-500">Privacy Policy</a>
                <a href="{{ route('terms') }}" class="text-gray-500 hover:text-emerald-500">Terms & Conditions</a>
            </div>
        </div>
    </div>
</footer>