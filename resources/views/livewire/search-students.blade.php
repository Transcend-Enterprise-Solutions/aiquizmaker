<div>
    <input wire:model.live="search" type="text" placeholder="Search students..." class="form-input" />

    <div class="mt-2">
        @foreach ($users as $user)
            <div class="p-2 border-b">
                {{ $user->name }}
            </div>
        @endforeach
    </div>
</div>