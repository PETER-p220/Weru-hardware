@vite(['resources/css/app.css', 'resources/js/app.js'])
<div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Add New Advertisement</h1>

    <div class="bg-white shadow-lg rounded-xl p-8">
        <form action="{{route('store')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" required class="w-full px-4 py-3 border rounded-lg focus:ring-orange-500 focus:border-orange-500" 
                       placeholder="e.g. 20% Off Cement This Week">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Description (optional)</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 border rounded-lg"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Image or Video <span class="text-red-500">*</span></label>
                <input type="file" name="media" accept="image/*,video/*" required class="w-full">
                <p class="text-sm text-gray-500 mt-2">Max 50MB • JPG, PNG, MP4, MOV supported</p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Link (optional)</label>
                <input type="url" name="link" class="w-full px-4 py-3 border rounded-lg" 
                       placeholder="https://weruhardware.co.tz/special-offer">
            </div>

            <div class="mb-8 flex items-center">
                <input type="checkbox" name="is_active" id="active" checked class="mr-3 h-5 w-5">
                <label for="active" class="text-gray-700 font-semibold">Show on homepage immediately</label>
            </div>

            <div class="flex gap-4">
                <button type="submit" 
                    class="px-8 py-4 bg-blue-600 text-white font-bold rounded-lg hover:bg-orange-700 transition">
                    Save Advertisement
                </button>
                <a href="{{ route('advertisement') }}" 
                   class="px-8 py-4 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
