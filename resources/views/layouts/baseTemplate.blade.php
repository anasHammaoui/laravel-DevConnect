<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DevConnect - Social Network for Developers')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine-ie11.js" integrity="sha512-6m6AtgVSg7JzStQBuIpqoVuGPVSAK5Sp/ti6ySu6AjRDa1pX8mIl1TwP9QmKXU+4Mhq/73SzOk6mbNvyj9MPzQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('styles')
</head>
<body class="bg-gray-50">
    
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-gray-900 text-white z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <div class="text-2xl font-bold text-blue-400"><a href="/" class="decoration-none">&lt;DevConnect/&gt;</a></div>
                    <div class="relative">
                        <input type="text" 
                               placeholder="Search developers, posts, or #tags" 
                               class="bg-gray-800 pl-10 pr-4 py-2 rounded-lg w-96 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-700 transition-all duration-200"
                        >
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="flex items-center space-x-6">
                    <a href="/dashboard" class="flex items-center space-x-1 hover:text-blue-400 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </a>
                    <a href="#" class="flex items-center space-x-1 hover:text-blue-400 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        <span class="bg-blue-500 rounded-full w-2 h-2"></span>
                    </a>
                    <div class="relative">
                        <a href="#" id="notifications-button" class="flex items-center space-x-1 hover:text-blue-400 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if (auth()->user()->unreadNotifications->count())
                                <span class="bg-red-500 rounded-full w-4 h-4 flex items-center justify-center text-xs p-1 countNotifications">{{ auth()->user()->unreadNotifications->count() }}</span>
                            @endif
                        </a>
                        <!-- Dropdown Menu -->
                        <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-2 z-50">
                            @if (auth()->user()->notifications->count())
                                @if (auth()->user()->unreadNotifications->count())
                                    <div class="flex justify-between items-center px-4 py-2 border-b">
                                        <span class="text-gray-700 font-semibold">Notifications</span>
                                        <a href="{{ route('markasread') }}" class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-600 transition-colors duration-200">Mark All as Read</a>
                                    </div>
                                @endif
                                <div class="max-h-64 overflow-y-auto notifications">
                                    @foreach (auth()->user()->unreadNotifications as $notification)
                                        <a href="#" class="block px-4 py-2 text-sm text-blue-600 hover:bg-gray-100 transition-colors duration-200">
                                            {{$notification->data['data']}}
                                        </a>
                                    @endforeach
                                    @foreach (auth()->user()->readNotifications as $notification)
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 transition-colors duration-200">
                                            {{$notification->data['data']}}
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="px-4 py-2 text-gray-700">
                                    You have no notifications
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="relative">
                        <a href="{{ route('connections.index') }}" id="friend-requests-button" class="flex items-center space-x-1 hover:text-blue-400 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c1.656 0 3-1.344 3-3s-1.344-3-3-3-3 1.344-3 3 1.344 3 3 3zm0 2c-2.21 0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4z"/>
                            </svg>
                            <span class="bg-green-500 rounded-full w-2 h-2"></span>
                        </a>

                    </div>
                    <div class="relative">
                        <div class="h-8 w-8 rounded-full overflow-hidden cursor-pointer" id="profile-menu-button">
                            <img src="{{Storage::url(auth() -> user() -> image)}}" alt="Profile" class="w-full h-full object-cover"/>
                        </div>
                        
                        <!-- Dropdown Menu -->
                        <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Edit Profile</span>
                                </div>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span>Logout</span>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="mt-16 py-8">
        @yield('content')
    </main>

    @yield('scripts')
    <!-- At the end of the file, before </body> -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commentsToggle = document.getElementById('comments-toggle');
            const commentsSection = document.getElementById('comments-section');
            
            commentsToggle.addEventListener('click', function() {
                commentsSection.classList.toggle('hidden');
            });
              // Add dropdown toggle functionality
        const profileButton = document.getElementById('profile-menu-button');
        const profileDropdown = document.getElementById('profile-dropdown');
        
        profileButton.addEventListener('click', () => {
            profileDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!profileButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.add('hidden');
            }
        });
        // here add the toggle js code for notification dropdown
        const notificationsButton = document.getElementById('notifications-button');
        const notificationsDropdown = document.getElementById('notifications-dropdown');
        
        notificationsButton.addEventListener('click', () => {
            notificationsDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!notificationsButton.contains(event.target) && !notificationsDropdown.contains(event.target)) {
            notificationsDropdown.classList.add('hidden');
            }
        });
       
        });
         // pusher real time notifications

  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
  cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
});

var channel = pusher.subscribe('my-channel');
channel.bind("Illuminate\\Notifications\\Events\\BroadcastNotificationCreated", function(data) {
          let countNotification = parseInt(document.querySelector('.countNotifications') ? document.querySelector('.countNotifications').innerText : 0);
            if (document.querySelector('.countNotifications') ){
                document.querySelector('.countNotifications').innerText = countNotification + 1;
            } else {
                const notificationsButton = document.getElementById('notifications-button');
                const newNotification = document.createElement('span');
                newNotification.classList.add('bg-red-500', 'rounded-full', 'w-4', 'h-4', 'flex', 'items-center', 'justify-center', 'text-xs', 'p-1', 'countNotifications');
                newNotification.innerText = countNotification + 1;
                notificationsButton.appendChild(newNotification);
            }

            const notificationDropdown = document.querySelector('.notifications');
            const newNotification = document.createElement('a');
            newNotification.href = '#';
            newNotification.classList.add('block', 'px-4', 'py-2', 'text-sm', 'text-blue-600', 'hover:bg-gray-100', 'transition-colors', 'duration-200', 'unread');
            newNotification.innerText = data.data;
            notificationDropdown.insertBefore(newNotification, notificationDropdown.firstChild);
            

});
    </script>
</body>

      
    </script>
</body>
</html>