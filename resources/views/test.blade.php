<x-app-layout>
    <div class="flex flex-col space-y-4 py-8" x-on:form-submitted.window="console.log('from component outside')">
        <livewire:components.test-component/>
    </div>
</x-app-layout>
