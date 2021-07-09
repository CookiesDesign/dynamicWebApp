    <div>
        <!-- Boton con metodo magico-->
        <x-jet-danger-button wire:click="$set('open', true)">
            Crear nuevo post
        </x-jet-danger-button>

        <!-- Incluimos el componente de Jetstream para la ventana modal-->
        <x-jet-dialog-modal wire:model="open">

            <x-slot name="title">
                Crear nuevo post
            </x-slot>

            <x-slot name="content">

                <!---Alerta para el momento en que se carguen imagenes-->
                <div wire:loading wire:target="image" class=" mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">¡Imagen cargando!</strong>
                    <span class="block sm:inline">Espere un momento hasta que la imagen se haya procesado.</span>
                </div>

                @if ($image)
                    <img class="mb-4" src="{{$image->temporaryUrl()}}">
                @endif

                <div class="mb-4">
                    <x-jet-label value="Titulo del post" />
                    <x-jet-input type="text" class="w-full" wire:model="title"/>

                    <!--Componente de livewire para errores-->
                    <x-jet-input-error for="title"/>

                </div>

                <div class="mb-4">
                    <x-jet-label value="Contenido del post" />
                    <textarea wire:model.defer="content" class="form-control w-full" rows="6"></textarea>

                    <!--Componente de livewire para errores-->
                    <x-jet-input-error for="content"/>

                </div>

                <div>
                    <input type="file" wire:model="image" id="{{$identificador}}">
                    <!--Componente de livewire para errores-->
                    <x-jet-input-error for="image"/>
                </div>

            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$set('open', false)">
                    Cancelar
                </x-jet-secondary-button>
                <!-- Lading.Remove para ocultar el boton mientras se ejecuta el proceso y se carga una imagen-->
                <x-jet-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save, image" class="disabled:opacity-25">
                    Crear post
                </x-jet-danger-button>

                <!-- Boton para los estados de carga
                <span wire:loading wire:target="save"> Cargando...</span> -->
            </x-slot>

        </x-jet-dialog-modal>

    </div>
