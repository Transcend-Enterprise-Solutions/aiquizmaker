<div class="flex items-center justify-center ">
    <!-- Trigger Button -->
    <button 
        wire:click="openModal" 
        class="bg-blue-500 text-white px-4 py-2 rounded shadow flex items-center space-x-2 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"

    >
        Login
    </button>

    <!-- Modal -->
    @if ($showModal)
        <div 
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            aria-modal="true"
            role="dialog"
        >
            <div 
                class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md"
            >
                <!-- Modal Header -->
                <div class="flex justify-between items-center border-b pb-2 mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Welcome back</h2>
                    <button 
                        wire:click="closeModal" 
                        class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none"
                    >
                        &#10005; <!-- Close icon -->
                    </button>
                </div>

                <!-- Social Login Buttons -->
                <div class="flex justify-between mb-4">
                    <!-- Google Button -->
                    <button class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white py-2 rounded shadow-sm hover:bg-gray-200 dark:hover:bg-gray-600 mr-2 flex items-center justify-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-5 h-5">
                            <path fill="#EA4335" d="M24 9.5c3.87 0 7.29 1.39 10.04 3.59l7.51-7.51C36.5 2.3 30.68 0 24 0 14.92 0 7.34 4.79 3.51 11.85l8.62 6.74C14.09 12.8 18.67 9.5 24 9.5z"/>
                            <path fill="#4285F4" d="M48 24c0-1.65-.16-3.25-.46-4.78H24v9.06h13.6C36 31.8 31.53 34.5 24 34.5c-5.33 0-9.91-3.31-12.16-8.14l-8.62 6.74C7.34 43.21 14.92 48 24 48c12.32 0 22.72-8.61 24-20.64l-.02-.18H24v-9.18h24z"/>
                        </svg>
                        <span class="text-sm font-medium">Sign in with Google</span>
                    </button>

                    <!-- Apple Button -->
                    <button class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white py-2 rounded shadow-sm hover:bg-gray-200 dark:hover:bg-gray-600 ml-2 flex items-center justify-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path d="M16.365 1.43c-.923.549-1.727 1.496-1.518 2.599.114.575.672.924 1.262 1.017.989.141 2.045-.736 2.491-1.178.189-.18.317-.407.428-.639.08-.167.145-.344.202-.522-.012-.12-.063-.241-.135-.35-.1-.143-.265-.219-.426-.245-.452-.078-.905-.092-1.338-.076-.06.002-.12.01-.179.018-.149.022-.296.05-.441.085-.05.012-.1.028-.15.041zm-.338 4.168c-.334.097-.646.226-.953.367-.182.086-.363.177-.544.27-.523.262-.991.582-1.371.993-.316.342-.585.726-.841 1.118-.058.085-.116.17-.174.255-.456.67-.864 1.416-1.204 2.183-.046.103-.093.207-.139.311-.197.46-.386.93-.557 1.405-.028.073-.057.146-.085.22-.247.648-.474 1.306-.672 1.974-.06.198-.116.396-.174.594-.345.116-.74.247-1.114.396-1.227.497-2.451 1.007-3.715 1.48-2.139.785-4.192 1.579-6.258 2.363-.217.082-.428.174-.64.265-.308.129-.601.285-.92.373-.04-.086-.11-.164-.156-.246-.1-.175-.155-.378-.22-.57-.124-.371-.23-.748-.295-1.132-.093-.558-.176-1.12-.23-1.683-.073-.743-.086-1.492-.008-2.234.04-.375.08-.75.13-1.125.005-.032.01-.064.015-.096-.05-.062-.098-.124-.144-.187-.255-.357-.435-.756-.59-1.164-.257-.655-.419-1.336-.486-2.026-.04-.442-.05-.889-.022-1.331.02-.316.057-.633.104-.946.095-.599.27-1.178.504-1.737.177-.429.425-.819.759-1.165.055-.06.11-.12.166-.179.036-.038.08-.063.119-.1.416-.379.86-.742 1.316-1.088.535-.412 1.093-.804 1.645-1.193.617-.434 1.247-.835 1.868-1.25.018-.013.038-.024.057-.037.527-.36 1.062-.707 1.599-1.048.15-.097.302-.191.453-.287.056-.035.108-.079.162-.116.73-.485 1.454-.976 2.198-1.418.162-.096.332-.173.503-.258 1.118-.561 2.253-1.089 3.405-1.58.217-.092.433-.178.651-.27.34-.141.68-.288 1.019-.42.281-.111.563-.22.844-.332 2.254-.87 4.498-1.768 6.762-2.637.204-.08.408-.167.611-.252.152-.063.303-.129.456-.19.367-.145.733-.293 1.1-.437.123-.048.247-.097.37-.146.298-.117.596-.236.894-.353.02-.008.04-.015.06-.023 2.413-.93 4.822-1.855 7.236-2.768.137-.053.276-.106.413-.158.072-.027.146-.053.218-.081.318-.117.637-.23.955-.345 1.594-.576 3.189-1.139 4.783-1.711 1.444-.515 2.883-1.037 4.323-1.544.275-.098.55-.197.824-.295.314-.112.63-.217.944-.33.001-.001-.042.045-.049.046-.001.001-.013.002-.014.003-.396.142-.795.27-1.19.409-.14.05-.283.091-.423.138-2.74.94-5.49 1.859-8.232 2.801-.403.138-.805.278-1.21.41-.207.07-.413.144-.62.212-1.426.487-2.851.975-4.283 1.449-.174.057-.349.112-.523.168-1.085.35-2.17.695-3.258 1.044-.202.064-.406.127-.61.191-.66.207-1.32.412-1.982.617-.126.039-.251.079-.378.118-.308.095-.616.186-.926.278-.02.006-.041.011-.061.017z"></path>
                        </svg>
                        <span class="text-sm font-medium">Sign in with Apple</span>
                    </button>
                </div>


                <div class="text-center text-gray-500 dark:text-gray-400 mb-4">or</div>

                <!-- Login Form -->
                <form wire:submit.prevent="login">
                    <div class="relative mb-6">
                        <input 
                            type="email" 
                            id="email" 
                            wire:model="email" 
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                            placeholder=" "
                        />
                        <label 
                            for="email" 
                            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4"
                        >
                            Email
                        </label>
                        @error('email') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="relative mb-6">
                        <input 
                            type="password" 
                            id="password" 
                            wire:model="password" 
                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                            placeholder=" "
                        />
                        <label 
                            for="password" 
                            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4"
                        >
                            Password
                        </label>
                        @error('password') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Remember Me and Forgot Password -->
                    <div class="flex justify-between items-center mb-6">
                        <label class="inline-flex items-center">
                            <input 
                                type="checkbox" 
                                wire:model="rememberMe" 
                                class="text-blue-500 form-checkbox border-gray-300 rounded"
                            >
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                        </label>
                        <a 
                            href="#" 
                            class="text-sm text-blue-500 hover:underline dark:text-blue-400"
                        >
                            Forgot password?
                        </a>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col space-y-2">
                        <button 
                            type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        >
                            Sign in to your account
                        </button>
                        <p class="text-sm text-center text-gray-600 dark:text-gray-400">
                            Don't have an account? 
                            <a href="#" class="text-blue-500 hover:underline dark:text-blue-400">Sign up</a>
                        </p>
                    </div>
                </form>

                <!-- Flash Messages -->
                @if (session()->has('message'))
                    <p class="text-green-500 mt-4">{{ session('message') }}</p>
                @endif
                @if (session()->has('error'))
                    <p class="text-red-500 mt-4">{{ session('error') }}</p>
                @endif
            </div>
        </div>
    @endif
</div>
