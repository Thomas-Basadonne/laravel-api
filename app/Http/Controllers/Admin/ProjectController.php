<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(25);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $types = Type::all();
        return view('admin.projects.create', compact('project', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validation($request->all());
         // controllo presenza un'file image
         if (Arr::exists($data, 'image')) {
            $path = Storage::put('uploads/project', $data['image']);
        }
        $project = new Project;
        $project->fill($data);
        $project->image = $path;
        $project->save();
        return to_route('admin.projects.show', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        return view('admin.projects.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $data = $this->validation($request->all(), $project->id);
        if (Arr::exists($data, 'image')) {
            if ($project->image) Storage::delete($project->image);
            $path = Storage::put('uploads/project', $data['image']);
        }

        $project->fill($data);
        $project->image = $path;
        $project->save();        
        return to_route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project->image) Storage::delete($project->image);
        $project->delete();
        return to_route('admin.projects.index');
    }

    private function validation($data)
    {

        return Validator::make(
            $data,
            [
                'name' => 'required',
                'description' => 'required',
                'programming_languages' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'image' => 'nullable|image|mimes:jpg,jpeg,png',
                'type_id' => 'nullable|exists:types,id'
            ],
            [
                'name.required' => 'Il nome è obbligatorio',
                'description.required' => "La descrizione è obbligatoria",
                'programming_languages.required' => "I linguaggi utilizzati sono obbligatori",
                'start_date.required' => "Inserire la data di inizio",
                'end_date.required' => "Inserire la data di fine",
                'image.image' => "Il file inserito deve essere un'immagine",
                'image.mimes' => "Il file deve essere:jpg,jpeg,png"
            ]
        )->validate();
    }
}