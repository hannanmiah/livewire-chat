<footer class="row-span-1">
    <form class="bg-white flex items-center px-4 py-2 space-x-4" wire:submit="submit">
        <button type="button" class="btn btn-circle">
            <x-heroicon-o-plus-circle class="h-8 w-8"/>
        </button>
        <input wire:model="body" type="text" class="input w-full" placeholder="Type a message"
               wire:keydown.enter="submit" x-init="$el.focus()" @input="$store.auth.startTyping()"
               @blur="$store.auth.stopTyping()"/>
        <button wire:target="submit" type="submit" class="btn btn-circle" wire:loading.attr="disabled">
            <x-heroicon-o-paper-airplane class="h-8 w-8"/>
        </button>
    </form>
</footer>
