@extends('layouts.baseTemplate')

@section('title', $user->name . ' - DevConnect Profile')

@section('styles')
<style>
    .profile-badge {
        @apply px-3 py-1 rounded-full text-sm font-medium transition-all;
    }
    .skill-badge {
        @apply px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium hover:bg-indigo-100;
    }
    .language-badge {
        @apply px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-sm font-medium hover:bg-emerald-100;
    }
    .section-card {
        @apply bg-white rounded-xl shadow-md p-6 mb-6 transition-transform duration-300 hover:shadow-lg;
    }
    .stat-item {
        @apply flex flex-col items-center justify-center p-3 rounded-lg transition-all hover:bg-gray-50;
    }
    .connect-btn {
        @apply inline-flex items-center px-4 py-2 rounded-lg font-medium transition-all duration-200;
    }
    .connect-btn-primary {
        @apply bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 shadow-sm hover:shadow;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Left Column - Profile Information -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Profile Header Card -->
            <div class="section-card overflow-hidden">
                <div class="relative mb-8">
                    <div class="h-40 sm:h-48 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 rounded-t-xl"></div>
                    <img src="{{ $user ->  image ? Storage::url( $user ->  image) : 'https://avatar.iran.liara.run/public/1' }}" 
                    class="absolute -bottom-14 left-8 w-28 h-28 sm:w-32 sm:h-32 rounded-full border-4 border-white shadow-lg object-cover transition-transform hover:scale-105"/>
                </div>
                <div class="pt-10 sm:pt-14">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <div class="flex items-center space-x-3">
                            @if(Auth::id() !== $user->id)
                                @if(Auth::user() && $connections->contains('id', $user -> id))
                                    <button class="connect-btn bg-gray-100 text-gray-700 hover:bg-gray-200 flex items-center space-x-2 shadow-sm">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>Connected</span>
                                    </button>
                                @else
                                   <form action="{{ route('connections.send',$user-> id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="connect-btn connect-btn-primary group">
                                        <svg class="w-5 h-5 mr-2 group-hover:animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                                        </svg>
                                        <span>Connect</span>
                                    </button>
                                   </form>
                                @endif
                            @else
                                <a href="{{ route('profile.edit') }}" class="connect-btn bg-gray-50 text-gray-700 hover:bg-gray-100 border border-gray-300">
                                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Profile
                                </a>
                            @endif
                            @if($user->portfolio)
                            <a href="{{ $user->portfolio }}" target="_blank" class="flex items-center text-gray-700 hover:text-indigo-600 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                                GitHub
                            </a>
                            @endif
                        </div>
                    </div>
                    <p class="text-gray-600 mt-4 leading-relaxed">{{ $user->bio ?? 'No bio available.' }}</p>
                    
                    <!-- Skills Tags -->
                    @if($user->skills)
                    <div class="mt-8">
                        <h3 class="text-md font-semibold text-gray-700 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                            </svg>
                            Skills
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $user->skills) as $skill)
                                @if(!empty(trim($skill)))
                                <span class="skill-badge">{{ trim($skill) }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Languages -->
                    @if($user->languages)
                    <div class="mt-6">
                        <h3 class="text-md font-semibold text-gray-700 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7 2a1 1 0 011 1v1h3a1 1 0 110 2H9.5v1.5a1 1 0 11-2 0V6H4a1 1 0 110-2h3.5V3a1 1 0 011-1zm0 5a1 1 0 011 1v1h8a1 1 0 110 2H9v1a1 1 0 11-2 0v-1H2a1 1 0 110-2h5V8a1 1 0 011-1zM7 12a1 1 0 011 1v1h6a1 1 0 110 2H8v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h3v-1a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Languages
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $user->languages) as $language)
                                @if(!empty(trim($language)))
                                <span class="language-badge">{{ trim($language) }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Profile Stats -->
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="stat-item">
                                <span class="block text-2xl font-bold text-gray-900">{{ $user->post->count() }}</span>
                                <span class="text-sm text-gray-500">Posts</span>
                            </div>
                            <div class="stat-item">
                                <span class="block text-2xl font-bold text-gray-900">{{ $user->connections()->count() }}</span>
                                <span class="text-sm text-gray-500">Connections</span>
                            </div>
                            <div class="stat-item">
                                <span class="block text-2xl font-bold text-gray-900">{{ $user->likes->count() }}</span>
                                <span class="text-sm text-gray-500">Contributions</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Posts Section -->
            @if($user->post->count() > 0)
            <div class="section-card">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v10m2 2v-6a2 2 0 00-2-2h-2m-4 8L9 16m0 0l-2-2m2 2l2-2"></path>
                    </svg>
                    Recent Posts
                </h2>
                <div class="space-y-8">
                    @foreach($user->post->take(3) as $post)
                    <div class="border-b border-gray-100 pb-6 last:border-b-0 last:pb-0 hover:bg-gray-50 p-4 rounded-lg transition-colors">
                        <p class="text-gray-700 mb-4 leading-relaxed">{{ $post->content }}</p>
                        
                        @if($post->post_type === 'image')
                            <img src="{{ Storage::url($post->content_type) }}" alt="Post Image" class="w-full h-auto max-h-80 object-cover rounded-lg my-4 shadow-sm">
                        @elseif($post->post_type === 'code')
                            <div class="bg-gray-900 rounded-lg p-4 font-mono text-sm text-gray-200 overflow-x-auto my-4 shadow-inner">
                                <pre><code>{{ $post->content_type }}</code></pre>
                            </div>
                        @elseif($post->post_type === 'link')
                            <a href="{{ $post->content_type }}" target="_blank" class="text-blue-500 hover:underline block my-4">
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                        </svg>
                                        <span class="truncate">{{ $post->content_type }}</span>
                                    </div>
                                </div>
                            </a>
                        @endif
                        
                        <!-- Post hashtags -->
                        @if($post->hashtags->count() > 0)
                        <div class="flex flex-wrap gap-2 mt-4">
                            @foreach($post->hashtags as $tag)
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-xs hover:bg-blue-100 transition-colors">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                        @endif
                        
                        <!-- Post metadata -->
                        <div class="flex items-center justify-between mt-5 text-sm text-gray-500">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center hover:text-blue-600 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                    </svg>
                                    {{ $post->likes->count() }}
                                </span>
                                <span class="flex items-center hover:text-blue-600 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                    {{ $post->comments->count() }}
                                </span>
                            </div>
                            <span class="font-medium text-indigo-400">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                

            </div>
            @endif
        </div>
        

</div>
@endsection