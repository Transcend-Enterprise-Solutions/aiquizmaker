<div x-data="{
        students: [],
        async fetchStudents() {
            try {
                const response = await fetch('{{ route('get-students') }}');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                this.students = data.map(student => ({
                    name: student.name,
                    initials: this.getInitials(student.name),
                }));
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            }
        },
        getInitials(name) {
            const nameParts = name.split(' ');
            const firstInitial = nameParts[0]?.charAt(0).toUpperCase() || '';
            const lastInitial = nameParts[1]?.charAt(0).toUpperCase() || '';
            return firstInitial + lastInitial;
        }
    }"
    x-init="fetchStudents()"
    class="flex items-center space-x-4"
>
    <div class="flex -space-x-3">
        <!-- Dynamically Render Student Initials -->
        <template x-for="(student, index) in students" :key="index">
            <div
                class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 border-2 border-white rounded-full dark:bg-gray-600"
            >
                <span
                    class="font-medium text-gray-600 dark:text-gray-300"
                    x-text="student.initials"
                ></span>
            </div>

        </template>
        
    </div>
    <span class="ml-6 text-gray-200 text-lg">
        Over <span class="font-bold text-white" x-text="students.length + ' Student(s)'"></span>
    </span>
</div>
