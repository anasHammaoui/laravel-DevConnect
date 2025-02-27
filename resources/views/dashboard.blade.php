@extends('layouts.baseTemplate')

@section('title', 'Dashboard - DevConnect')

@section('content')
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 pb-10">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Left Sidebar -->
            <div class="space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="relative">
                        <div class="h-24 bg-gradient-to-r from-blue-600 to-blue-400"></div>
                        <img src="{{ Storage::url(auth()-> user() -> image) }}" alt="Profile" 
                             class="absolute -bottom-6 left-4 w-20 h-20 rounded-full border-4 border-white shadow-md"/>
                    </div>
                    <div class="pt-14 p-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold">{{ auth()-> user() -> name }}</h2>
                            <a href="{{ auth()-> user() -> portfolio }}" target="_blank" class="text-gray-600 hover:text-black transition-colors duration-200">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                            </a>
                        </div>
                        <!-- <p class="text-gray-600 text-sm mt-1">Senior Full Stack Developer</p> -->
                        <p class="text-gray-500 text-sm mt-2">{{ auth()-> user() -> bio }}</p>
                        
                        <div class="mt-4 flex flex-wrap gap-2">
                        @foreach(explode(',', $user->skills ?? 'PHP,Laravel,JavaScript') as $skill)
                                <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm font-medium">
                                    {{ trim($skill) }}
                                </span>
                            @endforeach
                           
                        </div>

                        <div class="mt-4 pt-4 border-t">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Connections</span>
                                <span class="text-blue-600 font-medium">487</span>
                            </div>
                            <div class="flex justify-between text-sm mt-2">
                                <span class="text-gray-500">Posts</span>
                                <span class="text-blue-600 font-medium">52</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Feed -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Post Creation -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex items-center space-x-4">
                        <img src="{{ Storage::url(auth()-> user() -> image) }}" alt="User" class="w-12 h-12 rounded-full"/>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-500 text-left rounded-lg px-4 py-3 flex-grow transition-colors duration-200">
                            Share your knowledge or ask a question...
                        </button>
                    </div>
                    <div class="flex justify-between mt-4 pt-4 border-t">
                        <button class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                            <span>Code</span>
                        </button>
                        <button class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Image</span>
                        </button>
                        <button class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            <span>Link</span>
                        </button>
                    </div>
                </div>

                <!-- Posts -->
                @foreach ($allPosts as $post)
                    <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="{{ Storage::url($post -> user -> image) }}" alt="User" class="w-12 h-12 rounded-full"/>
                                <div>
                                    <h3 class="font-semibold">{{$post -> user -> name}}</h3>
                                    <p class="text-gray-400 text-xs">{{ $post -> created_at -> diffForHumans() }}</p>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-gray-700">{{ $post -> content }}</p>
                            
                            <div class="mt-4 bg-gray-900 rounded-lg p-4 font-mono text-sm text-gray-200 overflow-x-auto">
                                <pre><code>{{$post -> code}}</code></pre>
                            </div>
            
                            <div class="mt-4 flex flex-wrap gap-2">
                               @foreach ($post -> hashtags as $tag )
                               <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $tag -> name }}</span>
                               @endforeach
                            </div>
            
                            <div class="mt-4 flex items-center justify-between border-t pt-4">
                                <div class="flex items-center space-x-4">
                                    <button class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                        </svg>
                                        <span>{{ $post -> likes }}</span>
                                    </button>
                                    <button id="comments-toggle" class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                        </svg>
                                        <span>12</span>
                                    </button>
                                </div>
                                <button class="text-gray-500 hover:text-blue-500 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Section - Hidden by Default -->
                    <div id="comments-section" class="hidden border-t p-4 space-y-4">
                        <h4 class="font-medium text-gray-700">Comments (12)</h4>
                        
                        <!-- Comment 1 -->
                        <div class="flex space-x-3">
                            <img src="https://avatar.iran.liara.run/public/girl" alt="User" class="w-8 h-8 rounded-full mt-1"/>
                            <div class="flex-1">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="flex justify-between items-center">
                                        <h5 class="font-medium text-sm">Jessica Kim</h5>
                                        <span class="text-gray-400 text-xs">45m ago</span>
                                    </div>
                                    <p class="text-gray-700 text-sm mt-1">This is really helpful! Have you measured the memory usage impact?</p>
                                </div>
                                <div class="flex items-center space-x-4 mt-2 ml-2">
                                    <button class="text-xs text-gray-500 hover:text-blue-500 transition-colors duration-200">Like</button>
                                    <button class="text-xs text-gray-500 hover:text-blue-500 transition-colors duration-200">Reply</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Comment 2 -->
                        <div class="flex space-x-3">
                            <img src="https://avatar.iran.liara.run/public/man" alt="User" class="w-8 h-8 rounded-full mt-1"/>
                            <div class="flex-1">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="flex justify-between items-center">
                                        <h5 class="font-medium text-sm">Michael Johnson</h5>
                                        <span class="text-gray-400 text-xs">30m ago</span>
                                    </div>
                                    <p class="text-gray-700 text-sm mt-1">You should also consider adding error handling for when Redis is unavailable. Something like:</p>
                                    <pre class="bg-gray-100 p-2 mt-2 text-xs rounded overflow-x-auto"><code>try {
  // Redis operations
} catch (err) {
  console.error('Redis error:', err);
  return fetchDataFromDB();
}</code></pre>
                                </div>
                                <div class="flex items-center space-x-4 mt-2 ml-2">
                                    <button class="text-xs text-gray-500 hover:text-blue-500 transition-colors duration-200">Like</button>
                                    <button class="text-xs text-gray-500 hover:text-blue-500 transition-colors duration-200">Reply</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Comment 3 -->
                        <div class="flex space-x-3">
                            <img src="https://avatar.iran.liara.run/public/boy" alt="User" class="w-8 h-8 rounded-full mt-1"/>
                            <div class="flex-1">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="flex justify-between items-center">
                                        <h5 class="font-medium text-sm">Alex Chen <span class="text-blue-500 text-xs">(Author)</span></h5>
                                        <span class="text-gray-400 text-xs">15m ago</span>
                                    </div>
                                    <p class="text-gray-700 text-sm mt-1">@Jessica - Memory usage went up by about 10%, but the performance gains were definitely worth it.</p>
                                    <p class="text-gray-700 text-sm mt-1">@Michael - Great point! I'll add that to my implementation.</p>
                                </div>
                                <div class="flex items-center space-x-4 mt-2 ml-2">
                                    <button class="text-xs text-gray-500 hover:text-blue-500 transition-colors duration-200">Like</button>
                                    <button class="text-xs text-gray-500 hover:text-blue-500 transition-colors duration-200">Reply</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- New Comment Input -->
                        <div class="flex space-x-3 mt-4">
                            <img src="https://avatar.iran.liara.run/public/boy" alt="User" class="w-8 h-8 rounded-full"/>
                            <div class="flex-1">
                                <textarea placeholder="Write a comment..." class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"></textarea>
                                <div class="flex justify-end mt-2">
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-lg text-sm transition-colors duration-200">Post</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             
                    
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commentsToggle = document.getElementById('comments-toggle');
        const commentsSection = document.getElementById('comments-section');
        
        commentsToggle.addEventListener('click', function() {
            commentsSection.classList.toggle('hidden');
        });
    });
</script>
@endsection