<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class ShowPosts extends Component {

    use WithFileUploads;
    use WithPagination;

    public $post, $image, $identificador;
    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';
    public $cantidad = '25';
    //Variable para insertar un spinner de carga
    public $readyToLoad = false;

    public $open_edit = false;

    //Propiedad para pasar las cantidades por URL
    protected $queryString = [
        'cantidad' => ['except' => '25'],
        'sort' => ['except' => 'id'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => '']
    ];

    public function mount() {
        $this->identificador = rand();
        $this->post = new Post();
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    //Regla de validacion para sincronizar los datos con los inputs
    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];

    protected $listeners = ['render'];

    public function render() {

        if($this->readyToLoad){
            //Los simbolos de porcentaje sirven para buscar coincidencias antes y despues de las busquedas
            $posts = Post::where('title', 'like', '%'. $this->search. '%')
                ->orwhere('content', 'like', '%'. $this->search. '%')
                ->orderBy($this->sort, $this->direction)
                //Paginacion de post
                ->paginate($this->cantidad);
        } else {
            $posts = [];
        }

        return view('livewire.show-posts', compact('posts'));
    }

    public function loadPost(){
        $this->readyToLoad = true;
    }

    public function order($sort) {

        if ($this->sort == $sort) {

            if ($this->direction == 'desc') {
                $this->direction = 'asc';
        } else {
            $this->direction = 'desc';
        }
        } else {
            $this->sort == $sort;
            $this->direction = 'asc';
        }
    }

    public function edit(Post $post) {
        $this->post = $post;
        $this->open_edit = true;
    }

    public function update(){
        //Regla de validacion
        $this->validate();

        if ($this->image){
            Storage::delete([$this->post->image]);
            $this->post->image = $this->image->store('posts');
        }

        $this->post->save();

         //Codigo para poder cerrar modal y limpiar informacion cuando se actualice un post nuevo
         $this->reset(['open_edit', 'image']);


        $this->identificador = rand();

           //Evento de alertas
        $this->emit('alert', 'El post se actualizo satisfactoriamente');
    }
}
