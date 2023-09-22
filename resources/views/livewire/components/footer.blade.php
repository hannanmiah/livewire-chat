<footer class="row-span-1">
    <div class="bg-white flex items-center px-4 py-2 space-x-4">
        <button type="button" class="btn btn-circle">
            <x-heroicon-o-plus-circle class="h-8 w-8"/>
        </button>
        <input wire:model="body" type="text" id="message-input" class="input w-full"
               placeholder="Type a message"
               wire:keydown.enter="submit" x-init="$el.focus()"
               @input="$dispatch('typing-started', { text: $el.value })"
               @blur="$dispatch('typing-stopped')"/>
        <label for="message-input" class="sr-only">Write a message</label>
        <button wire:click="submit" class="btn btn-circle">
            <x-heroicon-o-paper-airplane class="h-8 w-8"/>
        </button>
    </div>
</footer>
