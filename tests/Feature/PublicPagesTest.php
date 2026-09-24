<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\JobApplication;
use App\Models\Opportunity;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    public function test_homepage_loads_successfully_with_articles(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee("K-ARCHITECTES");
        $response->assertSee("Concevoir avec justesse.");
        $response->assertSee("Construire avec maîtrise.");
        $response->assertSee("Architecture, ingénierie et conseil");
        $response->assertSee("Découvrir nos expertises");
        $response->assertSee("Voir nos réalisations");
        $response->assertSee("Réalisations à la une");
        $response->assertSee("Actualités");
    }

    public function test_cabinet_page_loads(): void
    {
        $response = $this->get('/le-cabinet');
        $response->assertStatus(200);
        $response->assertSee("Qui sommes-nous");
        $response->assertSee("Irénée KORTETE");
    }

    public function test_realisations_and_single_project_load(): void
    {
        $response = $this->get('/realisations');
        $response->assertStatus(200);
        $response->assertSee("Villa Agoè");

        $projectResponse = $this->get('/realisations/villa-agoe');
        $projectResponse->assertStatus(200);
        $projectResponse->assertSee("Villa de plain-pied");
    }

    public function test_legacy_html_redirects(): void
    {
        $this->get('/realisations.html')->assertRedirect('/realisations');
        $this->get('/actualites.html')->assertRedirect('/actualites');
        $this->get('/contact.html')->assertRedirect('/contact');
        $this->get('/projet-villa-agoe.html')->assertRedirect('/realisations/villa-agoe');
    }

    public function test_actualites_index_and_detail_with_social_sharing(): void
    {
        $article = Article::published()->first();
        $this->assertNotNull($article);

        $latestArticle = Article::published()->latest('published_at')->first();

        $indexResponse = $this->get('/actualites');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee($latestArticle->title);

        $detailResponse = $this->get('/actualites/' . $article->slug);
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee($article->title);
        $detailResponse->assertSee("wa.me");
        $detailResponse->assertSee("linkedin.com");
    }

    public function test_opportunities_index_and_detail(): void
    {
        $opp = Opportunity::published()->first();
        $this->assertNotNull($opp);

        $indexResponse = $this->get('/opportunites');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee($opp->title);

        $detailResponse = $this->get('/opportunites/' . $opp->slug);
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee($opp->title);
        $detailResponse->assertSee("Postuler à cette offre");
    }

    public function test_contact_form_submission_stores_in_database(): void
    {
        $response = $this->post('/contact', [
            'Nom' => 'Doe',
            'Prenom' => 'John',
            'email' => 'john.doe@example.com',
            'Telephone' => '+228 90 00 00 00',
            'Message' => 'Demande de devis pour une villa contemporaine.',
        ]);

        $response->assertRedirect('/contact?envoye=1');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'john.doe@example.com',
            'nom' => 'Doe',
            'status' => 'unread',
        ]);
    }

    public function test_job_application_submission_stores_cv_and_database_record(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('mon-cv.pdf', 500, 'application/pdf');

        $response = $this->post('/postuler', [
            'Nom' => 'Koffi',
            'Prenom' => 'Ablam',
            'email' => 'ablam.koffi@example.com',
            'Telephone' => '+228 91 23 45 67',
            'Poste_vise' => 'Architecte junior',
            'attachment' => $file,
            'Message' => 'Je souhaite rejoindre votre cabinet.',
        ]);

        $response->assertRedirect('/postuler?envoye=1');

        $this->assertDatabaseHas('job_applications', [
            'email' => 'ablam.koffi@example.com',
            'nom' => 'Koffi',
            'status' => 'unread',
        ]);
    }
}
