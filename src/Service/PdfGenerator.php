<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;

class PdfGenerator {

    private $domPdf;

    public function __construct() {
        
        //Définir les options du document PDF
        $pdfOptions = new Options();
        $pdfOptions->setTempDir('/tmp');
        $pdfOptions->setDefaultPaperSize('A4');
        $pdfOptions->setDefaultPaperOrientation('landscape');
        $pdfOptions->setIsRemoteEnabled(true);

        $this->domPdf = new Dompdf($pdfOptions);
    }

    //Cette méthode télécharge le fichier PDF
    public function streamPdfFile($html, $filename) {
        
        ob_start();
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        return $this->domPdf->stream($filename);            
        ob_end_clean();
    }

    //Cette méthode ouvre le fichier PDF dans le navigateur
    public function showPdfFile($html) : string {
        ob_start();
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        return $this->domPdf->output();
        ob_end_clean();
    }
}