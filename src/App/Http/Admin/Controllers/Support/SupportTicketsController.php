<?php

namespace App\Http\Admin\Controllers\Support;

use App\Http\Controller;
use Domain\Support\Models\SupportTicket as Ticket;
use Illuminate\Http\Request;
use Domain\Payments\Models\Payment;

class SupportTicketsController extends Controller
{
    public function index(Request $r)
    {
        $tickets = Ticket::with('openedUser')
                ->with('closedUser')
                ->when($r->state, fn ($q, $v) => $q->whereState($v))
                ->paginate();

        return view('admin.support.index', compact('tickets'));
    }

    public function view(Request $r)
    {
        $ticket = Ticket::where('id', $r->id)->firstOrFail();

        return view('admin.support.view', compact('ticket'));
    }

    public function createForm(Request $r)
    {
        $payment = Payment::whereUuid($r->payment_uuid)->first();

        return view('admin.support.create-form', compact('payment'));
    }

    public function create(Request $r)
    {
        $r->validate([
            'type'         => 'required',
            'description'  => 'required|min:3|max:1000'
        ]);

        $ticket = Ticket::open([
            'payment_uuid' => $r->payment_uuid ?? null,
            'type'         => $r->type,
            'description'  => $r->description,
            'opened_by'    => currentAdmin()->id,
        ]);

        return redirect()
                ->route('admin.support.tickets.list')
                ->with("New ticket created");
    }

    public function updateForm(Request $r)
    {
        $ticket = Ticket::where('id', $r->id)->firstOrFail();

        return view('admin.support.update-form', compact('ticket'));
    }

    public function update(Request $r)
    {
        $r->validate([
            'payment_uuid' => 'required',
            'type'         => 'required',
            'description'  => 'required|min:3|max:1000'
        ]);

        $ticket = Ticket::where('id', $r->id)->firstOrFail();

        $ticket->update([
            'payment_uuid' => $r->payment_uuid,
            'type'         => $r->type,
            'description'  => $r->description
        ]);

        return redirect()
                ->route('admin.support.tickets.list')
                ->with(["success" => "Ticket #{$ticket->id} updated"]);
    }

    public function close(Request $r)
    {
        $ticket = Ticket::where('id', $r->id)->firstOrFail();

        $ticket->close();

        return redirect()
                ->route('admin.support.tickets.list')
                ->with("Ticket #{$ticket->id} successfully closed");
    }
}
