<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Discord Clone</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex flex-col">
<header class="w-full p-4 flex justify-between items-center">
    @if (Route::has('login'))
        <div class="flex items-center">
            <svg class="w-10 h-10 mr-2" viewBox="0 -28.5 256 256" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid">
                <path d="M216.856339,16.5966031 C200.285002,8.84328665 182.566144,3.2084988 164.041564,0 C161.766523,4.11318106 159.108624,9.64549908 157.276099,14.0464379 C137.583995,11.0849896 118.072967,11.0849896 98.7430163,14.0464379 C96.9108417,9.64549908 94.1925838,4.11318106 91.8971895,0 C73.3526068,3.2084988 55.6133949,8.86399117 39.0420583,16.6376612 C5.61752293,67.146514 -3.4433191,116.400813 1.08711069,164.955721 C23.2560196,181.510915 44.7403634,191.567697 65.8621325,198.148576 C71.0772151,190.971126 75.7283628,183.341335 79.7352139,175.300261 C72.104019,172.400575 64.7949724,168.822202 57.8887866,164.667963 C59.7209612,163.310589 61.5131304,161.891452 63.2445898,160.431257 C105.36741,180.133187 151.134928,180.133187 192.754523,160.431257 C194.506336,161.891452 196.298154,163.310589 198.110326,164.667963 C191.183787,168.842556 183.854737,172.420929 176.223542,175.320965 C180.230393,183.341335 184.861538,190.991831 190.096624,198.16893 C211.238746,191.588051 232.743023,181.531619 254.911949,164.955721 C260.227747,108.668201 245.831087,59.8662432 216.856339,16.5966031 Z M85.4738752,135.09489 C72.8290281,135.09489 62.4592217,123.290155 62.4592217,108.914901 C62.4592217,94.5396472 72.607595,82.7145587 85.4738752,82.7145587 C98.3405064,82.7145587 108.709962,94.5189427 108.488529,108.914901 C108.508531,123.290155 98.3405064,135.09489 85.4738752,135.09489 Z M170.525237,135.09489 C157.88039,135.09489 147.510584,123.290155 147.510584,108.914901 C147.510584,94.5396472 157.658606,82.7145587 170.525237,82.7145587 C183.391518,82.7145587 193.761324,94.5189427 193.539891,108.914901 C193.539891,123.290155 183.391518,135.09489 170.525237,135.09489 Z" fill="#5865F2" fill-rule="nonzero"></path>
            </svg>
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Discord Clone</h1>
        </div>
        <nav class="flex items-center gap-2">
            @auth
                <a href="{{ url('/rooms') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition">
                        Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif
</header>

<main class="flex-grow flex items-center justify-center">
    <div class="max-w-3xl mx-auto p-6 text-center">
        <div class="flex justify-center mb-6">
            <svg class="w-24 h-24" viewBox="0 -28.5 256 256" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid">
                <path d="M216.856339,16.5966031 C200.285002,8.84328665 182.566144,3.2084988 164.041564,0 C161.766523,4.11318106 159.108624,9.64549908 157.276099,14.0464379 C137.583995,11.0849896 118.072967,11.0849896 98.7430163,14.0464379 C96.9108417,9.64549908 94.1925838,4.11318106 91.8971895,0 C73.3526068,3.2084988 55.6133949,8.86399117 39.0420583,16.6376612 C5.61752293,67.146514 -3.4433191,116.400813 1.08711069,164.955721 C23.2560196,181.510915 44.7403634,191.567697 65.8621325,198.148576 C71.0772151,190.971126 75.7283628,183.341335 79.7352139,175.300261 C72.104019,172.400575 64.7949724,168.822202 57.8887866,164.667963 C59.7209612,163.310589 61.5131304,161.891452 63.2445898,160.431257 C105.36741,180.133187 151.134928,180.133187 192.754523,160.431257 C194.506336,161.891452 196.298154,163.310589 198.110326,164.667963 C191.183787,168.842556 183.854737,172.420929 176.223542,175.320965 C180.230393,183.341335 184.861538,190.991831 190.096624,198.16893 C211.238746,191.588051 232.743023,181.531619 254.911949,164.955721 C260.227747,108.668201 245.831087,59.8662432 216.856339,16.5966031 Z M85.4738752,135.09489 C72.8290281,135.09489 62.4592217,123.290155 62.4592217,108.914901 C62.4592217,94.5396472 72.607595,82.7145587 85.4738752,82.7145587 C98.3405064,82.7145587 108.709962,94.5189427 108.488529,108.914901 C108.508531,123.290155 98.3405064,135.09489 85.4738752,135.09489 Z M170.525237,135.09489 C157.88039,135.09489 147.510584,123.290155 147.510584,108.914901 C147.510584,94.5396472 157.658606,82.7145587 170.525237,82.7145587 C183.391518,82.7145587 193.761324,94.5189427 193.539891,108.914901 C193.539891,123.290155 183.391518,135.09489 170.525237,135.09489 Z" fill="#5865F2" fill-rule="nonzero"></path>
            </svg>
        </div>
        <h2 class="text-4xl font-bold mb-4 text-gray-800 dark:text-white">Connect with your community</h2>
        <p class="text-lg mb-8 text-gray-600 dark:text-gray-300">Chat, hang out, and stay close with your friends and communities</p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('register') }}" class="px-6 py-3 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition font-medium">Get Started</a>
            <a href="#features" class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-md text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 transition">Learn More</a>
        </div>
    </div>
</main>

<section id="features" class="py-12 bg-white dark:bg-gray-800">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-3xl font-bold mb-8 text-center text-gray-800 dark:text-white">Key Features</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="p-4 rounded-lg">
                <div class="bg-indigo-100 dark:bg-indigo-900 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-indigo-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-1.008c-.225.13-.454.252-.687.365-1.88.912-3.327 1.274-4.09 1.43a.5.5 0 01-.54-.686c.134-.248.304-.517.51-.816.406-.594.824-1.24.824-1.874 0-.152-.018-.302-.053-.447C.75 12.486 0 11.296 0 10c0-3.866 3.582-7 8-7s8 3.134 8 7z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">Text Channels</h3>
                <p class="text-gray-600 dark:text-gray-300">Chat with friends and communities in organized text channels</p>
            </div>

            <div class="p-4 rounded-lg">
                <div class="bg-indigo-100 dark:bg-indigo-900 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-indigo-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">Voice Chat</h3>
                <p class="text-gray-600 dark:text-gray-300">Join voice channels to talk, game, or just hang out together</p>
            </div>

            <div class="p-4 rounded-lg">
                <div class="bg-indigo-100 dark:bg-indigo-900 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-indigo-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 14.094A5.973 5.973 0 004 17v1H1v-1a3 3 0 015-2.906z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">Communities</h3>
                <p class="text-gray-600 dark:text-gray-300">Create and join communities around your interests</p>
            </div>
        </div>
    </div>
</section>

<footer class="py-6 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <p class="text-gray-600 dark:text-gray-400">&copy; 2025 Discord Clone. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
