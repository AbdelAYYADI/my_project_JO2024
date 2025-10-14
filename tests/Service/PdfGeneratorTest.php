<?php

namespace App\Tests\Service;

use App\Service\PdfGenerator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class PdfGeneratorTest extends TestCase
{
    private PdfGenerator $pdfGenerator;

    protected function setUp(): void
    {
        $this->pdfGenerator = new PdfGenerator();
    }

    public function testShowPdfFile(): void
    {
        $html = '<h1>Test affichage PDF</h1>';
        $pdf = new PdfGenerator();

        $response = new Response($pdf->showPdfFile($html), 200, [
            'Content-Type' => 'application/pdf',
        ]);

        //dd($response);
        //dd($response->getContent());

        // Vérifie que c'est une réponse HTTP valide
        $this->assertInstanceOf(Response::class, $response);

        // Vérifie que le code HTTP est 200
        $this->assertEquals(200, $response->getStatusCode());

        // Vérifie que le type de contenu est application/pdf
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));

        // Vérifie que le contenu n'est pas vide
        $this->assertNotEmpty($response->getContent());

        // Optionnel : vérifier que le contenu commence par %PDF
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    
    public function testStreamPdfFile(): void
    {
        $html = '<h1>Test affichage PDF</h1>';
        $filename = 'test.pdf';

        $pdf = new PdfGenerator();
        // $this->pdfGenerator->streamPdfFile($html, $filename);

        $response = new Response($pdf->streamPdfFile($html, $filename), 200, [
            'Content-Type' => 'application/pdf',
        ]);
        //dd($response->getContent());

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
    }
    
}
