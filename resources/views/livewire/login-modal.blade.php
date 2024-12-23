<div>
    <!-- Trigger Button -->
    <button 
        wire:click="openModal" 
        class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
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
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Login</h2>
                    <button 
                        wire:click="closeModal" 
                        class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none"
                    >
                        &#10005; <!-- Close icon -->
                    </button>
                </div>

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

                    <!-- Actions -->
                    <div class="flex justify-end space-x-2">
                        <button 
                            type="button" 
                            wire:click="closeModal" 
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        >
                            Login
                        </button>
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
