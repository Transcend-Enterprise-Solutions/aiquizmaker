<div>
    @if ($selectedSubject)
        <div class="p-6 bg-white shadow rounded-lg">
            <!-- Subject Title and Description -->
            <h2 class="text-2xl font-bold mb-4">{{ $selectedSubject->name }}</h2>
            <p class="text-gray-600 mb-6">{{ $selectedSubject->description ?? 'No description available.' }}</p>

            <!-- Quizzes Section -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-3">Quizzes and Student Performance</h3>
                @if (!$selectedSubject->quizzes || $selectedSubject->quizzes->isEmpty())
                    <p class="text-gray-500">No quizzes available for this subject.</p>
                @else
                    @foreach ($selectedSubject->quizzes as $quiz)
                        <div class="p-6 bg-blue-50 border-l-4 border-blue-500 shadow rounded-lg mb-6">
                            <!-- Quiz Title -->
                            <h4 class="text-lg font-bold text-blue-700 mb-4">{{ $quiz->quiz_name }}</h4>

                            <!-- Student Performance for Each Quiz -->
                            @if (!$quiz->studentResults || $quiz->studentResults->isEmpty())
                                <p class="text-gray-500 text-center">No students have taken this quiz yet.</p>
                            @else
                                <table class="w-full bg-white border border-gray-300 rounded">
                                    <thead>
                                        <tr class="bg-gray-200 text-left">
                                            <th class="border px-4 py-2">Student Name</th>
                                            <th class="border px-4 py-2">Score</th>
                                            <th class="border px-4 py-2">Percentage</th>
                                            <th class="border px-4 py-2">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($quiz->studentResults as $result)
                                            <tr>
                                                <td class="border px-4 py-2">{{ $result->student->name ?? 'Unknown Student' }}</td>
                                                <td class="border px-4 py-2">{{ $result->score }}</td>
                                                <td class="border px-4 py-2">{{ $result->percentage }}%</td>
                                                <td class="border px-4 py-2">
                                                    <span class="px-2 py-1 rounded-full text-white {{ $result->status == 'Pass' ? 'bg-green-500' : 'bg-red-500' }}">
                                                        {{ $result->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Quiz Performance Graph -->
            <div class="mt-6">
                <h3 class="text-xl font-semibold mb-3">Quiz Performance Graph</h3>
                <canvas id="quizPerformanceChart"></canvas>
                <p id="noDataMessage" class="text-gray-500 hidden">No data available for the graph.</p>
            </div>

            <!-- Back Button -->
            <button 
                wire:click="$set('selectedSubject', null)" 
                class="mt-6 px-6 py-3 bg-blue-500 text-white font-medium rounded-lg shadow hover:bg-blue-600">
                Back to Subjects
            </button>
        </div>
    @else
        <!-- Subject List -->
        <div>
            <input 
                type="text" 
                wire:model.debounce.500ms="search" 
                placeholder="Search subjects..." 
                class="mb-4 p-2 border rounded w-full"
            />

            @if (!$subjects || $subjects->isEmpty())
                <p class="text-gray-500">No subjects found.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach ($subjects as $subject)
                        <li class="py-4 flex justify-between items-center">
                            <div>
                                <p class="font-medium text-lg">{{ $subject->name }}</p>
                                <p class="text-sm text-gray-500">{{ $subject->description ?? 'No description' }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <button 
                                    wire:click="viewSubject({{ $subject->id }})" 
                                    class="text-blue-500 hover:underline">
                                    View
                                </button>
                                <button 
                                    wire:click="deleteSubject({{ $subject->id }})" 
                                    class="text-red-500 hover:underline">
                                    Delete
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <!-- Pagination Links -->
                <div class="mt-6">
                    {{ $subjects->links() }}
                </div>
            @endif
        </div>
    @endif
</div>

<!-- Chart.js Script -->
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            let chartInstance = null;

            Livewire.on('refreshChart', (labels, data) => {
                console.log("Labels:", labels);
                console.log("Data:", data);

                const ctx = document.getElementById('quizPerformanceChart');
                const noDataMessage = document.getElementById('noDataMessage');

                if (labels.length === 0 || data.every(score => score === 0)) {
                    ctx.style.display = 'none';
                    noDataMessage.classList.remove('hidden');
                    return;
                }

                ctx.style.display = 'block';
                noDataMessage.classList.add('hidden');

                // Destroy existing chart instance if it exists
                if (chartInstance) {
                    chartInstance.destroy();
                }

                chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Average Score',
                            data: data,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        });
    </script>
@endpush
