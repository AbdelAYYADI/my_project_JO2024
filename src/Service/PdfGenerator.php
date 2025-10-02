<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;

class PdfGenerator {

    private $domPdf;

    public function __construct() {
        
        $this->domPdf = new Dompdf();
        
        $pdfOptions = new Options();
        $pdfOptions->setDefaultPaperSize('A4');
        $pdfOptions->setDefaultPaperOrientation('portrait');
        $pdfOptions->setIsRemoteEnabled(true);

        $this->domPdf->setOptions($pdfOptions);
    }

    public function streamPdfFile($html, $nameFile) {
        ob_start();
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        return $this->domPdf->stream($nameFile);     
        ob_end_clean();
    }

    public function showPfdFile($html) : string {
        ob_start();
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        return $this->domPdf->output();
        ob_end_clean();
    }
}