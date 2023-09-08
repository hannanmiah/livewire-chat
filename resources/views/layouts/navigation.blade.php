<div class="row-span-1 bg-gray-200 p-4 text-black inline-flex justify-between items-center">
        <span>
            <x-heroicon-o-user-circle class="w-10 h-10"/>
        </span>
    <ul class="inline-flex space-x-2">
        <li class="group">
            <button class="btn btn-sm btn-circle glass group-hover:bg-gray-300">
                <x-heroicon-o-user-group class="w-6 h-6"/>
            </button>
        </li>
        <li class="group">
            <button class="btn btn-sm btn-circle glass group-hover:bg-gray-300"
                    x-on:click="newChatModalOpen = !newChatModalOpen">
                <x-heroicon-o-plus class="w-6 h-6"/>
            </button>
        </li>
        <li class="group relative" x-data="{ menuOpen: false }">
            <button class="btn btn-sm btn-circle glass group-hover:bg-gray-300" x-on:click="menuOpen = !menuOpen">
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
                    <a href="#" class="flex items-center space-x-2 p-2 hover:bg-gray-200">
                        <x-heroicon-o-power class="w-4 h-4"/>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<div class="row-span-9 flex flex-col">
    <ul class="flex flex-col py-2 bg-white">
        <li class="mx-1">
            <a href="{{route('chats.view',['chat' => 1])}}"
               class="flex space-x-2 p-2 items-center hover:bg-gray-200" wire:navigate.hover>
                <span><x-heroicon-o-user-circle class="h-8 w-8"/></span>
                <div class="flex-grow flex flex-col">
                    <div class="flex justify-between">
                        <span class="font-bold">Mahmodul Hasan</span>
                        <span class="text-xs">10:00 AM</span>
                    </div>
                    <span class="text-xs">Hello, how are you?</span>
                </div>
            </a>
        </li>
    </ul>
</div>

<template x-teleport="body">
    <div class="fixed top-0 left-0 w-96 h-screen bg-white flex flex-col space-y-2" x-show="newChatModalOpen">
        <div class="bg-primary flex pt-16 pb-2 px-4 space-x-2 items-center">
            <button class="btn btn-sm btn-circle glass group" x-on:click="newChatModalOpen = false">
                <x-heroicon-o-arrow-left class="w-4 h-4 text-white group-hover:text-black"/>
            </button>
            <h2 class="text-white text-xl">New Chat</h2>
        </div>
        <div class="flex flex-col space-y-4">
            <div class="bg-gray-200 p-2 mx-4 flex items-center space-x-2 rounded-l-md">
                <button class="btn btn-sm glass btn-circle">
                    <x-heroicon-o-magnifying-glass class="w-4 h-4"/>
                </button>
                <input type="text" class="input input-sm w-full" placeholder="Search"/>
            </div>
            <div class="flex flex-col">
                <a href="#" class="flex items-center space-x-4 p-4 hover:bg-gray-200">
                    <x-heroicon-o-users class="w-10 h-10"/>
                    <h3>New Private</h3>
                </a>
                <a href="#" class="flex items-center space-x-4 p-4 hover:bg-gray-200">
                    <x-heroicon-o-user-group class="w-10 h-10"/>
                    <h3>New Group</h3>
                </a>
            </div>
        </div>
    </div>
</template>

