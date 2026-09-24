<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_login_with_env_credentials(): void
    {
        $adminEmail = env('ADMIN_EMAIL', 'archkortete@gmail.com');
        $adminPassword = env('ADMIN_PASSWORD', 'admin1234');

        $user = User::where('email', $adminEmail)->first();
        $this->assertNotNull($user);

        $response = $this->post('/admin/login', [
            'email' => $adminEmail,
            'password' => $adminPassword,
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_admin_can_access_dashboard_and_crud(): void
    {
        $admin = User::first();
        $this->assertNotNull($admin);

        $this->actingAs($admin)->get('/admin')
            ->assertStatus(200)
            ->assertSee('Tableau de bord');

        $this->actingAs($admin)->get('/admin/articles')
            ->assertStatus(200)
            ->assertSee('Actualités du cabinet');

        $this->actingAs($admin)->get('/admin/opportunites')
            ->assertStatus(200)
            ->assertSee('Offres et opportunités');

        $this->actingAs($admin)->get('/admin/messages')
            ->assertStatus(200);

        $this->actingAs($admin)->get('/admin/candidatures')
            ->assertStatus(200);
    }

    public function test_admin_can_create_article_with_image_upload(): void
    {
        Storage::fake('public');
        $admin = User::first();

        $image = UploadedFile::fake()->image('chantier-test.jpg', 1600, 1000);

        $response = $this->actingAs($admin)->post('/admin/articles', [
            'title' => 'Nouvel article de test architectural',
            'tag' => 'Innovation',
            'excerpt' => 'Résumé du nouvel article de test pour le cabinet.',
            'body' => '<h3>Titre de section</h3><p>Contenu détaillé de l\'article.</p>',
            'status' => 'published',
            'reading_minutes' => 3,
            'cover_image' => $image,
        ]);

        $response->assertRedirect('/admin/articles');

        $this->assertDatabaseHas('articles', [
            'title' => 'Nouvel article de test architectural',
            'tag' => 'Innovation',
            'status' => 'published',
        ]);
    }

    public function test_admin_can_create_and_manage_opportunity(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->post('/admin/opportunites', [
            'title' => 'Architecte Conducteur de Travaux',
            'contract_type' => 'CDI',
            'location' => 'Lomé, Togo',
            'excerpt' => 'Recrutement d\'un conducteur de travaux pour projets d\'envergure.',
            'body' => '<p>Missions complètes et exigences du poste.</p>',
            'status' => 'published',
        ]);

        $response->assertRedirect('/admin/opportunites');

        $this->assertDatabaseHas('opportunities', [
            'title' => 'Architecte Conducteur de Travaux',
            'contract_type' => 'CDI',
            'status' => 'published',
        ]);
    }

    public function test_admin_can_view_and_update_contact_message(): void
    {
        $admin = User::first();

        $message = \App\Models\ContactMessage::create([
            'nom' => 'Koffi',
            'prenom' => 'Jean',
            'email' => 'jean.koffi@example.com',
            'telephone' => '+22890000000',
            'message' => 'Demande de devis pour un projet résidentiel.',
            'status' => 'unread',
        ]);

        $this->actingAs($admin)->get("/admin/messages/{$message->id}")
            ->assertStatus(200)
            ->assertSee('Demande de devis pour un projet résidentiel.');

        // Seeing the message automatically marks it as read
        $this->assertEquals('read', $message->fresh()->status);

        // Toggle back to unread
        $this->actingAs($admin)->post("/admin/messages/{$message->id}/toggle")
            ->assertRedirect();

        $this->assertEquals('unread', $message->fresh()->status);
    }

    public function test_admin_can_view_and_update_job_application_status(): void
    {
        $admin = User::first();

        $app = \App\Models\JobApplication::create([
            'nom' => 'Mensah',
            'prenom' => 'Komi',
            'email' => 'komi.mensah@example.com',
            'telephone' => '+22891234567',
            'poste_vise' => 'Architecte junior',
            'message' => 'Passionné par l\'architecture bioclimatique.',
            'cv_path' => 'candidatures/test_cv.pdf',
            'status' => 'unread',
        ]);

        $this->actingAs($admin)->get("/admin/candidatures/{$app->id}")
            ->assertStatus(200)
            ->assertSee('Passionné par l\'architecture bioclimatique.');

        $this->actingAs($admin)->patch("/admin/candidatures/{$app->id}/status", [
            'status' => 'contacted',
        ])->assertRedirect();

        $this->assertEquals('contacted', $app->fresh()->status);
    }

    public function test_admin_can_download_job_application_cv(): void
    {
        Storage::fake('public');
        $admin = User::first();

        $path = UploadedFile::fake()->create('mon_cv.pdf', 100, 'application/pdf')
            ->store('candidatures', 'public');

        $app = \App\Models\JobApplication::create([
            'nom' => 'Lawson',
            'prenom' => 'Eric',
            'email' => 'eric.lawson@example.com',
            'telephone' => '+22890001122',
            'poste_vise' => 'Architecte junior',
            'message' => 'Ma candidature.',
            'cv_path' => $path,
            'status' => 'unread',
        ]);

        $response = $this->actingAs($admin)->get("/admin/candidatures/{$app->id}/download");
        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->headers->get('content-disposition') ?? '', 'attachment'));
    }

    public function test_admin_can_download_contact_message_attachment(): void
    {
        Storage::fake('public');
        $admin = User::first();

        $path = UploadedFile::fake()->create('plan.pdf', 100, 'application/pdf')
            ->store('contacts', 'public');

        $message = \App\Models\ContactMessage::create([
            'nom' => 'Koffi',
            'prenom' => 'Jean',
            'email' => 'jean.koffi@example.com',
            'telephone' => '+22890000000',
            'message' => 'Demande avec plan.',
            'attachment_path' => $path,
            'status' => 'unread',
        ]);

        $response = $this->actingAs($admin)->get("/admin/messages/{$message->id}/download");
        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->headers->get('content-disposition') ?? '', 'attachment'));
    }

    public function test_download_redirects_with_error_when_file_is_missing(): void
    {
        $admin = User::first();

        $app = \App\Models\JobApplication::create([
            'nom' => 'Inconnu',
            'prenom' => 'Test',
            'email' => 'inconnu@example.com',
            'telephone' => '+22890000000',
            'poste_vise' => 'Architecte',
            'message' => 'Test manquant.',
            'cv_path' => 'candidatures/fichier_inexistant.pdf',
            'status' => 'unread',
        ]);

        $response = $this->actingAs($admin)->get("/admin/candidatures/{$app->id}/download");
        $response->assertRedirect();
        $response->assertSessionHas('erreur');
    }
}
