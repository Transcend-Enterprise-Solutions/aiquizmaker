<div x-data="{ openModal: false, quiz: null }">
    <!-- Trigger Button -->
    <button @click="openModal = true; quiz = {{ $quiz }}" 
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        View Quiz
    </button>

    <!-- Modal Overlay -->
    <div 
        x-show="openModal" 
        x-transition.opacity 
        class="fixed inset-0 bg-black/50 z-40" 
        @click="openModal = false">
    </div>

    <!-- Modal Content -->
    <div 
        x-show="openModal" 
        x-transition 
        @keydown.escape.window="openModal = false" 
        class="fixed inset-0 flex items-center justify-center z-50 p-6">
        <div class="bg-white rounded-3xl shadow-xl max-w-4xl w-full p-8 space-y-8">
            <!-- Modal Header -->
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">
                    <span x-text="quiz.quiz_name"></span>
                </h1>
                <button @click="openModal = false" 
                    class="text-gray-600 hover:text-gray-900 focus:outline-none">
                    &times;
                </button>
            </div>

            <!-- Quiz Content -->
            <section class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-2xl shadow-xl p-6">
                <h1 class="text-5xl font-extrabold leading-tight">
                    <span x-text="quiz.quiz_name"></span>
                </h1>
                <p class="text-lg font-medium mt-4">
                    Duration: <span class="font-semibold" x-text="quiz.duration + ' minutes'"></span>.
                </p>
            </section>

            <!-- Questions -->
            <section>
                <h2 class="text-xl font-bold text-gray-900">Questions</h2>
                <template x-for="(question, index) in quiz.quizzes" :key="index">
                    <div class="mt-4 p-4 bg-gray-100 rounded-lg shadow">
                        <p class="font-semibold">Question <span x-text="index + 1"></span>:</p>
                        <p x-text="question.question" class="mt-2"></p>
                    </div>
                </template>
            </section>

            <!-- Modal Footer -->
            <div class="text-right">
                <button @click="openModal = false" 
                    class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700 transition">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
    