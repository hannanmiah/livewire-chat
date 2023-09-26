<div class="h-full grid grid-rows-10">
    <div class="row-span-1 bg-gray-200 p-4 text-black inline-flex justify-between items-center">
        <div class="avatar">
            <div class="h-10 w-10 rounded-full ring ring-primary">
                <img src="{{auth()->user()->avatar_url}}" alt="{{auth()->user()->name}}"/>
            </div>
        </div>
        <ul class="inline-flex space-x-2">
            <li class="group">
                <button class="btn btn-sm btn-circle glass group-hover:bg-gray-300">
                    <x-heroicon-o-user-group class="w-6 h-6"/>
                </button>
            </li>
            <li class="group">
                <button class="btn btn-sm btn-circle glass group-hover:bg-gray-300"
                        @click="toggleChat">
                    <x-heroicon-o-plus class="w-6 h-6"/>
                </button>
            </li>
            <li class="group relative" @click.outside="menuOpen = false">
                <button class="btn btn-sm btn-circle glass group-hover:bg-gray-300" @click="toggleMenu">
                    <x-heroicon-o-ellipsis-vertical class="w-6 h-6"/>
                </button>
                <ul class="absolute top-8 right-0 bg-white border w-40 flex flex-col rounded-md" x-show="menuOpen">
                    <li class="border-b">
                        <a href="#" class="flex items-center space-x-2 p-2 hover:bg-gray-200">
                            <x-heroicon-o-cog class="w-4 h-4"/>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li class="border-b">
                        <button wire:click="logout" class="w-full flex items-center space-x-2 p-2 hover:bg-gray-200">
                            <x-heroicon-o-power class="w-4 h-4"/>
                            <span>Logout</span>
                        </button>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="row-span-9 flex flex-col">
        <ul class="flex flex-col py-2 bg-white h-full overflow-scroll">
            @forelse($this->chats as $chat)
                <li class="mx-1 border-b" wire:key="{{$chat->uuid}}">
                    <a href="{{route('chats.view',['chat' => $chat->uuid])}}"
                       @disabled(route('chats.view',['chat' => $chat->uuid]) == request()->url())
                       class="flex space-x-2 md:space-x-4 p-2 items-center hover:bg-gray-200 disabled:pointer-events-none disabled:hover:bg-white"
                       wire:navigate.hover>
                        <div class="avatar">
                            <div class="h-10 w-10 rounded-full ring ring-primary">
                                <img src="{{$chat->image}}" alt="{{$chat->name}}"/>
                            </div>
                        </div>
                        <div class="flex-grow flex space-y-2 flex-col">
                            <div class="flex justify-between items-center">
                                <span class="font-bold">{{$chat->name}}</span>
                                <span class="text-xs">{{$chat->last_message_date}}</span>
                            </div>
                            <span>{{$chat->messages->last()->body}}</span>
                        </div>
                    </a>
                </li>
            @empty
                <li class="mx-4 flex flex-col space-y-4 items-center">
                    <span class="text-xl text-center">No chats yet.</span>
                    <button class="btn btn-primary btn-wide btn-circle" @click="chatOpen = true">Create New
                        Chat
                    </button>
                </li>
            @endforelse
        </ul>
    </div>
    <div class="" wire:ignore>
        @teleport('body')
        <div class="fixed top-0 left-0 w-1/3 h-screen bg-white flex flex-col space-y-2" x-show="chatOpen"
             x-transition:enter="sidebar-enter" x-transition:leave="sidebar-leave"
             x-transition:enter-start="sidebar-enter-start" x-transition:enter-end="sidebar-enter-end"
             x-transition:leave-end="sidebar-leave-end" x-transition:leave-start="sidebar-leave-start">
            <div class="bg-primary flex pt-16 pb-2 px-4 space-x-4 items-center">
                <button class="btn btn-sm btn-circle glass group" @click="toggleChat">
                    <x-heroicon-o-arrow-left class="w-4 h-4 text-white group-hover:text-black"/>
                </button>
                <h2 class="text-white text-xl">New Chat</h2>
            </div>
            <div class="bg-gray-200 p-2 mx-4 flex items-center space-x-2 rounded-l-md">
                <button class="btn btn-sm glass btn-circle">
                    <x-heroicon-o-magnifying-glass class="w-4 h-4"/>
                </button>
                <input type="text" class="input input-sm w-full" placeholder="Search"/>
            </div>
            <form class="flex flex-col space-y-4 flex-grow overflow-scroll" wire:submit="submit">
                <div class="flex flex-col">
                    <div class="flex">
                        <input type="radio" value="private" wire:model.live="type" name="type" id="private_type"
                               class="hidden peer"/>

                        <label for="private_type"
                               class="flex items-center space-x-4 p-4 hover:bg-gray-200 border-b w-full peer-checked:bg-gray-300">
                            <x-heroicon-o-users class="w-10 h-10"/>
                            <span>New Private</span>
                        </label>
                    </div>
                    <div class="flex">
                        <input type="radio" value="group" name="type" wire:model.live="type" id="group_type"
                               class="hidden peer"/>
                        <label for="group_type"
                               class="flex items-center space-x-4 p-4 hover:bg-gray-200 w-full peer-checked:bg-gray-300">
                            <x-heroicon-o-user-group class="w-10 h-10"/>
                            <span>New Group</span>
                        </label>
                    </div>
                </div>
                <div class="flex flex-col space-y-2">
                    <h2 class="text-xl p-4 border-b text-primary">Contacts</h2>
                    <ul class="flex flex-col">
                        @forelse($this->contacts as $contact)
                            <li class="flex items-center" wire:key="{{$contact->uuid}}">
                                <input type="checkbox" name="contacts" wire:model.live="selectedContacts"
                                       value="{{$contact->id}}" id="{{$contact->uuid}}"
                                       class="hidden peer">
                                <label for="{{$contact->uuid}}"
                                       class="w-full flex items-center space-x-4 p-4 border-b hover:bg-gray-200 peer-checked:bg-gray-300">
                                    <div class="avatar">
                                        <div class="h-10 w-10 rounded-full ring ring-primary">
                                            <img src="{{$contact->avatar_url}}" alt="{{$contact->name}}"/>
                                        </div>
                                    </div>
                                    <div class="flex-grow flex flex-col space-y-2">
                                        <h3 class="text-lg">{{$contact->name}}</h3>
                                        <span class="text-xs">Joined {{$contact->created_at}}</span>
                                    </div>
                                </label>
                            </li>
                        @empty
                            <li>No contacts!</li>
                        @endforelse
                    </ul>
                </div>
                <button type="submit" class="absolute bottom-2 left-[50%] btn btn-circle btn-primary"
                        x-show="$wire.selectedContacts.length > 0 && $wire.type">
                    <x-heroicon-o-arrow-right class="w-6 h-6"/>
                </button>
            </form>
        </div>

        @endteleport
    </div>
    <div class="" wire:ignore>
        @teleport('body')
        <div class="fixed z-10 top-0 left-0 h-screen w-1/3 flex flex-col space-y-2" x-show="createChatOpen"
             x-on:chat-created.window="console.log('chat created!')"
             x-transition:enter="sidebar-enter" x-transition:leave="sidebar-leave"
             x-transition:enter-start="sidebar-enter-start" x-transition:enter-end="sidebar-enter-end"
             x-transition:leave-end="sidebar-leave-end" x-transition:leave-start="sidebar-leave-start">
            <livewire:components.create-chat/>
        </div>
        @endteleport
    </div>
</div>
