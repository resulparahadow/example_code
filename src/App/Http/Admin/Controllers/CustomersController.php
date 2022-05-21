<?php

namespace App\Http\Admin\Controllers;


use App\Http\BaseController;
use Domain\Clients\Models\Client;
use Domain\Users\Models\User;
use Illuminate\Http\Request;

class CustomersController extends BaseController
{
    public function index(Request $r)
    {
        $customers = User::paginate();

        return view('admin.customers.index', compact('customers'));
    }

    public function view(Request $r)
    {
        $customer = User::whereId($r->id)->firstOrFail();

        return view('admin.customers.view', compact('customer'));
    }

    public function showCreateForm(Request $r)
    {
        return view('admin.customers.create-form');
    }

    public function create(Request $r)
    {
        $r->validate([
            'name' => 'required|min:2|max:100|alpha_dash|unique:clients,name',
            'type' => 'required|min:2|max:100'
        ]);

        User::create([
            'name'  => strtoupper($r->name),
            'type'  => $r->type,
            'token' => \Str::random(32)
       ]);

        return redirect()
                ->route('admin.client.list');
    }

    public function showUpdateForm(Request $r)
    {
        $client = User::whereId($r->id)->firstOrFail();

        return view('admin.clients.update-form', compact('client'));
    }

    public function update(Request $r)
    {
        $r->validate([
            'name' => 'required|min:2|max:100|alpha_dash',
            'type' => 'required|min:2|max:100'
        ]);

        $clientExists = User::whereName($r->name)->where('id', '!=', $r->id)->first();

        if ($clientExists) {
            return back()
                    ->withInput()
                    ->withErrors(['name' => 'name should be unique']);
        }

        $client = User::whereId($r->id)->firstOrFail();

        $client->name = strtoupper($r->name);
        $client->type = $r->type;
        $client->save();

        return redirect()
                ->route('admin.client.list');
    }

    public function delete(Request $r)
    {
        User::whereId($r->id)->delete();

        return redirect()
                ->route('admin.client.list')
                ->with("Client successfully deleted");
    }
}
