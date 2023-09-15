<div class="flex flex-col justify-center items-center"
     x-on:form-submitted.window="toggleQuote" x-on:quote-submitted.window="console.log('toggle quote')">
    <button class="btn btn-primary mt-8" @click="modalOpen = true">Sign Up</button>
    <button class="btn btn-primary mt-8" @click="quoteOpen = true">Quote</button>
    <button class="btn btn-primary mt-8" wire:click="$refresh">Refresh</button>
    @teleport('body')
    <div class="fixed top-0 left-0 right-0 h-screen w-screen" x-show="modalOpen">
        <div class="h-full w-full bg-black/50"></div>
        <livewire:components.test-form/>
    </div>
    @endteleport
    @teleport('body')
    <div class="" x-show="quoteOpen">
        <livewire:components.test-modal/>
    </div>
    @endteleport
</div>
