<header class="row-span-1 bg-gray-200 p-4 text-black flex space-x-2 md:space-x-4 items-center">
    <button class="btn btn-sm glass md:hidden" @click="toggleNavigation">
        <x-heroicon-o-bars-3 class="w-6 h-6"/>
    </button>
    <div class="avatar">
        <div class="h-10 w-10 rounded-full ring ring-primary">
            <img src="{{$chat->image}}" alt="{{$chat->name}}"/>
        </div>
    </div>
    <ul class="flex flex-grow flex-col space-y-1">
        <li class="font-bold text-lg">{{$chat->name}}</li>
        <li class="text-sm">Online</li>
    </ul>
    <div class="flex space-x-2">
        <button class="btn btn-sm glass">
            <x-heroicon-o-magnifying-glass class="w-4 h-4"/>
        </button>
        <button class="btn btn-sm glass">
            <x-heroicon-o-ellipsis-vertical class="w-4 h-4"/>
        </button>
    </div>
</header>
