<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component {

    use WithFileUploads;

    //Definimos variables para el modal
    public $open = false;
    //Definimos variables para la creacion de post
    public $title, $content;
    //Variable para almacenar las imagenes
    public $image;
    //Variable identificador
    public $identificador;

    public function mount(){
        $this->identificador = rand();
    }
    //Definimos variable para asignar validaciones
    protected $rules = [
        'title' => 'required',
        'content' => 'required',
        'image' => 'required|image|max:2048'
    ];

    //Validacion en tiempo real
    /*public function updated($propertyName){
        $this->validateOnly($propertyName);
    }*/

    //Metodo para el guardado de la informacion
    public function save() {

        //Regla de validacion
        $this->validate();

        //LLamamos a la propiedad donde tenemos almacenada la imagen
        $image = $this->image->store('posts');

        Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image' => $image,
        ]);

        //Codigo para poder cerrar modal y limpiar informacion cuando se registre un post nuevo
        $this->reset(['open', 'title', 'content', 'image']);

        $this->identificador = rand();

        $this->emitTo('show-posts', 'render');
        //Evento de alertas
        $this->emit('alert', 'El post se creo satisfactoriamente');

    }

    public function render() {

        return view('livewire.create-post');
    }
}
