@extends('layouts.baseTemplate')

@section('title', 'Dashboard - DevConnect')

@section('content')
@if (session('post_deleted'))
    <div x-data="{ showAlert: true }" x-show="showAlert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('post_deleted') }}</span>
        <span @click="showAlert = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/>
            </svg>
        </span>
    </div>
@endif
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 pb-10" x-data="{ showModal: false, contentType: '' }">
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
                        <button @click="showModal = true" class="bg-gray-100 hover:bg-gray-200 text-gray-500 text-left rounded-lg px-4 py-3 flex-grow transition-colors duration-200">
                            Share your knowledge or ask a question...
                        </button>
                    </div>
                    <div class="flex justify-between mt-4 pt-4 border-t">
                        <button @click="showModal = true; contentType = 'code'" class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                            <span>Code</span>
                        </button>
                        <button @click="showModal = true; contentType = 'image'" class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Image</span>
                        </button>
                        <button @click="showModal = true; contentType = 'link'" class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            <span>Link</span>
                        </button>
                    </div>
                </div>

                <!-- Modal -->
                <div x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Create Post</h3>
                            <button @click="showModal = false" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <form action="/posts" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <div class="mb-4">
                                <textarea name="content" placeholder="Write your post..." class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Add Content:</label>
                                <div class="flex space-x-4 mt-2">
                                    <template x-if="contentType === 'image'">
                                        <div>
                                            <input type="file" name="image" class="hidden" id="image-upload">
                                            <label for="image-upload" class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-500 px-4 py-2 rounded-lg transition-colors duration-200">Image</label>
                                        </div>
                                    </template>
                                    <template x-if="contentType === 'link'">
                                        <input type="text" name="link" placeholder="Add a link..." class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                    </template>
                                    <template x-if="contentType === 'code'" >
                                        <textarea name="code" placeholder="Add code snippet..." class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"></textarea>
                                    </template>
                                </div>
                                <!-- hashtags -->
                                <div class="my-4">
                                <textarea name="hashtags" placeholder="tags separeted by commas: PHP, JS, MYSQL..." class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"></textarea>
                            </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Edit Post Modal -->
                <div id="editPostModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
                        <div class="flex justify-between items-center border-b pb-3 mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">Edit Post</h3>
                            <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <form id="editPostForm" action="/posts" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <textarea name="content" id="editPostContent" placeholder="Edit your post..." class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Posts -->
                @foreach ($allPosts as $post)
                    <div class="bg-white rounded-xl shadow-sm post">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="{{ Storage::url($post -> user -> image) }}" alt="User" class="w-12 h-12 rounded-full"/>
                                <div>
                                    <h3 class="font-semibold">{{$post -> user -> name}}</h3>
                                    <p class="text-gray-400 text-xs">{{ $post -> created_at -> diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="relative" x-data="{ open: false }">
                                <button class="text-gray-400 hover:text-gray-600 transition-colors duration-200" @click="open = !open">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-1 z-20">
                                    <button data-id="{{$post  -> id}}" data-content="{{$post -> content}}" class="edit-post block px-4 py-2 text-gray-700 hover:bg-gray-100">Edit Post</button>
                                    <form action="/posts/{{ $post -> id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class=" block px-4 py-2 text-rose-700 hover:bg-gray-100 transition-colors duration-200">Delete Post</button>
                                    </form>
                                   
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-gray-700">{{ $post -> content }}</p>
                            
                            @if ($post -> post_type === 'image')
                                <img src="{{ Storage::url($post -> content_type) }}" alt="Post Image" class="w-full h-auto max-h-96 object-cover rounded-lg mt-4">
                            @elseif ($post -> post_type === 'code')
                            <div class="mt-4 bg-gray-900 rounded-lg p-4 font-mono text-sm text-gray-200 overflow-x-auto">
                                <pre><code>{{$post -> content_type}}</code></pre>
                            </div>
                            @elseif ($post -> post_type === 'link')
                                <a href="https://{{ $post -> content_type }}" target="_blank" class="text-blue-500 hover:underline break-words">
                                    <div class="border border-gray-300 rounded-lg p-2 mt-2">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                            </svg>
                                            <span>{{ $post -> content_type }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endif
            
                            <div class="mt-4 flex flex-wrap gap-2">
                                @forelse (explode(',', trim($post->hashtags)) as $tag)
                                    @if(!empty($tag))
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $tag }}</span>
                                    @endif
                                @empty
                                    <!-- No tags to display -->
                                @endforelse
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
                                        <span>{{ count($post -> comments) }}</span>
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
                    <div class="comments-section transition-all duration-200 hidden border-t p-4 space-y-4">
                        <h4 class="font-medium text-gray-700">Comments ({{ count($post -> comments) }})</h4>
                        
                        @foreach ($post -> comments as $comment )
                             <!-- Comment 2 -->
                        <div class="flex space-x-3">
                            <img src="{{Storage::url($comment -> user -> image)}}" alt="User" class="w-8 h-8 rounded-full mt-1"/>
                            <div class="flex-1">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <div class="flex justify-between items-center">
                                        <h5 class="font-medium text-sm">{{ $comment -> user -> name }}</h5>
                                        <span class="text-gray-400 text-xs">{{$comment -> created_at -> diffForHumans()}}</span>
                                    </div>
                                    <p class="text-gray-700 text-sm mt-1">{{$comment -> content}}</p>
                                    
                                </div>
                                @if (Auth::user() -> id === $comment -> user_id)
                                <div class="flex items-center space-x-4 mt-2 ml-2">
                                    <button class="text-xs text-gray-500 hover:text-blue-500 transition-colors duration-200">Delete</button>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                 
                        
                        <!-- New Comment Input -->
                        <div class="flex space-x-3 mt-4">
                            <img src="{{ Storage::url(Auth::user() -> image )}}" alt="User" class="w-8 h-8 rounded-full"/>
                            <div class="flex-1">
                               <form action="{{route('comments.store')}}" method="post">
                                @csrf
                                <input type="text" name="post_id" value="{{$post -> id}}" class="hidden">
                               <textarea name="comment" placeholder="Write a comment..." class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"></textarea>
                               @error('comment')
                                   <span>{{$message}}</span>
                               @enderror
                                <div class="flex justify-end mt-2">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-lg text-sm transition-colors duration-200">Post</button>
                                </div>
                               </form>
                            </div>
                        </div>
                    </div>
                </div>
             
                    
                @endforeach
                {{ $allPosts -> links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // comments 
    document.addEventListener('DOMContentLoaded', function() {
        let posts = document.querySelectorAll('.post');
        posts.forEach((post) => {
            let commentsToggle = post.querySelector('#comments-toggle');
            let commentsSection = post.querySelector('.comments-section');
            commentsToggle.addEventListener('click', () => {
                commentsSection.classList.toggle('hidden');
            });
        });
    });
    // edit post
    let editBtn = document.querySelectorAll(".edit-post");
    let editModel = document.getElementById('editPostModal');
    let closeModal = document.getElementById('closeModal');
    editBtn.forEach((btn) => {
        btn.addEventListener("click", () => {
            editModel.classList.remove('hidden');
            let postId = btn.getAttribute('data-id');
            let content = btn.getAttribute('data-content');
            let editPostForm = document.getElementById('editPostForm');
            let editPostinput = document.getElementById('editPostContent');
            editPostinput.textContent = content;
            editPostForm.action = `/posts/${postId}`;
            
        });
    });
    closeModal.addEventListener('click',()=> {
        editModel.classList.add('hidden');
    })
    // comments section
    let posts = document.querySelectorAll('.post');
    posts.forEach((post) => {
        let commentsToggle = post.querySelector('#comments-toggle');
        let commentsSection = post.querySelector('#comments-section');
        commentsToggle.addEventListener('click', () => {
            commentsSection.classList.toggle('hidden');
        });
    });
</script>
@endsection