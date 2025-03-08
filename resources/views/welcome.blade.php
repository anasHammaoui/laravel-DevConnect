<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevConnect - Professional Networking Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-gray-900 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-400">&lt;DevConnect/&gt;</h1>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-gray-300 hover:text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="hidden md:flex space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-transparent hover:bg-gray-800 text-white px-4 py-2 rounded-lg border border-blue-400 transition-colors duration-200">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">Register</a>
                    @endauth
                </div>
            </div>
            
            <!-- Mobile navigation -->
            <div id="mobile-menu" class="hidden md:hidden py-3 border-t border-gray-700">
                @auth
                    <a href="{{ route('dashboard') }}" class="block py-2 text-white hover:text-blue-400 transition-colors duration-200">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block py-2 text-white hover:text-blue-400 transition-colors duration-200">Login</a>
                    <a href="{{ route('register') }}" class="block py-2 text-white hover:text-blue-400 transition-colors duration-200">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Welcome Section -->
    <div class="bg-white min-h-[calc(100vh-4rem)] flex items-center">
        <div class="max-w-7xl mx-auto px-4 py-16 w-full">
            <div class="text-center">
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-6">Welcome to DevConnect</h2>
                <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Your gateway to professional opportunities. Connect, grow, and advance your career with our powerful networking platform.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{route('register')}}" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 text-lg transition-colors duration-200">Get Started</a>
                    <a href="#" class="bg-white text-blue-600 px-8 py-3 rounded-lg border border-blue-600 hover:bg-gray-100 text-lg transition-colors duration-200">Learn More</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // toggle navbar mobile
            document.getElementById('mobile-menu-button').addEventListener('click', () => {
                document.getElementById('mobile-menu').classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>