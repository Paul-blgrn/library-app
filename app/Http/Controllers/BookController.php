<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Backtrace\File;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // on affiche toute la table books avec les catégories, les auteurs,
        // on affiche les articles 5 par 5
        $books = Book::with('categories', 'author')
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->simplePaginate(5);

        return $books;
    }

    /**
     * Display a listing of the resource.
     */
    public function indexID($id)
    {
        // on affiche tout les livres non publiés avec les tables author et catégories (si publié)
        $book = Book::with('categories', 'author')
            ->findOrFail($id);

        return $book;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // on fait valider notre requete
        $rules = [
            'title' => 'bail|required|string|max:255',
            'description' => 'bail|required',
            'content' => 'bail|required',
            'image' => 'mimes:png,jpg',
            'author_id' => 'bail|required|integer',
        ];
        $this->validate($request, $rules);

        // creation d'un nouvel objet Book
        $book = new Book();

        // on récupère les 3 mousquetaires, title, description & content
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->content = $request->input('content');

        // j'ai tenté des choses, lol
        // $finalPath = Str::snake($request->title); // preg_replace('/\s+/', '_', $request->title);
        //$finalPath = str_replace(' ', '_', $request->title);
        //$file->storeAs('images', $finalPath . '.' . $file->extension(), 'public');

        //dd($finalPath);


        // creation de l'image dans le dossier public, génération automatique
        // d'un hash pour chaque image
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('images', 'public');
            $book->image = $path;
        }

        // on récupère l'auteur qui visiblement s'est perdu entre quelques
        // paragraphes de tests
        $book->author_id = $request->input('author_id');

        // nouvelle entrée en BDD, yay !
        $book->save();

        // on indique à l'api qu'on est content car rien à planté
        // return new JsonResponse($book, JsonResponse::HTTP_CREATED);
        // return redirect(route('script.index'));
        return redirect("/api/scripts");
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return $book;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        // validation des règles
        $rules = [
            'title' => 'bail|required|string|max:255',
            'description' => 'bail|required',
            'content' => 'bail|required',
            'image' => 'mimes:png,jpg',
            'author_id' => 'bail|required|integer',
        ];
        $this->validate($request, $rules);

        // on recherche l'id du livre, sinon, on fait tout planter, sinon c'est pas fun
        $book = Book::findOrFail($book->id);

        // le retour des 3 mousquetaires, title, description & content
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->content = $request->input('content');

        // on récupère uniquement le nom et l'extension du fichier
        $imageName = pathinfo($book->image)['basename'];
        //dd($imageName);

        // on verifie si le fichier existe dans le dossier public
        if(file_exists('storage/images/' . $imageName)) {
            // le fichier existe, on le supprime avant d'en recréer un nouveau
            //dd($imageName);
            unlink('storage/images/' . $imageName);
        }

        // on vérifie si un fichier est envoyé
        if($request->hasFile('image')) {
            // Il y'a bien un fichier envoyé, on l'update
            $file = $request->file('image');
            // On créer le fichier dans le dossier storage/images
            $path = $file->store('images', 'public');
            // On update la table image dans la BDD
            $book->image = $path;

        // aucun fichier n'est envoyé, on réinitialise la variable image
        } else {
            // Table image de la BDD sur "null"
            $book->image = null;
        }

        // notre auteur s'est encore perdu, on le récupère
        $book->author_id = $request->input('author_id');

        // On sauvegarde le tout en BDD
        $book->save();

        // On renvoie une réponse JSON côté API
        return new JsonResponse($book, JsonResponse::HTTP_OK);
        //return redirect(route('script.index'));
        //return redirect("/api/scripts");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // on récupère les info du livre
        $deleteBook = Book::findOrFail($book->id);

        // on récupère uniquement le nom et l'extension du fichier
        $imageName = pathinfo($deleteBook->image)['basename'];
        //dd($imageName);

        // on verifie si le fichier existe dans le dossier public
        if(file_exists('storage/images/' . $imageName)) {
            // le fichier existe, on le supprime avant d'en recréer un nouveau
            //dd($imageName);
            unlink('storage/images/' . $imageName);
            // EXPLOSION !!!!! ... non serieusement, on supprime le livre
            $deleteBook->delete();
        }

        // on rassure l'utilisateur de l'api en lui indiquant
        // qu'on est content et qu'il doit l'être
        return new JsonResponse($book, JsonResponse::HTTP_OK);
        //return redirect(route('script.index'));
        //return redirect("/api/scripts");
    }
}
