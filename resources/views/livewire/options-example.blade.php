<div class="bg-gray-50 min-h-screen pt-16 text-gray-700">
    <div class="max-w-3xl w-full mx-auto">
        <div class="text-xl font-bold mb-8">
            Options question example form (<a href="https://github.com/filamentphp/filament/discussions/8191"
                class="underline" target="_blank">question link</a>) (<a
                href="https://github.com/henninghorn/filament-v3-options-question" class="underline" target="_blank">source
                repo</a>)
        </div>
        <div class="h-8">
            <div wire:loading wire:target="data">
                Form data is updating...
            </div>
        </div>
        {{ $this->form }}
    </div>
</div>
