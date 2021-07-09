<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditPost extends Component {

    use WithFileUploads;

    public $open = false;

    public $post;

    //Variable para almacenar las imagenes
    public $image;

    //Variable identificador
    public $identificador;

    //Regla de validacion para sincronizar los datos con los inputs
    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];

    public function mount(Post $post) {

        $this->post = $post;

        $this->identificador = rand();
    }

    //Metodo de guardado de la informacion
    public function save() {

        //Regla de validacion
        $this->validate();

        if ($this->image){
            Storage::delete([$this->post->image]);
            $this->post->image = $this->image->store('posts');
        }

        $this->post->save();

         //Codigo para poder cerrar modal y limpiar informacion cuando se actualice un post nuevo
         $this->reset(['open', 'image']);


        $this->identificador = rand();

         $this->emitTo('show-posts', 'render');

           //Evento de alertas
        $this->emit('alert', 'El post se actualizo satisfactoriamente');
    }

    public function render() {
        return view('livewire.edit-post');
    }
}
