<div class="grid grid-cols-12" x-data="home" @notification.window="$wire.refreshKey">
    <aside class="col-span-4 h-screen hidden md:block">
        <livewire:components.navigation :key="$key"/>
    </aside>
    <main class="col-span-8 h-screen grid grid-rows-10">
        <div class="bg-gray-200 grid place-items-center row-span-full">
            <h1 class="text-xl">Welcome to Livewire Chat!</h1>
        </div>
    </main>
</div>

@push('scripts')
    <script>
        window.addEventListener('livewire:init', () => {
            window.addEventListener('alpine:init', () => {
                Alpine.data('home', () => {
                    return {
                        init() {
                            this.user = {{ Js::from(auth()->user()) }}
                            joinUser(this.user.uuid)
                        },
                        user: {},
                    }
                })
            })
        })

        function joinUser(userUUID) {
            Echo.private(`users.${userUUID}`)
                .listen('UserUpdated', (e) => {
                    console.log(e)
                })
                .notification((notification) => {
                    console.log(notification)
                    Livewire.dispatch('notification', {message: notification.message})
                })
                .error((error) => {
                    console.log(error)
                })
        }
    </script>
@endpush
