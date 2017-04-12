<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Request;
use Session;
use DateTime;
use Redirect;

use App\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return View('pages.index')
            ->with('pages', $pages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = new Page;
        $page_last_id = $page->create([
            'user_id' => Auth::id()
        ])->id;

        return Redirect::action(
            'PageController@edit', ['id' => $page_last_id]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("pages.show")
            ->with("page", Page::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.edit')
            ->with('page', Page::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::find($id);

        $page->update([
            'user_id' => Auth::id(),

            'company_name' => Request::get('company_name'),
            'description' => Request::get('description'),
            'phone' => Request::get('phone'),
            'email' => Request::get('email'),
            'address' => Request::get('address'),

            'offer' => Request::get('offer'),
            'bullets' => Request::get('bullets'),
            'video' => Request::get('video'),

            'lead_magnet' => Request::get('lead_magnet'),
            'call_to_action' => Request::get('call_to_action'),

            'legal_information' => Request::get('legal_information'),

            'lead_magnet_file' => Request::get('lead_magnet_file'),
            'subdomain' => Request::get('subdomain'),
            'title' => Request::get('title'),
            'redirect' => Request::get('redirect')
        ]);

        if (Request::hasFile('background_image')) {
            $extension = Request::file('background_image')->getClientOriginalExtension();
            $upload_path = public_path('files\\' . $page->id);
            $file_name = 'bg.' . $extension;
            Request::file('background_image')->move($upload_path, $file_name);

            $page->update([
                'background_image' => $file_name
            ]);
        }

        if (Request::hasFile('lead_magnet_file')) {
            $extension = Request::file('lead_magnet_file')->getClientOriginalExtension();

            $upload_path = public_path('files\\' . $page->id);
            //$file_name = $now->format('Y-m-d-H-i-s') . '.' . $extension;
            $file_name = 'Document.' . $extension;
            Request::file('lead_magnet_file')->move($upload_path, $file_name);

            $page->update([
                'lead_magnet_file' => $file_name
            ]);
        }

        Session::flash('success', 'Страница создана.');

        return Redirect::to("/pages/$page->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateajax(Request $request) {
        $page = Page::find(Request::get("id"));
        $page->update([
            Request::get("namei") => Request::get("valuei")
        ]);
        return Request::get("valuei");
    }

    public function updateajaximage(Request $request) {
        if (Request::hasFile('background_image')) {
            $page = Page::find(Request::get('id'));

            $now = new DateTime();
            $extension = Request::file('background_image')->getClientOriginalExtension();

            $upload_path = public_path('files\\' . $page->id);
            //$file_name = $now->format('Y-m-d-H-i-s') . '.' . $extension;
            $file_name = 'bg.' . $extension;
            Request::file('background_image')->move($upload_path, $file_name);


            $page->update([
                'background_image' => $file_name
            ]);
        }
    }

    public function updateajaxfile(Request $request) {
        if (Request::hasFile('lead_magnet_file')) {
            $page = Page::find(Request::get('id'));

            $now = new DateTime();
            $extension = Request::file('lead_magnet_file')->getClientOriginalExtension();

            $upload_path = public_path('files\\' . $page->id);
            //$file_name = $now->format('Y-m-d-H-i-s') . '.' . $extension;
            $file_name = 'Document.' . $extension;
            Request::file('lead_magnet_file')->move($upload_path, $file_name);


            $page->update([
                'lead_magnet_file' => $file_name
            ]);
        }
    }
}
