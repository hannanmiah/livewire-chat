<div class="h-screen w-screen fixed top-0 left-0 right-0">
    <div class="h-full w-full bg-black/25"></div>
    <form class="bg-white p-4 absolute top-1/4 left-1/4 right-1/4 grid place-content-center gap-4" wire:submit="submit"
          @click.outside="toggleQuote">
        <div class="flex flex-col space-y-2">
            <label for="quote">Quote</label>
            <input id="quote" type="text" class="input input-bordered" wire:model.live="quote">
        </div>
        <button class="btn btn-primary">Submit</button>
    </form>
</div>
