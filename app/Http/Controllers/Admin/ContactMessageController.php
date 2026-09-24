<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        $messages = ContactMessage::orderByRaw("status = 'unread' DESC")
            ->latest('created_at')
            ->paginate(15);

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message): View
    {
        if ($message->isUnread()) {
            $message->markAsRead();
        }

        return view('admin.messages.show', compact('message'));
    }

    public function download(ContactMessage $message): \Symfony\Component\HttpFoundation\StreamedResponse|RedirectResponse
    {
        if (!$message->attachment_path || !Storage::disk('public')->exists($message->attachment_path)) {
            return back()->with('erreur', 'La pièce jointe est introuvable sur le serveur.');
        }

        $extension = pathinfo($message->attachment_path, PATHINFO_EXTENSION);
        $safeName = \Illuminate\Support\Str::slug($message->nom_complet);
        $filename = 'Piece_jointe_' . ($safeName ?: 'contact') . ($extension ? '.' . $extension : '');

        return Storage::disk('public')->download($message->attachment_path, $filename);
    }

    public function toggleStatus(ContactMessage $message): RedirectResponse
    {
        $newStatus = $message->status === 'unread' ? 'read' : 'unread';
        $message->update(['status' => $newStatus]);

        return back()->with('succes', "Statut du message mis à jour : {$newStatus}.");
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        if ($message->attachment_path) {
            Storage::disk('public')->delete($message->attachment_path);
        }

        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('succes', 'Le message a été supprimé.');
    }
}
