<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use App\Category;
use App\Speaker;
use App\Sponser;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
// use Barryvdh\Debugbar\Debugbar;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the company dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(auth()->user()->hasRole('user'), 403);

        $query = QueryBuilder::for(Event::class)
                ->latest()
                ->allowedFilters(
                    [
                        'title',
                        'venue_name', 
                        // AllowedFilter::exact('title'),  
                        AllowedFilter::scope('starts_at')
                    ])
                ->allowedFields(['id', 'cover', 'title', 'price', 'start', 'venue_name'])
                ->allowedSorts(['title', 'created_at'])
                ->paginate(10)
                ->appends(request()->query());
     
        \Debugbar::info($query);
        $events   = $query->items();
        $total    = $query->total();
        $first    = $query->firstItem();
        $last     = $query->lastItem();
        $previous     = $query->previousPageUrl();
        $next     = $query->nextPageUrl();
        
        return view('admin.events.index', compact('events', 'total', 'first', 'last', 'previous', 'next'));
    }

    /** Create Page */
    public function create(Request $request)
    {
        abort_if(!auth()->user()->can('add events'), 403);

        $categories     = Category::latest()->get();
        $speakers       = Speaker::latest()->get();
        $sponsers       = Sponser::latest()->get();
        return view('admin.events.create', compact('categories', 'speakers', 'sponsers'));
    }

    /** Store */
    public function store(Request $request)
    {
        // dd($request->all());
        abort_if(!auth()->user()->can('add events'), 403);

        $data = $request->validate([
            'speakers'            => 'required|array',
            'sponsers'            => 'required|array',
            'title'               => 'required|string|min:2',
            'category'            => 'required|numeric', 
            'cover'               => 'required|file', 
            'sub_title'           => 'required|string', 
            'price'               => 'required|numeric', 
            'start'               => 'required|date', 
            'time'                => 'required', 
            'end'                 => 'required|date', 
            'book_before'         => 'required', 
            'ticket'              => 'required|numeric', 
            'description'         => 'required', 
            'venue_name'          => 'required|string', 
            'venue_full_address'  => 'required|string', 
        ]);

        // dd($data);
        // dd($request->file('cover'));
           


        $allowedfileExtension = ['jpeg','jpg','png','gif'];
        $file      = $request->file('cover'); 
        // // foreach($files as $file){
        $filename  = $file->getClientOriginalName();

        $extension = $file->getClientOriginalExtension();

        $check     = in_array($extension, $allowedfileExtension);
        abort_if(!$check, 422);

        if(!is_dir(public_path('/events'))){
            mkdir(public_path('/events'), 0777);
        }

        // dd($file);
        //Real Image;
        $basename  = Str::random();
        $original  = 'ev-' . $basename . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('/events'), $original);
        $path = '/events/' . $original;     

        // echo $original . ' ' . $thumbnail;

        $event = Event::create([
            'user_id'             => auth()->user()->id,
            'category_id'         => $data['category'],
            'title'               => $data['title'],
            'slug'                => Str::slug($data['title']),
            'cover'               => $path, 
            'thumbnail'           => $path, 
            'sub_title'           => $data['sub_title'], 
            'price'               => $data['price'],
            'start'               => $data['start'],
            'time'                => $data['time'],
            'end'                 => $data['end'],
            'book_before'         => $data['book_before'],
            'ticket'              => $data['ticket'], 
            'description'         => $data['description'],
            'venue_name'          => $data['venue_name'],
            'venue_full_address'  => $data['venue_full_address']       
        ]);

        if($data['speakers']){
            $event->speakers()->attach($data['speakers']);
        }

        if($data['sponsers']){
            $event->sponsers()->attach($data['sponsers']);
        }

        return back()->with(['success', ' created.', 'id' => $event->id, 'title' => $event->title]);

    }

    /**
     * Display the specified resource.
     *
     * @param  numeric  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        abort_if(!auth()->user()->can('view events'), 403);
        $cat                = $event->category;
        $speakers           = $event->speakers;
        $speakers_count     = count($speakers);
        $sponsers           = $event->sponsers;
        $sponsers_count     = count($sponsers);
        return view('admin.events.show', compact('event', 'cat', 'speakers', 'speakers_count', 'sponsers', 'sponsers_count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  numeric  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        abort_if(!auth()->user()->can('update events'), 403);
        $categories         = Category::latest()->get();
        $new_speakers       = Speaker::latest()->get();
        $new_sponsers       = Sponser::latest()->get();

        $speakers           = $event->speakers;
        $sponsers           = $event->sponsers;
        $cat                = $event->category;
        return view('admin.events.edit', compact('event', 'categories', 'cat', 'speakers', 'sponsers', 'new_speakers', 'new_sponsers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  numeric  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        // dd($request->all());
        abort_if(!auth()->user()->can('update events'), 403);

        $data = $request->validate([
            'speakers'            => 'required|array',
            'sponsers'            => 'required|array',
            'title'               => 'required|string|min:2',
            'category'            => 'required|numeric', 
            'cover'               => 'nullable|file', 
            'sub_title'           => 'required|string', 
            'price'               => 'required|numeric', 
            'start'               => 'nullable|date', 
            'time'                => 'nullable', 
            'end'                 => 'nullable|date', 
            'book_before'         => 'nullable', 
            'ticket'              => 'required|numeric', 
            'description'         => 'required', 
            'venue_name'          => 'required|string', 
            'venue_full_address'  => 'required|string', 
        ]);


        if(request()->start){
            $start_date = ['start' => request()->start];
        } 
        if(request()->time){
            $start_time = ['time' => request()->time];
        } 
        if(request()->end){
            $end_date = ['end' => request()->end];
        } 
        if(request()->book_before){
            $book_before = ['book_before' =>request()->book_before];
        } 

        // dd($request->all());
        $file      = $request->file('cover'); 

        if($file){
            $allowedfileExtension = ['jpeg','jpg','png','gif'];
            // // foreach($files as $file){
            $filename  = $file->getClientOriginalName();

            $extension = $file->getClientOriginalExtension();

            $check     = in_array($extension, $allowedfileExtension);
            abort_if(!$check, 422);


            //Delete Prev File
            if($event->cover){
                File::delete([
                    public_path($event->cover)
                ]); 
            }

            if($event->thumbnail){
                File::delete([
                    public_path($event->thumbnail)
                ]); 
            }
            // dd($file);
            //Real Image;
            $basename  = Str::random();
            $original  = 'ev-' . $basename . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/events'), $original);
            $path = '/events/' . $original;     

            $coverArr = ['cover' => $path];
            $thumbArr = ['thumbnail' => $path];
            

        }

        // dd($request->all());
        $event = $event->update(array_merge([
            'user_id'         => auth()->user()->id,
            'category_id'         => $data['category'],
            'title'               => $data['title'],
            'slug'                => Str::slug($data['title']),
            'sub_title'           => $data['sub_title'], 
            'price'               => $data['price'],
            'ticket'              => $data['ticket'], 
            'description'         => $data['description'],
            'venue_name'          => $data['venue_name'],
            'venue_full_address'  => $data['venue_full_address']
        ], 
            $coverArr ?? [],
            $thumbArr ?? [],
            $start_date ?? [],
            $start_time ?? [],
            $end_date ?? [],
            $book_before ?? []
        ));


        if($data['speakers']){
            $event->speakers()->sync($data['speakers']);
        }

        if($data['sponsers']){
            $event->sponsers()->sync($data['sponsers']);
        }
       
        return redirect()->back()->with('success', 'Event updated.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  numeric  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        abort_if(!auth()->user()->can('delete events'), 403);

        if($event->cover){
            File::delete([
                public_path($event->cover)
            ]);
        };

        if($event->thumbnail){
            File::delete([
                public_path($event->thumbnail)
            ]);
        }

        $event->delete();
        return redirect()->route('events')->with('success', 'Event deleted.');
    }
}
