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
                        &#10005;
                    </button>
                </div>

                <!-- Login Form -->
                <form wire:submit.prevent="login">
                    <!-- Email Input -->
                    <div class="mb-4">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                                </svg>
                            </span>
                            <input 
                                type="email" 
                                id="email" 
                                wire:model="email" 
                                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder="example@domain.com"
                            >
                        </div>
                        @error('email') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="mb-4">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 8h-1V6a5 5 0 0 0-10 0v2H5a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V11a3 3 0 0 0-3-3ZM8 6a4 4 0 0 1 8 0v2H8Zm10 14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V11a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2Z"/>
                            </svg>
                            </span>
                            <input 
                                type="password" 
                                id="password" 
                                wire:model="password" 
                                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder="••••••••"
                            >
                        </div>
                        @error('password') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="flex flex-col space-y-2">
                        <!-- Login Button -->
                        <button 
                            type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 flex items-center justify-center"
                            wire:loading.attr="disabled" 
                            wire:target="login"
                        >
                            <span class="flex items-center">
                                <!-- Spinner and Processing Text -->
                                <svg 
                                    wire:loading 
                                    wire:target="login" 
                                    class="w-4 h-4 mr-2 text-white animate-spin" 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    fill="none" 
                                    viewBox="0 0 24 24"
                                >
                                    <circle 
                                        class="opacity-25" 
                                        cx="12" 
                                        cy="12" 
                                        r="10" 
                                        stroke="currentColor" 
                                        stroke-width="4"
                                    ></circle>
                                    <path 
                                        class="opacity-75" 
                                        fill="currentColor" 
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                    ></path>
                                </svg>
                                <span wire:loading wire:target="login">Processing...</span>
                                <span wire:loading.remove wire:target="login">Sign in to your account</span>
                            </span>
                        </button>

                        <!-- Success Message -->
                        <div 
                            x-data="{ showSuccess: false }" 
                            x-init="@this.on('login-success', () => { showSuccess = true; setTimeout(() => showSuccess = false, 3000); })"
                            x-show="showSuccess" 
                            class="mt-4 text-center text-green-500 font-semibold text-sm animate-fade-in"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-90"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-90"
                        >
                            Login Successful!
                        </div>
                    </div>



                </form>
            </div>
        </div>
    @endif
</div>

