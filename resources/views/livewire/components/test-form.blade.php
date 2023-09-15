<div class="w-full h-full grid place-items-center absolute top-0 left-0 right-0"
     x-on:form-submitted="console.log('inside component')">
    @if(session('message'))
        <div class="alert alert-success mx-auto">
            {{session('message')}}
        </div>
    @endif
    <form class="bg-white rounded-md min-w-md flex flex-col space-y-4 p-4" wire:submit="submit"
          @click.outside="modalOpen = false">
        <div class="flex flex-col space-y-2" x-id="['name']">
            <label :for="$id('name')">Name</label>
            <input :id="$id('name')" type="text" class="input input-bordered" wire:model.live="form.name"
                   wire:dirty.class="input-error"
                   placeholder="Name"/>
            @error('form.name') <span class="text-xs text-error">{{$message}}</span> @enderror
        </div>
        <div class="flex flex-col space-y-2" x-id="['age']">
            <label :for="$id('age')">Age</label>
            <input :id="$id('age')" type="number" class="input input-bordered" wire:model.blur="form.age"
                   placeholder="Age"/>
            @error('form.age') <span class="text-xs text-error">{{$message}}</span> @enderror
        </div>
        <div class="flex flex-col space-y-2" x-id="['occupation']">
            <label for="occupation">Occupation</label>
            <select class="select" id="occupation" wire:model.blur="form.occupation">
                <option selected>Select occupation</option>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
                <option value="doctor">Doctor</option>
                <option value="engineer">Engineer</option>
            </select>
            @error('form.occupation') <span class="text-xs text-error">{{$message}}</span> @enderror
        </div>
        <div class="flex flex-col space-y-4">
            <div class="flex space-x-4 items-center" x-id="['term']">
                <input :id="$id('term')" type="checkbox" name="term" value="agree" wire:model.blur="form.term"
                       class="checkbox">
                <label :for="$id('term')" class="label cursor-pointer">I agree to the terms and conditions</label>
            </div>
            @error('form.term') <span class="text-xs text-error">{{$message}}</span> @enderror
        </div>
        <button class="btn btn-primary btn-circle w-full">Submit</button>
    </form>
</div>
