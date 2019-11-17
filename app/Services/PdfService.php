<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;

class PdfService
{
    private $pdf;

    //Give the complete full path to the PDF
    public function __construct($pdf = null)
    {
        $this->pdf = $pdf;
    }

    public function checkPdf() {
        return true;
    }

    public function storePdfBase64($pdf) {
        $data = explode(',', $pdf);
        $random = Str::random(40);

        Storage::disk('local')->put(env('STORAGE_PDF') . "/$random.pdf", base64_decode($data[1]));
        $path = storage_path('app/'. env('STORAGE_PDF') .'/' . $random . '.pdf');

        $this->pdf = $path;

        return $random . '.pdf';
    }

    public function splitPdf($page)
    {
        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->setSourceFile($this->pdf);
        $tplIdx = $pdf->importPage($page);
        $pdf->useTemplate($tplIdx);
        $pdf->Output($this->pdf, "F");
        $pdf->close();
    }
}