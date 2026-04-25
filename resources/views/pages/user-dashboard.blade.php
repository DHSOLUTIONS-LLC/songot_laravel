<section id="page-dashboard" class="page">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">My Dashboard</h1>
        
        <div class="grid md:grid-cols-3 gap-6">
            <div class="glass-card rounded-xl p-6">
                <h3 class="text-lg font-semibold mb-2">My Downloads</h3>
                <p class="text-3xl font-bold text-[#6074ff]">{{ $totalDownloads }}</p>
                <p class="text-sm text-gray-400">Total stems downloaded</p>
            </div>
            
            <div class="glass-card rounded-xl p-6">
                <h3 class="text-lg font-semibold mb-2">Favorites</h3>
                <p class="text-3xl font-bold text-[#6074ff]">{{ $favoritesCount }}</p>
                <p class="text-sm text-gray-400">Saved stems</p>
            </div>
            
            <div class="glass-card rounded-xl p-6">
                <h3 class="text-lg font-semibold mb-2">Account Status</h3>
                <p class="text-lg font-bold text-[#80e0a0]">{{ ucfirst(auth()->user()->tier) }}</p>
                <p class="text-sm text-gray-400">Current plan</p>
            </div>
        </div>
    </div>
</section>