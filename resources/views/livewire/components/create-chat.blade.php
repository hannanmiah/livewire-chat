<div class="flex flex-col space-y-2 bg-white h-screen" x-on:chat-created="toggleCreateChat">
    <div class="bg-primary flex pt-16 pb-2 px-4 space-x-4 items-center">
        <button class="btn btn-sm btn-circle glass group" @click="toggleCreateChat">
            <x-heroicon-o-arrow-left class="w-4 h-4 text-white group-hover:text-black"/>
        </button>
        <h2 class="text-white text-xl">Create New {{strtoupper($type)}} Chat</h2>
    </div>
    <form wire:submit="submit" class="flex flex-col space-y-4 p-4">
        <div class="flex flex-col space-y-2">
            <label for="type_select">Chat type:</label>
            <select name="type" id="type_select" wire:model.live="type" class="select select-bordered w-full">
                <option disabled>Select chat type</option>
                <option value="private" @disabled(count($selectedContacts) > 1)>Private</option>
                <option value="group">Group</option>
            </select>
            @error('type') <span class="text-xs text-error">{{$message}}</span> @enderror
        </div>
        <div class="flex flex-col space-y-2">
            <h3>Contacts</h3>
            <ul class="grid grid-cols-6 gap-4">
                @foreach($contacts as $contact)
                    <li wire:key="{{$contact->uuid}}" class="grid place-items-center">
                        <input type="checkbox" name="selectedContacts" id="{{$contact->name.$contact->uuid}}"
                               value="{{$contact->id}}"
                               wire:model.live="selectedContacts" class="hidden peer">
                        <label for="{{$contact->name.$contact->uuid}}"
                               class="avatar ring-gray-200 peer-checked:ring-primary tooltip tooltip-bottom tooltip-warning"
                               data-tip="{{$contact->name}}">
                            <div
                                class="h-10 w-10 rounded-full ring ring-inherit">
                                <img src="{{$contact->avatar_url}}" alt="{{$contact->name}}"/>
                            </div>
                        </label>
                    </li>
                @endforeach
            </ul>
            @error('selectedContacts') <span class="text-xs text-error">{{$message}}</span> @enderror
        </div>
        <div class="flex flex-col space-y-2">
            <label for="name">Chat name:</label>
            <input type="text" name="name" id="name" wire:model.live="name"
                   class="input input-bordered w-full" @disabled($type == 'private')>
            @error('name') <span class="text-xs text-error">{{$message}}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">
            Create
            <x-heroicon-o-arrow-path class="w-4 h-4 animate-spin" wire:target="submit" wire:loading/>
        </button>
    </form>
</div>
